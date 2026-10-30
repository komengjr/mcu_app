@extends('layouts.marketing')

@section('content')

<!-- Header Dashboard -->
<div class="d-sm-flex align-items-center justify-content-between bg-white p-3 p-md-4 shadow-sm rounded mb-3" style="border-left: 4px solid #4e73df;">
    <div class="mb-3 mb-sm-0">
        <h1 class="h3 mb-1 text-gray-800 font-weight-bold">
            <i class="fas fa-clipboard-check text-primary me-2"></i>Penilaian & Rekap KPI Staf Bulanan
        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small bg-transparent p-0">
                <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-muted"><i class="fas fa-home"></i> Dashboard</a></li>
                <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-muted">Marketing</a></li>
                <li class="breadcrumb-item active font-weight-bold text-primary" aria-current="page">Penilaian KPI Staf</li>
            </ol>
        </nav>
    </div>
</div>

<!-- Summary Widgets Rekap Bulanan -->
<div class="row g-3 mb-3">
    <div class="col-xl-4 col-md-6">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Staf Marketing</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="widgetTotalStaff">-</div>
                    </div>
                    <div class="col-auto"><i class="fas fa-users fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Sudah Evaluasi / Dinilai</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="widgetSudahDinilai">-</div>
                    </div>
                    <div class="col-auto"><i class="fas fa-check-circle fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Belum Evaluasi</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="widgetBelumDinilai">-</div>
                    </div>
                    <div class="col-auto"><i class="fas fa-clock fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Rekapitulasi -->
<div class="card shadow mb-3">
    <div class="card-body">
        <form id="filterForm" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label text-muted small mb-1">Pilih Bulan</label>
                <select name="bulan" id="filterBulan" class="form-select">
                    @foreach([1=>'Januari', 2=>'Februari', 3=>'Maret', 4=>'April', 5=>'Mei', 6=>'Juni', 7=>'Juli', 8=>'Agustus', 9=>'September', 10=>'Oktober', 11=>'November', 12=>'Desember'] as $num =>$namaBulan)
                    <option value="{{ $num }}" {{ $bulan == $num ? 'selected' : '' }}>{{ $namaBulan }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label text-muted small mb-1">Pilih Tahun</label>
                <input type="number" name="tahun" id="filterTahun" class="form-control" value="{{ $tahun }}">
            </div>
            <div class="col-md-4">
                <label class="form-label text-muted small mb-1">Filter Cabang</label>
                <select name="kode_cabang" id="filterCabang" class="form-select">
                    <option value="">Semua Cabang</option>
                    @foreach($cabangs as$c)
                    <option value="{{ $c->kode_cabang }}">{{ $c->nama_cabang }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100"><i class="fas fa-filter me-1"></i> Tampilkan</button>
            </div>
        </form>
    </div>
</div>

<!-- Tabel Rekap Penilaian Staf -->
<div class="card shadow mb-3 border-left-primary">
    <div class="card-header bg-white py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary" id="tableTitle">Rekapitulasi KPI Staf</h6>
        <button type="button" class="btn btn-sm btn-secondary shadow-sm" id="btnPrintAll">
            <i class="fas fa-print me-1"></i> Cetak Rekap All
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Staf Marketing</th>
                        <th>Jabatan</th>
                        <th>Cabang</th>
                        <th class="text-center">Skor Akhir KPI</th>
                        <th class="text-center">Predikat</th>
                        <th class="text-center">Status</th>
                        <th class="text-center" style="width: 180px;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tableStaffBody">
                    <tr>
                        <td colspan="7" class="text-center py-4"><i class="fas fa-spinner fa-spin me-2"></i>Memuat data...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Form Input Penilaian -->
<div class="modal fade" id="modalPenilaian" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form id="formPenilaian">
                @csrf
                <input type="hidden" name="marketing_staff_id" id="penilaianStaffId">
                <input type="hidden" name="bulan" id="modalBulan">
                <input type="hidden" name="tahun" id="modalTahun">

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title font-weight-bold">
                        <i class="fas fa-file-signature me-1"></i> <span id="modalHeaderTitle">Form Penilaian KPI Bulanan</span>
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Warning Periode Berlalu -->
                    <div id="alertLockPeriod" class="alert alert-warning d-none" role="alert">
                        <i class="fas fa-lock me-1"></i> <strong>Periode Terkunci:</strong> Periode ini sudah berlalu. Data penilaian tidak dapat diubah kembali.
                    </div>

                    <div class="alert alert-light border mb-3">
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Nama Staf:</strong> <span id="infoNamaStaff" class="text-primary font-weight-bold"></span>
                            </div>
                            <div class="col-md-6">
                                <strong>Jabatan:</strong> <span id="infoJabatanStaff" class="badge bg-secondary"></span>
                            </div>
                        </div>
                    </div>

                    <div id="modalPenilaianErrorAlert" class="alert alert-danger d-none">
                        <ul class="mb-0" id="errorPenilaianList"></ul>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Indikator KPI</th>
                                    <th style="width: 140px;">Target</th>
                                    <th style="width: 140px;">Realisasi / Hasil</th>
                                    <th style="width: 90px;">Satuan</th>
                                    <th style="width: 80px;" class="text-center">Bobot</th>
                                    <th style="width: 110px;" class="text-center">Capaian (%)</th>
                                    <th style="width: 120px;" class="text-center">Skor Terbobot</th>
                                </tr>
                            </thead>
                            <tbody id="containerFormKpi">
                                <!-- Dynamic Rows via JS -->
                            </tbody>
                            <tfoot class="table-light font-weight-bold">
                                <tr>
                                    <td colspan="5" class="text-end">TOTAL SKOR AKHIR KPI:</td>
                                    <td colspan="2" class="text-center">
                                        <span id="liveTotalSkor" class="h5 font-weight-bold text-primary mb-0">0.00%</span>
                                        <span id="livePredikat" class="badge bg-secondary ms-2">-</span>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Catatan / Evaluasi Supervisor</label>
                        <textarea name="catatan_evaluasi" id="catatan_evaluasi" class="form-control" rows="2" placeholder="Berikan saran / evaluasi kerja bulanan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" id="btnSimpanPenilaian" class="btn btn-primary px-4">Simpan Penilaian</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<script>
    $(document).ready(function() {

        let currentDate = new Date();
        let currentMonth = currentDate.getMonth() + 1;
        let currentYear = currentDate.getFullYear();

        function isPastPeriod(bulan, tahun) {
            bulan = parseInt(bulan);
            tahun = parseInt(tahun);
            if (tahun < currentYear) return true;
            if (tahun === currentYear && bulan < currentMonth) return true;
            return false;
        }

        // Fungsi Hitung Otomatis Real-time (Target & Realisasi -> Capaian & Skor)
        function calculateLiveKpi() {
            let totalSkor = 0;

            $('.kpi-row').each(function() {
                let bobot = parseFloat($(this).data('bobot')) || 0;
                let targetVal = parseFloat($(this).find('.input-target').val()) || 0;
                let realVal = parseFloat($(this).find('.input-real').val()) || 0;

                let capaian = targetVal > 0 ? (realVal / targetVal) * 100 : 0;
                let skorTerbobot = (capaian * bobot) / 100;

                totalSkor += skorTerbobot;

                $(this).find('.val-capaian').text(capaian.toFixed(2) + '\%');
                $(this).find('.val-skor-terbobot').text(skorTerbobot.toFixed(2) + '%');
            });

            $('#liveTotalSkor').text(totalSkor.toFixed(2) + '%');

            let predikat = 'Kurang';
            let badgeClass = 'bg-danger';

            if (totalSkor >= 90) {
                predikat = 'Sangat Baik';
                badgeClass = 'bg-success';
            } else if (totalSkor >= 75) {
                predikat = 'Baik';
                badgeClass = 'bg-primary';
            } else if (totalSkor >= 60) {
                predikat = 'Cukup';
                badgeClass = 'bg-warning text-dark';
            }

            $('#livePredikat').text(predikat).attr('class', 'badge ' + badgeClass);
        }

        // Event listener saat pengguna mengetik/mengubah nilai target atau realisasi
        $(document).on('input keyup change', '.input-target, .input-real', function() {
            calculateLiveKpi();
        });

        function loadDataPenilaian() {
            let bulan = $('#filterBulan').val();
            let tahun = $('#filterTahun').val();
            let kodeCabang = $('#filterCabang').val();

            let locked = isPastPeriod(bulan, tahun);

            $('#tableTitle').html(`Rekapitulasi KPI Staf - Periode: ${bulan}/${tahun} ${locked ? '<span class="badge bg-secondary ms-2"><i class="fas fa-lock me-1"></i> Terkunci</span>' : ''}`);
            $('#tableStaffBody').html('<tr><td colspan="7" class="text-center py-4"><i class="fas fa-spinner fa-spin me-2"></i>Memuat data staf...</td></tr>');

            $.ajax({
                url: "{{ route('marketing_penilaian.data', ['akses' => $akses]) }}",
                type: "GET",
                data: {
                    bulan: bulan,
                    tahun: tahun,
                    kode_cabang: kodeCabang
                },
                dataType: "json",
                success: function(res) {
                    if (res.success) {
                        $('#widgetTotalStaff').text(res.summary.totalStaff + ' Orang');
                        $('#widgetSudahDinilai').text(res.summary.sudahDinilai + ' Orang');
                        $('#widgetBelumDinilai').text(res.summary.belumDinilai + ' Orang');

                        let rows = '';
                        if (res.staffs.length === 0) {
                            rows = '<tr><td colspan="7" class="text-center text-muted py-4">Tidak ada data staf marketing.</td></tr>';
                        } else {
                            $.each(res.staffs, function(i, s) {
                                let statusHtml = s.penilaian ?
                                    '<span class="badge bg-success"><i class="fas fa-check-circle me-1"></i> Selesai</span>' :
                                    '<span class="badge bg-warning text-dark"><i class="fas fa-exclamation-circle me-1"></i> Belum Dinilai</span>';

                                let skorHtml = s.penilaian ?
                                    `<span class="${parseFloat(s.penilaian.total_skor_akhir) >= 75 ? 'text-success' : 'text-danger'}">${s.penilaian.total_skor_akhir}%</span>` :
                                    '<span class="text-muted">-</span>';

                                let badgeColor = 'bg-danger';
                                if (s.penilaian) {
                                    if (s.penilaian.predikat === 'Sangat Baik') badgeColor = 'bg-success';
                                    else if (s.penilaian.predikat === 'Baik') badgeColor = 'bg-primary';
                                    else if (s.penilaian.predikat === 'Cukup') badgeColor = 'bg-warning text-dark';
                                }

                                let predikatHtml = s.penilaian ?
                                    `<span class="badge ${badgeColor}">${s.penilaian.predikat}</span>` :
                                    '<span class="badge bg-light text-dark border">Belum Ada</span>';

                                let btnLabel = s.penilaian ? (locked ? 'Lihat Nilai' : 'Edit Nilai') : (locked ? 'Lihat Nilai' : 'Input Nilai');
                                let btnIcon = locked ? 'fa-eye' : 'fa-edit';
                                let btnClass = locked ? 'btn-outline-secondary' : 'btn-outline-primary';
                                let isBtnInputDisabled = locked && !s.penilaian ? 'disabled' : '';

                                let btnPrintPerson = s.penilaian ?
                                    `<button type="button" class="btn btn-sm btn-outline-info btn-print-person me-1" data-id="${s.id}" title="Cetak Rekap Staf"><i class="fas fa-print"></i></button>` :
                                    `<button type="button" class="btn btn-sm btn-outline-secondary me-1" disabled><i class="fas fa-print"></i></button>`;

                                rows += `
                                <tr>
                                    <td>
                                        <strong>${s.nama_lengkap}</strong><br>
                                        <small class="text-muted">NIK: ${s.nik}</small>
                                    </td>
                                    <td><span class="badge bg-secondary">${s.jabatan}</span></td>
                                    <td>${s.cabang}</td>
                                    <td class="text-center font-weight-bold h6 mb-0">${skorHtml}</td>
                                    <td class="text-center">${predikatHtml}</td>
                                    <td class="text-center">${statusHtml}</td>
                                    <td class="text-center">
                                        ${btnPrintPerson}
                                        <button type="button" class="btn btn-sm ${btnClass} btn-input-penilaian"
                                                data-id="${s.id}"
                                                data-nama="${s.nama_lengkap}"
                                                data-jabatan="${s.jabatan}" ${isBtnInputDisabled}>
                                            <i class="fas ${btnIcon} me-1"></i> ${btnLabel}
                                        </button>
                                    </td>
                                </tr>`;
                            });
                        }
                        $('#tableStaffBody').html(rows);
                    }
                },
                error: function() {
                    $('#tableStaffBody').html('<tr><td colspan="7" class="text-center text-danger py-4">Gagal memuat data dari server.</td></tr>');
                }
            });
        }

        // Jalankan fetch awal
        loadDataPenilaian();

        $('#filterForm').on('submit', function(e) {
            e.preventDefault();
            loadDataPenilaian();
        });

        $('#btnPrintAll').on('click', function() {
            let bulan = $('#filterBulan').val();
            let tahun = $('#filterTahun').val();
            let kodeCabang = $('#filterCabang').val();

            let urlPrint = "{{ url($akses . '/marketing/menu-marketing/penilaian/print-all') }}?bulan=" + bulan + "&tahun=" + tahun + "&kode_cabang=" + kodeCabang;
            window.open(urlPrint, '_blank');
        });

        $(document).on('click', '.btn-print-person', function() {
            let staffId = $(this).data('id');
            let bulan = $('#filterBulan').val();
            let tahun = $('#filterTahun').val();

            let urlPrint = "{{ url($akses . '/marketing/menu-marketing/penilaian/print-person') }}/" + staffId + "?bulan=" + bulan + "&tahun=" + tahun;
            window.open(urlPrint, '_blank');
        });

        // Event Buka Modal Form Penilaian
        $(document).on('click', '.btn-input-penilaian', function() {
            let staffId = $(this).data('id');
            let nama = $(this).data('nama');
            let jabatan = $(this).data('jabatan');
            let bulan = $('#filterBulan').val();
            let tahun = $('#filterTahun').val();

            let locked = isPastPeriod(bulan, tahun);

            $('#penilaianStaffId').val(staffId);
            $('#modalBulan').val(bulan);
            $('#modalTahun').val(tahun);
            $('#infoNamaStaff').text(nama);
            $('#infoJabatanStaff').text(jabatan);
            $('#containerFormKpi').html('<tr><td colspan="7" class="text-center py-3"><i class="fas fa-spinner fa-spin"></i> Memuat indikator...</td></tr>');
            $('#modalPenilaianErrorAlert').addClass('d-none');

            if (locked) {
                $('#alertLockPeriod').removeClass('d-none');
                $('#modalHeaderTitle').text('Detail Penilaian KPI Bulanan (Terkunci)');
                $('#btnSimpanPenilaian').addClass('d-none');
                $('#catatan_evaluasi').prop('readonly', true);
            } else {
                $('#alertLockPeriod').addClass('d-none');
                $('#modalHeaderTitle').text('Form Penilaian KPI Bulanan');
                $('#btnSimpanPenilaian').removeClass('d-none');
                $('#catatan_evaluasi').prop('readonly', false);
            }

            $('#modalPenilaian').modal('show');

            let getFormUrl = "{{ url($akses . '/marketing/menu-marketing/penilaian/get-form') }}/" + staffId;

            $.ajax({
                url: getFormUrl,
                type: "GET",
                data: {
                    bulan: bulan,
                    tahun: tahun
                },
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        let html = '';
                        let existingDetails = {};

                        if (response.penilaian && response.penilaian.details) {
                            $('#catatan_evaluasi').val(response.penilaian.catatan_evaluasi);
                            $.each(response.penilaian.details, function(i, det) {
                                existingDetails[det.kpi_id] = {
                                    target_standar: det.target_standar,
                                    pencapaian_real: det.pencapaian_real
                                };
                            });
                        } else {
                            $('#catatan_evaluasi').val('');
                        }

                        if (response.kpis.length === 0) {
                            html = `<tr><td colspan="7" class="text-center text-muted py-3">Belum ada indikator KPI yang di-setting untuk jabatan <strong>${jabatan}</strong>. Silakan atur di menu Marketing Setting.</td></tr>`;
                            $('#btnSimpanPenilaian').prop('disabled', true);
                        } else {
                            $('#btnSimpanPenilaian').prop('disabled', false);
                            $.each(response.kpis, function(index, kpi) {
                                let valTarget = (existingDetails[kpi.id] && existingDetails[kpi.id].target_standar !== undefined) ?
                                    existingDetails[kpi.id].target_standar :
                                    (kpi.target_standar || 0);

                                let valReal = (existingDetails[kpi.id] && existingDetails[kpi.id].pencapaian_real !== undefined) ?
                                    existingDetails[kpi.id].pencapaian_real :
                                    '';

                                let inputDisabled = locked ? 'readonly' : '';

                                html += `
                                <tr class="kpi-row" data-id="${kpi.id}" data-bobot="${kpi.bobot_persen}">
                                    <td>
                                        <strong>${kpi.nama_indikator}</strong>
                                        ${kpi.tipe_penilaian === 'Otomatis' ? '<br><small class="badge bg-info text-dark">Hitung Otomatis</small>' : ''}
                                    </td>
                                    <td>
                                        <input type="number" step="0.01" name="target_standar[${kpi.id}]" class="form-control form-control-sm input-target" value="${valTarget}" placeholder="0" ${inputDisabled} required>
                                    </td>
                                    <td>
                                        <input type="number" step="0.01" name="pencapaian_real[${kpi.id}]" class="form-control form-control-sm input-real" value="${valReal}" placeholder="0" ${inputDisabled} required>
                                    </td>
                                    <td><small class="text-muted">${kpi.satuan}</small></td>
                                    <td class="text-center font-weight-bold text-primary">${kpi.bobot_persen}%</td>
                                    <td class="text-center font-weight-bold val-capaian">0.00%</td>
                                    <td class="text-center font-weight-bold text-success val-skor-terbobot">0.00%</td>
                                </tr>`;
                            });
                        }
                        $('#containerFormKpi').html(html);

                        // Jalankan kalkulasi live awal setelah data dimuat
                        calculateLiveKpi();
                    }
                }
            });
        });

        // Submit Form Penilaian via AJAX
        $('#formPenilaian').on('submit', function(e) {
            e.preventDefault();
            let btnSimpan = $('#btnSimpanPenilaian');

            btnSimpan.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Menyimpan...');
            $('#modalPenilaianErrorAlert').addClass('d-none');

            $.ajax({
                url: "{{ route('marketing_penilaian.store', ['akses' => $akses]) }}",
                type: "POST",
                data: $(this).serialize(),
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        $('#modalPenilaian').modal('hide');
                        alert(response.message);
                        loadDataPenilaian();
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $('#errorPenilaianList').empty();
                        $.each(errors, function(key, value) {
                            $('#errorPenilaianList').append('<li>' + value[0] + '</li>');
                        });
                        $('#modalPenilaianErrorAlert').removeClass('d-none');
                    } else {
                        alert('Terjadi kesalahan sistem.');
                    }
                },
                complete: function() {
                    btnSimpan.prop('disabled', false).html('Simpan Penilaian');
                }
            });
        });
    });
</script>
@endsection
