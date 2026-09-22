<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $namaPos }} ({{ $pos_code }}) - {{$mou->company_mou_name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts: Orbitron untuk Nomor Antrian yang Menarik & Modern -->
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@700;900&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        body {
            background-color: #f8fafc;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #1e293b;
        }

        .card {
            border: none;
            border-radius: 1rem;
        }

        .card-active {
            border-left: 6px solid #0ea5e9;
            background: linear-gradient(135deg, #f0f9ff 0%, #ffffff 100%);
        }

        /* Tampilan Nomor Antrian yang Lebih Menarik dengan Font Orbitron */
        .queue-big {
            font-family: 'Orbitron', sans-serif;
            font-size: 4.2rem;
            font-weight: 900;
            color: #0284c7;
            letter-spacing: 2px;
            text-shadow: 2px 2px 4px rgba(14, 165, 233, 0.15);
        }

        .queue-badge-table {
            font-family: 'Orbitron', sans-serif;
            letter-spacing: 1px;
        }

        .search-box-container {
            position: relative;
        }

        .search-box-container i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
        }

        .search-box-container input {
            padding-left: 40px;
            border-radius: 50rem;
            background-color: #f1f5f9;
            border: 1px solid #e2e8f0;
            font-size: 0.875rem;
        }

        .search-box-container input:focus {
            background-color: #fff;
            box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.15);
            border-color: #0ea5e9;
        }

        .nav-tabs .nav-link {
            border: none;
            color: #64748b;
            border-radius: 50rem;
            padding: 0.5rem 1rem;
            transition: all 0.2s ease-in-out;
        }

        .nav-tabs .nav-link.active {
            background-color: #0ea5e9 !important;
            color: #fff !important;
            box-shadow: 0 4px 12px rgba(14, 165, 233, 0.3);
        }

        .table-hover tbody tr {
            transition: background-color 0.15s ease-in-out;
        }
    </style>
</head>

<body class="p-3 p-md-4">

    <div class="container-fluid">
        <!-- Header -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 bg-white p-4 rounded-4 shadow-sm gap-3">
            <div>
                <h3 class="mb-1 fw-bold text-dark"><i class="fas fa-hospital-user text-primary me-2"></i>{{ $namaPos }}</h3>
                <div class="text-muted small">
                    <span class="badge bg-light text-dark border fw-semibold px-2 py-1 me-2">KODE POS: {{ $pos_code }}</span>
                    <span class="me-2">| MOU: <strong>{{ $mou->company_mou_name }}</strong></span> |
                    <span class="ms-1">Operator ID: {{ $cabang }}</span>
                </div>
            </div>
            <span class="badge bg-success bg-gradient px-3 py-2 fs-6 rounded-pill shadow-sm" id="status-pos-badge"><i class="fas fa-circle fa-beat me-1" style="--fa-animation-duration: 2s;"></i> POS READY</span>
        </div>

        <div class="row g-4">
            <!-- Panel Kiri: Panggilan Aktif -->
            <div class="col-lg-5">
                <div class="card card-active shadow-sm h-100">
                    <div class="card-header bg-transparent fw-bold border-0 pt-4 px-4"><i class="fas fa-bullhorn text-warning me-2"></i>PASIEN DIPANGGIL / DIPERIKSA</div>
                    <div class="card-body text-center d-flex flex-column justify-content-between px-4 pb-4" id="active-card-body">
                        <div class="my-auto py-3">
                            <span class="badge bg-info-subtle text-info text-uppercase fw-bold px-3 py-1 rounded-pill mb-2">Nomor Antrian Aktif</span>
                            <div class="queue-big my-2" id="cur-queue">---</div>
                            <h4 class="fw-bold mb-1 text-dark" id="cur-name">Belum Ada Pasien</h4>
                            <p class="text-muted small mb-0" id="cur-dept">-</p>
                        </div>

                        <div class="pt-3 border-top border-light-subtle" id="action-buttons">
                            <button class="btn btn-secondary w-100 mb-2 rounded-pill py-2" disabled>Menunggu Panggilan...</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Panel Kanan: Daftar Antrian Menunggu, Dilewati, & Selesai -->
            <div class="col-lg-7">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-white pt-4 px-4 border-0">
                        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-3">
                            <!-- Nav Tabs -->
                            <ul class="nav nav-tabs border-0 bg-light p-1 rounded-pill" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active fw-bold small" data-bs-toggle="tab" href="#tab-waiting">
                                        Menunggu <span class="badge bg-danger rounded-pill ms-1" id="count-waiting">0</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link fw-bold small" data-bs-toggle="tab" href="#tab-skipped">
                                        Dilewati <span class="badge bg-warning text-dark rounded-pill ms-1" id="count-skipped">0</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link fw-bold small" data-bs-toggle="tab" href="#tab-finished">Selesai</a>
                                </li>
                            </ul>

                            <!-- Filter Pencarian Global / Tab -->
                            <div class="search-box-container" style="width: 220px;">
                                <i class="fas fa-search"></i>
                                <input type="text" id="search-queue-input" class="form-control" placeholder="Cari nama / no...">
                            </div>
                        </div>
                    </div>

                    <div class="card-body tab-content overflow-auto px-4" style="max-height: 440px;">
                        <!-- Tab Menunggu -->
                        <div class="tab-pane fade show active" id="tab-waiting">
                            <table class="table table-hover align-middle">
                                <thead class="table-light text-uppercase fs-7 text-muted">
                                    <tr>
                                        <th class="py-3 rounded-start">No</th>
                                        <th class="py-3">Nama Pasien</th>
                                        <th class="py-3">Departemen</th>
                                        <th class="py-3 text-end rounded-end">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="tbl-waiting-body">
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">Memuat data...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Tab Dilewati / Skip -->
                        <div class="tab-pane fade" id="tab-skipped">
                            <table class="table table-hover align-middle">
                                <thead class="table-light text-uppercase fs-7 text-muted">
                                    <tr>
                                        <th class="py-3 rounded-start">No</th>
                                        <th class="py-3">Nama Pasien</th>
                                        <th class="py-3">Departemen</th>
                                        <th class="py-3 text-end rounded-end">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="tbl-skipped-body">
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">Belum ada antrian dilewatkan.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Tab Selesai -->
                        <div class="tab-pane fade" id="tab-finished">
                            <table class="table table-hover align-middle">
                                <thead class="table-light text-uppercase fs-7 text-muted">
                                    <tr>
                                        <th class="py-3 rounded-start">No Antrian</th>
                                        <th class="py-3">Nama Pasien</th>
                                        <th class="py-3 rounded-end">Status</th>
                                    </tr>
                                </thead>
                                <tbody id="tbl-finished-body">
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-4">Belum ada data.</td>
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

        // Variabel global untuk menampung cache data antrian dari server agar pencarian berjalan instan
        let globalQueueData = {
            waiting: [],
            skipped: [],
            finished: []
        };

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
                        // Simpan ke cache global untuk fitur pencarian
                        globalQueueData.waiting = res.waiting || [];
                        globalQueueData.skipped = res.skipped || [];
                        globalQueueData.finished = res.finished || [];

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
                                        <button class="btn btn-warning w-100 fw-bold rounded-pill py-2 shadow-sm" onclick="callRetry(${idLogPos})">
                                            <i class="fas fa-redo me-1"></i> Panggil Ulang (${res.current.panggilan_ke})
                                        </button>
                                    </div>
                                    <div class="col-6">
                                        <button class="btn btn-primary w-100 fw-bold rounded-pill py-2 shadow-sm" onclick="startProcess(${idLogPos})">
                                            <i class="fas fa-stethoscope me-1"></i> Mulai Periksa
                                        </button>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <button class="btn btn-outline-danger w-100 rounded-pill py-2" onclick="skipQueue(${idLogPos})">Lewatkan / Skip</button>
                                    </div>
                                </div>
                            `;
                            } else if (res.current.status_antrian === 'Sedang Diperiksa') {
                                btnHtml = `
                                <button class="btn btn-success w-100 fw-bold py-2 fs-5 rounded-pill shadow-sm" onclick="finishProcess(${idLogPos})">
                                    <i class="fas fa-check-circle me-1"></i> SELESAI PEMERIKSAAN
                                </button>
                            `;
                            }
                            $('#action-buttons').html(btnHtml);
                        } else {
                            $('#cur-queue').text('---');
                            $('#cur-name').text('Belum Ada Pasien');
                            $('#cur-dept').text('-');
                            $('#action-buttons').html('<button class="btn btn-light text-muted w-100 mb-2 rounded-pill py-2 border" disabled>Pilih antrian di sebelah kanan untuk memanggil</button>');
                        }

                        // Render tabel berdasarkan isi search input saat ini
                        renderAllTables();
                    }
                }
            });
        }

        // Fungsi merender tabel dengan filter pencarian terintegrasi
        function renderAllTables() {
            const keyword = $('#search-queue-input').val().toLowerCase().trim();

            // 2. Render Waiting Table
            const filteredWaiting = globalQueueData.waiting.filter(item =>
                item.nomor_antrian.toLowerCase().includes(keyword) ||
                item.mou_peserta_name.toLowerCase().includes(keyword) ||
                (item.mou_peserta_departemen && item.mou_peserta_departemen.toLowerCase().includes(keyword))
            );

            $('#count-waiting').text(globalQueueData.waiting.length);
            let htmlWait = '';
            if (filteredWaiting.length > 0) {
                $.each(filteredWaiting, function(i, item) {
                    htmlWait += `
                    <tr>
                        <td class="fw-bold text-primary fs-5 queue-badge-table">${item.nomor_antrian}</td>
                        <td class="fw-semibold text-dark">${item.mou_peserta_name}</td>
                        <td><small class="text-muted">${item.mou_peserta_departemen || '-'}</small></td>
                        <td class="text-end">
                            <button class="btn btn-primary btn-sm fw-bold px-3 rounded-pill shadow-sm" onclick="callNext(${item.log_antrian_id})">
                                <i class="fas fa-bullhorn me-1"></i> Panggil
                            </button>
                        </td>
                    </tr>
                `;
                });
            } else {
                htmlWait = '<tr><td colspan="4" class="text-center text-muted py-4">Tidak ada antrian menunggu yang cocok.</td></tr>';
            }
            $('#tbl-waiting-body').html(htmlWait);

            // 3. Render Skipped Table
            const filteredSkipped = globalQueueData.skipped.filter(item =>
                item.nomor_antrian.toLowerCase().includes(keyword) ||
                item.mou_peserta_name.toLowerCase().includes(keyword) ||
                (item.mou_peserta_departemen && item.mou_peserta_departemen.toLowerCase().includes(keyword))
            );

            $('#count-skipped').text(globalQueueData.skipped.length);
            let htmlSkip = '';
            if (filteredSkipped.length > 0) {
                $.each(filteredSkipped, function(i, item) {
                    htmlSkip += `
                    <tr>
                        <td class="fw-bold text-warning fs-5 queue-badge-table">${item.nomor_antrian}</td>
                        <td class="fw-semibold text-dark">${item.mou_peserta_name}</td>
                        <td><small class="text-muted">${item.mou_peserta_departemen || '-'}</small></td>
                        <td class="text-end">
                            <button class="btn btn-warning btn-sm fw-bold px-3 text-dark rounded-pill shadow-sm" onclick="callSkipped(${item.id_log_pemanggilan})">
                                <i class="fas fa-redo me-1"></i> Panggil Kembali
                            </button>
                        </td>
                    </tr>
                `;
                });
            } else {
                htmlSkip = '<tr><td colspan="4" class="text-center text-muted py-4">Belum ada antrian dilewatkan yang cocok.</td></tr>';
            }
            $('#tbl-skipped-body').html(htmlSkip);

            // 4. Render Finished Table
            const filteredFinished = globalQueueData.finished.filter(item =>
                item.nomor_antrian.toLowerCase().includes(keyword) ||
                item.mou_peserta_name.toLowerCase().includes(keyword)
            );

            let htmlFin = '';
            if (filteredFinished.length > 0) {
                $.each(filteredFinished, function(i, item) {
                    htmlFin += `
                    <tr>
                        <td class="fw-bold queue-badge-table text-secondary">${item.nomor_antrian}</td>
                        <td class="fw-semibold text-dark">${item.mou_peserta_name}</td>
                        <td><span class="badge bg-success-subtle text-success px-2 py-1 rounded-pill">Selesai</span></td>
                    </tr>
                `;
                });
            } else {
                htmlFin = '<tr><td colspan="3" class="text-center text-muted py-4">Belum ada pasien selesai yang cocok.</td></tr>';
            }
            $('#tbl-finished-body').html(htmlFin);
        }

        // Event listener saat mengetik di kolom pencarian
        $('#search-queue-input').on('keyup input', function() {
            renderAllTables();
        });

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
