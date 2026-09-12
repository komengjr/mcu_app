<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $namaPos }} ({{ $pos_code }}) - {{ $mou->company_mou_name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        body {
            background-color: #f1f5f9;
            font-family: sans-serif;
        }

        .card-active {
            border-left: 5px solid #0ea5e9;
        }

        .queue-big {
            font-size: 3.5rem;
            font-weight: 800;
            color: #0ea5e9;
        }
    </style>
</head>

<body class="p-3">

    <div class="container-fluid">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-3 bg-white p-3 rounded shadow-sm">
            <div>
                <h3 class="mb-0 fw-bold text-primary">{{ $namaPos }}</h3>
                <div class="text-muted small">
                    <span class="fw-semibold text-dark">KODE POS: {{ $pos_code }}</span> |
                    MOU: {{ $mou->company_mou_name }} |
                    Operator ID: {{ $cabang }}
                </div>
            </div>
            <span class="badge bg-success px-3 py-2 fs-6" id="status-pos-badge">POS READY</span>
        </div>

        <div class="row g-3">
            <!-- Panel Kiri: Panggilan Aktif -->
            <div class="col-md-5">
                <div class="card card-active shadow-sm h-100">
                    <div class="card-header bg-white fw-bold"><i class="fas fa-bullhorn text-warning me-2"></i>PASIEN DIPANGGIL / DIPERIKSA</div>
                    <div class="card-body text-center d-flex flex-column justify-content-between" id="active-card-body">
                        <div class="my-auto">
                            <small class="text-muted uppercase fw-bold">Nomor Antrian</small>
                            <div class="queue-big my-2" id="cur-queue">---</div>
                            <h4 class="fw-bold mb-1" id="cur-name">Belum Ada Pasien</h4>
                            <p class="text-muted" id="cur-dept">-</p>
                        </div>

                        <div class="pt-3 border-top" id="action-buttons">
                            <button class="btn btn-secondary w-100 mb-2" disabled>Menunggu Panggilan...</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Panel Kanan: Daftar Antrian Menunggu, Dilewati, & Selesai -->
            <div class="col-md-7">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-white">
                        <ul class="nav nav-tabs card-header-tabs">
                            <li class="nav-item">
                                <a class="nav-link active fw-bold" data-bs-toggle="tab" href="#tab-waiting">
                                    Menunggu <span class="badge bg-danger rounded-pill" id="count-waiting">0</span>
                                </a>
                            </li>
                            <!-- TAB KHUSUS DILEWATI / SKIP -->
                            <li class="nav-item">
                                <a class="nav-link fw-bold text-warning" data-bs-toggle="tab" href="#tab-skipped">
                                    Dilewati <span class="badge bg-warning text-dark rounded-pill" id="count-skipped">0</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link fw-bold" data-bs-toggle="tab" href="#tab-finished">Selesai Hari Ini</a>
                            </li>
                        </ul>
                    </div>

                    <div class="card-body tab-content overflow-auto" style="max-height: 480px;">
                        <!-- Tab Menunggu -->
                        <div class="tab-pane fade show active" id="tab-waiting">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Pasien</th>
                                        <th>Departemen</th>
                                        <th class="text-end">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="tbl-waiting-body">
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">Memuat data...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Tab Dilewati / Skip -->
                        <div class="tab-pane fade" id="tab-skipped">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Pasien</th>
                                        <th>Departemen</th>
                                        <th class="text-end">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="tbl-skipped-body">
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">Belum ada antrian dilewatkan.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Tab Selesai -->
                        <div class="tab-pane fade" id="tab-finished">
                            <table class="table table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th>No Antrian</th>
                                        <th>Nama Pasien</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody id="tbl-finished-body">
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">Belum ada data.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        const cabang = "{{ $cabang }}";
        const mouCode = "{{ $mou_code }}";
        const posCode = "{{ $pos_code }}";

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2500,
            timerProgressBar: true
        });

        function loadOperatorData() {
            $.ajax({
                url: `/v3/operator/data/${cabang}/${mouCode}/${posCode}`,
                type: 'GET',
                success: function(res) {
                    if (res.status === 'success') {
                        // 1. Render Active Call Card
                        if (res.current) {
                            $('#cur-queue').text(res.current.nomor_antrian);
                            $('#cur-name').text(res.current.mou_peserta_name);
                            $('#cur-dept').text(res.current.mou_peserta_departemen || '-');

                            let btnHtml = '';
                            const idLogPos = res.current.id_log_pemanggilan;

                            if (res.current.status_antrian === 'Dipanggil') {
                                btnHtml = `
                                <div class="row g-2">
                                    <div class="col-6">
                                        <button class="btn btn-warning w-100 fw-bold" onclick="callRetry(${idLogPos})">
                                            <i class="fas fa-redo me-1"></i> Panggil Ulang (${res.current.panggilan_ke})
                                        </button>
                                    </div>
                                    <div class="col-6">
                                        <button class="btn btn-primary w-100 fw-bold" onclick="startProcess(${idLogPos})">
                                            <i class="fas fa-stethoscope me-1"></i> Mulai Periksa
                                        </button>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <button class="btn btn-outline-danger w-100" onclick="skipQueue(${idLogPos})">Lewatkan / Skip</button>
                                    </div>
                                </div>
                            `;
                            } else if (res.current.status_antrian === 'Sedang Diperiksa') {
                                btnHtml = `
                                <button class="btn btn-success w-100 fw-bold py-2 fs-5" onclick="finishProcess(${idLogPos})">
                                    <i class="fas fa-check-circle me-1"></i> SELESAI PEMERIKSAAN
                                </button>
                            `;
                            }
                            $('#action-buttons').html(btnHtml);
                        } else {
                            $('#cur-queue').text('---');
                            $('#cur-name').text('Belum Ada Pasien');
                            $('#cur-dept').text('-');
                            $('#action-buttons').html('<button class="btn btn-secondary w-100 mb-2" disabled>Pilih antrian di sebelah kanan untuk memanggil</button>');
                        }

                        // 2. Render Waiting Table
                        $('#count-waiting').text(res.waiting ? res.waiting.length : 0);
                        let htmlWait = '';
                        if (res.waiting && res.waiting.length > 0) {
                            $.each(res.waiting, function(i, item) {
                                htmlWait += `
                                <tr>
                                    <td class="fw-bold text-primary fs-5">${item.nomor_antrian}</td>
                                    <td class="fw-semibold">${item.mou_peserta_name}</td>
                                    <td><small class="text-muted">${item.mou_peserta_departemen || '-'}</small></td>
                                    <td class="text-end">
                                        <button class="btn btn-primary btn-sm fw-bold px-3" onclick="callNext(${item.log_antrian_id})">
                                            <i class="fas fa-bullhorn me-1"></i> Panggil
                                        </button>
                                    </td>
                                </tr>
                            `;
                            });
                        } else {
                            htmlWait = '<tr><td colspan="4" class="text-center text-muted py-4">Tidak ada antrian menunggu.</td></tr>';
                        }
                        $('#tbl-waiting-body').html(htmlWait);

                        // 3. Render Skipped / Dilewati Table
                        const skippedList = res.skipped || [];
                        $('#count-skipped').text(skippedList.length);
                        let htmlSkip = '';
                        if (skippedList.length > 0) {
                            $.each(skippedList, function(i, item) {
                                htmlSkip += `
                                <tr>
                                    <td class="fw-bold text-warning fs-5">${item.nomor_antrian}</td>
                                    <td class="fw-semibold">${item.mou_peserta_name}</td>
                                    <td><small class="text-muted">${item.mou_peserta_departemen || '-'}</small></td>
                                    <td class="text-end">
                                        <!-- Memanggil Ulang Pasien yang Pernah Di-skip -->
                                        <button class="btn btn-warning btn-sm fw-bold px-3 text-dark" onclick="callSkipped(${item.id_log_pemanggilan})">
                                            <i class="fas fa-redo me-1"></i> Panggil Kembali
                                        </button>
                                    </td>
                                </tr>
                            `;
                            });
                        } else {
                            htmlSkip = '<tr><td colspan="4" class="text-center text-muted py-4">Belum ada antrian dilewatkan.</td></tr>';
                        }
                        $('#tbl-skipped-body').html(htmlSkip);

                        // 4. Render Finished Table
                        let htmlFin = '';
                        if (res.finished && res.finished.length > 0) {
                            $.each(res.finished, function(i, item) {
                                htmlFin += `
                                <tr>
                                    <td class="fw-bold">${item.nomor_antrian}</td>
                                    <td>${item.mou_peserta_name}</td>
                                    <td><span class="badge bg-success">Selesai</span></td>
                                </tr>
                            `;
                            });
                        } else {
                            htmlFin = '<tr><td colspan="3" class="text-center text-muted py-4">Belum ada pasien selesai.</td></tr>';
                        }
                        $('#tbl-finished-body').html(htmlFin);
                    }
                }
            });
        }

        // Panggil Pertama Kali (Antrian Menunggu)
        function callNext(logAntrianId) {
            $.ajax({
                url: '/v3/operator/panggil',
                type: 'POST',
                data: {
                    log_antrian_id: logAntrianId,
                    pos_code: posCode,
                    operator_user_id: cabang
                },
                success: function(res) {
                    Toast.fire({
                        icon: 'success',
                        title: res.message || 'Berhasil memanggil antrian.'
                    });
                    loadOperatorData();
                },
                error: function(xhr) {
                    const res = xhr.responseJSON;
                    if (xhr.status === 422 || (res && res.status === 'warning')) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Peringatan',
                            text: res.message || 'Pasien sedang diperiksa di pos lain!',
                            confirmButtonColor: '#0ea5e9'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: (res && res.message) ? res.message : 'Terjadi kesalahan sistem.'
                        });
                    }
                }
            });
        }

        // Memanggil Kembali Pasien yang Ada di Tab Dilewati
        function callSkipped(idLogPos) {
            $.ajax({
                url: '/v3/operator/panggil-ulang',
                type: 'POST',
                data: {
                    id_log_pemanggilan: idLogPos
                },
                success: function(res) {
                    Toast.fire({
                        icon: 'info',
                        title: 'Pasien dilewatkan dipanggil kembali.'
                    });
                    loadOperatorData();
                },
                error: function(xhr) {
                    Swal.fire('Gagal', xhr.responseJSON?.message || 'Gagal memanggil antrian.', 'error');
                }
            });
        }

        function callRetry(idLogPos) {
            $.ajax({
                url: '/v3/operator/panggil-ulang',
                type: 'POST',
                data: {
                    id_log_pemanggilan: idLogPos
                },
                success: function(res) {
                    Toast.fire({
                        icon: 'info',
                        title: res.message || 'Panggilan ulang dikirim.'
                    });
                    loadOperatorData();
                },
                error: function(xhr) {
                    Swal.fire('Gagal', xhr.responseJSON?.message || 'Gagal memanggil ulang.', 'error');
                }
            });
        }

        function startProcess(idLogPos) {
            $.ajax({
                url: '/v3/operator/proses',
                type: 'POST',
                data: {
                    id_log_pemanggilan: idLogPos
                },
                success: function(res) {
                    Toast.fire({
                        icon: 'success',
                        title: res.message || 'Pemeriksaan dimulai.'
                    });
                    loadOperatorData();
                },
                error: function(xhr) {
                    Swal.fire('Gagal', xhr.responseJSON?.message || 'Gagal memulai pemeriksaan.', 'error');
                }
            });
        }

        function finishProcess(idLogPos) {
            $.ajax({
                url: '/v3/operator/selesai',
                type: 'POST',
                data: {
                    id_log_pemanggilan: idLogPos
                },
                success: function(res) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Selesai!',
                        text: res.message || 'Pemeriksaan pos telah selesai.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    loadOperatorData();
                },
                error: function(xhr) {
                    Swal.fire('Gagal', xhr.responseJSON?.message || 'Gagal menyelesaikan antrian.', 'error');
                }
            });
        }

        function skipQueue(idLogPos) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Antrian pasien ini akan dilewatkan!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Lewatkan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/v3/operator/skip',
                        type: 'POST',
                        data: {
                            id_log_pemanggilan: idLogPos
                        },
                        success: function(res) {
                            Toast.fire({
                                icon: 'warning',
                                title: res.message || 'Antrian dilewatkan.'
                            });
                            loadOperatorData();
                        },
                        error: function(xhr) {
                            Swal.fire('Gagal', xhr.responseJSON?.message || 'Gagal melewatkan antrian.', 'error');
                        }
                    });
                }
            });
        }

        setInterval(loadOperatorData, 3000);
        loadOperatorData();
    </script>
</body>

</html>
