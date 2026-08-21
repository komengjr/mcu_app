@extends('layouts.template')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.2.4/css/buttons.dataTables.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<link href="{{ asset('asset/css/pace.min.css') }}" rel="stylesheet" />
<script src="{{ asset('asset/js/pace.min.js') }}"></script>

<style>
    /* Custom Styling Card MCU Modern & Keren */
    .mcu-card {
        /* background: #ffffff; */
        border: 1px solid rgba(226, 232, 240, 0.8) !important;
        border-radius: 16px !important;
        position: relative;
        transition: all 0.35s cubic-bezier(0.165, 0.84, 0.44, 1);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03), 0 1px 3px rgba(0, 0, 0, 0.02) !important;
        overflow: hidden;
    }

    /* Accent Bar di Sisi Kiri Card */
    .mcu-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 5px;
        height: 100%;
        background: linear-gradient(180deg, #2c7be5 0%, #00d27a 100%);
        transition: all 0.35s ease;
    }

    /* Hover Effect: Elevation, Dynamic Glow Shadow & Border Highlight */
    .mcu-card:hover {
        transform: translateY(-5px);
        border-color: rgba(44, 123, 229, 0.3) !important;
        box-shadow: 0 12px 28px rgba(44, 123, 229, 0.12), 0 4px 10px rgba(0, 0, 0, 0.04) !important;
    }

    .mcu-card:hover::before {
        width: 7px;
        background: linear-gradient(180deg, #e63757 0%, #2c7be5 100%);
    }

    /* Styling Stat Box Kuantitatif */
    .stat-box {
        border-radius: 12px;
        padding: 10px 12px;
        transition: all 0.25s ease;
        border: 1px solid rgba(0, 0, 0, 0.03);
    }

    .stat-box:hover {
        transform: scale(1.02);
    }

    /* Action Grid & Square Button Styling */
    .btn-action-grid {
        display: grid;
        grid-template-columns: repeat(5, minmax(0, 1fr));
        gap: 8px;
        width: 100%;
    }

    .btn-sq {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        aspect-ratio: 1 / 1;
        border-radius: 12px;
        padding: 6px;
        font-size: 0.72rem;
        font-weight: 600;
        text-decoration: none !important;
        border: 1px solid transparent;
        transition: all 0.25s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .btn-sq i {
        font-size: 1.15rem;
        margin-bottom: 4px;
        transition: transform 0.25s ease;
    }

    .btn-sq:hover {
        transform: translateY(-3px) scale(1.05);
        box-shadow: 0 6px 14px rgba(0, 0, 0, 0.08);
    }

    .btn-sq:hover i {
        transform: scale(1.2);
    }

    /* Varian Warna Tombol Kotak */
    .btn-sq-excel {
        background-color: #e8f5e9;
        color: #2e7d32;
        border-color: #c8e6c9;
    }

    .btn-sq-excel:hover {
        background-color: #2e7d32;
        color: #ffffff;
    }

    .btn-sq-peserta {
        background-color: #e3f2fd;
        color: #1565c0;
        border-color: #bbdefb;
    }

    .btn-sq-peserta:hover {
        background-color: #1565c0;
        color: #ffffff;
    }

    .btn-sq-rekap {
        background-color: #ffebee;
        color: #c62828;
        border-color: #ffcdd2;
    }

    .btn-sq-rekap:hover {
        background-color: #c62828;
        color: #ffffff;
    }

    .btn-sq-export {
        background-color: #e0f7fa;
        color: #00838f;
        border-color: #b2ebf2;
    }

    .btn-sq-export:hover {
        background-color: #00838f;
        color: #ffffff;
    }

    .btn-sq-live {
        background-color: #f3e5f5;
        color: #6a1b9a;
        border-color: #e1bee7;
    }

    .btn-sq-live:hover {
        background-color: #6a1b9a;
        color: #ffffff;
    }

    /* Responsivitas Layar Kecil */
    @media (max-width: 575.98px) {
        .btn-action-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }
</style>
@endsection

@section('content')
<!-- Header Banner Medis -->
<div class="row mb-3">
    <div class="col-12">
        <div class="card bg-white shadow-sm border-0 rounded-3 overflow-hidden position-relative">
            <div class="card-body px-4">
                <div class="row align-items-center">
                    <div class="col-md-7 d-flex align-items-center">
                        <div class="p-3 bg-soft-primary rounded-3 text-primary me-3">
                            <i class="fas fa-heartbeat fa-2x"></i>
                        </div>
                        <div>
                            <span class="badge bg-soft-danger text-danger rounded-pill px-2 py-1 mb-1 fw-semibold fs--2">
                                <i class="fas fa-hospital-user me-1"></i> Medical Check Up Dashboard
                            </span>
                            <h3 class="fw-bold text-900 mb-1">Monitoring Medical Check Up</h3>
                            <p class="text-600 mb-0 fs--1">Pantau progress, rekapitulasi, dan statistik kesehatan karyawan secara realtime.</p>
                        </div>
                    </div>
                    <div class="col-md-5 text-md-end mt-3 mt-md-0 d-none d-md-block">
                        <img src="{{ asset('img/company.png') }}" alt="Logo" class="me-2" style="max-height: 48px;" />
                        <img src="{{ asset('asset/img/illustrations/crm-line-chart.png') }}" alt="Chart" style="max-height: 60px;" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Toolbar Filter & Search -->
<div class="card mb-3 shadow-sm border-0 rounded-3" style="font-family: 'Calibri', sans-serif;">
    <div class="card-body py-3">
        <div class="row flex-between-center g-3">
            <div class="col-sm-auto d-flex align-items-center" id="loading-download">
                <div class="badge bg-soft-info text-info rounded-pill px-3 py-2 fs--1">
                    <i class="fas fa-folder-open me-1"></i> <span id="text-total-project">Showing 0 Project</span>
                </div>
            </div>
            <div class="col-sm-auto">
                <div class="position-relative" style="min-width: 280px;">
                    <input class="form-control form-control-sm rounded-pill ps-4 search-input fuzzy-search"
                        type="search"
                        id="carimcu"
                        onkeyup="searchMCU(this)"
                        placeholder="Cari MOU / Nama Perusahaan..."
                        aria-label="Search" />
                    <i class="fas fa-search position-absolute top-50 start-0 translate-middle-y ms-3 text-400 fs--1"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Container List Card MCU -->
<div class="card border-0 shadow-none bg-transparent" style="font-family: 'Calibri', sans-serif;">
    <div class="card-body p-0">
        <div class="row g-0" id="menu-monitoring-mcu">
            <!-- Spinner Loading Awal -->
            <div class="col-12 text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2 text-600 fs--1">Memuat data monitoring MCU...</p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<div class="modal fade" id="modal-monitoring" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 95%;">
        <div class="modal-content border-0 shadow-lg rounded-3">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" id="close-modal-monitoring" aria-label="Close"></button>
            </div>
            <div id="menu-monitoring"></div>
        </div>
    </div>
</div>

<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.4/js/dataTables.buttons.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.4/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.4/js/buttons.print.min.js"></script>
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        loadDataMCU();
    });

    function loadDataMCU() {
        $.ajax({
            url: "{{ route('monitoring_mcu_get_data') }}",
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}"
            },
            dataType: "json",
            success: function(res) {
                if (res.status === 'success') {
                    $('#text-total-project').text('Showing ' + res.data.length + ' Project');
                    renderCardMCU(res.data);
                } else {
                    $('#menu-monitoring-mcu').html('<div class="col-12"><div class="alert alert-danger m-3"><i class="fas fa-exclamation-triangle me-2"></i>Gagal mengambil data.</div></div>');
                }
            },
            error: function() {
                $('#menu-monitoring-mcu').html('<div class="col-12"><div class="alert alert-danger m-3"><i class="fas fa-wifi me-2"></i>Terjadi kesalahan pada server.</div></div>');
            }
        });
    }

    function renderCardMCU(data) {
        if (data.length === 0) {
            $('#menu-monitoring-mcu').html(`
                <div class="col-12 text-center py-5">
                    <i class="fas fa-folder-open fa-3x text-300 mb-3"></i>
                    <p class="text-500 mb-0">Tidak ada data project MCU ditemukan.</p>
                </div>
            `);
            return;
        }

        let html = '';
        data.forEach(item => {
            const pct = parseFloat(item.persentase) || 0;
            let progressColor = 'bg-danger';
            if (pct >= 80) progressColor = 'bg-success';
            else if (pct >= 40) progressColor = 'bg-warning';

            html += `
            <div class="col-12">
                <!-- Card MCU dengan Border Accent & Modern Glow Shadow -->
                <div class="card mcu-card mb-3">
                    <div class="card-body p-3 p-md-4">
                        <div class="row align-items-center g-3">

                            <!-- Col 1: Logo, Informasi MOU & Perusahaan -->
                            <div class="col-lg-3 border-lg-end border-200">
                                <div class="d-flex align-items-center">
                                    <div class="position-relative me-3 flex-shrink-0">
                                        <img class="rounded-3 fit-cover shadow-sm border border-200" src="{{ asset('img/company/mcu.jpg') }}" alt="MCU" width="65" height="65" onerror="this.src='https://via.placeholder.com/65?text=MCU'" />
                                        <span class="badge rounded-pill bg-success position-absolute top-0 start-0 translate-middle badge-sm shadow-sm">
                                            <i class="fas fa-file-contract"></i> MOU
                                        </span>
                                    </div>
                                    <div>
                                        <h6 class="mb-1 fw-bold fs-0 text-primary">
                                            <a href="#!" class="text-dark hover-primary">${item.company_mou_name}</a>
                                        </h6>
                                        <p class="fs--1 mb-1 text-600">
                                            <i class="fas fa-building text-400 me-1"></i>${item.master_company_name}
                                        </p>
                                        <span class="badge bg-soft-success text-success fs--2 rounded-pill px-2 py-1">
                                            <i class="fas fa-calendar-alt me-1"></i>${item.start_date} - ${item.end_date}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Col 2: Metric Stat Boxes & Progress Bar -->
                            <div class="col-lg-5 border-lg-end border-200">
                                <div class="row g-2 text-center mb-2">
                                    <div class="col-4">
                                        <div class="stat-box bg-soft-primary">
                                            <div class="fs--2 text-primary fw-bold text-uppercase"><i class="fas fa-users me-1"></i>Total</div>
                                            <div class="fs-0 fs-md-1 fw-bolder text-primary">${item.total}</div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <a href="#" id="button-sudah-mcu" data-code="${item.company_mou_code}" data-bs-toggle="modal" data-bs-target="#modal-monitoring" class="text-decoration-none">
                                            <div class="stat-box bg-soft-success border border-success border-opacity-25">
                                                <div class="fs--2 text-success fw-bold text-uppercase"><i class="fas fa-user-check me-1"></i>Sudah</div>
                                                <div class="fs-0 fs-md-1 fw-bolder text-success">${item.total_mcu}</div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-4">
                                        <a href="#" id="button-belum-mcu" data-code="${item.company_mou_code}" data-bs-toggle="modal" data-bs-target="#modal-monitoring" class="text-decoration-none">
                                            <div class="stat-box bg-soft-warning border border-warning border-opacity-25">
                                                <div class="fs--2 text-warning fw-bold text-uppercase"><i class="fas fa-user-clock me-1"></i>Belum</div>
                                                <div class="fs-0 fs-md-1 fw-bolder text-warning">${item.sisa_mcu}</div>
                                            </div>
                                        </a>
                                    </div>
                                </div>

                                <!-- Progress Bar Persentase -->
                                <div class="mt-2 px-1">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="fs--2 fw-bold text-600"><i class="fas fa-tasks me-1"></i>Progress MCU</span>
                                        <span class="fs--1 fw-bolder text-primary">${item.persentase}% Completed</span>
                                    </div>
                                    <div class="progress shadow-none" style="height: 8px; border-radius: 6px; background-color: #edf2f7;">
                                        <div class="progress-bar ${progressColor} progress-bar-striped progress-bar-animated" role="progressbar" style="width: ${pct}%;" aria-valuenow="${pct}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Col 3: Grid Tombol Action Kotak -->
                            <div class="col-lg-4">
                                <div class="btn-action-grid">
                                    <a href="#!" class="btn-sq btn-sq-excel" id="button-download-data-excel" data-code="${item.company_mou_code}" title="Download Excel">
                                        <i class="fas fa-file-excel"></i>
                                        <span>Excel</span>
                                    </a>
                                    <a href="#!" class="btn-sq btn-sq-peserta" id="button-detail-peserta" data-bs-toggle="modal" data-bs-target="#modal-monitoring" data-code="${item.company_mou_code}" title="Detail Peserta">
                                        <i class="fas fa-user-injured"></i>
                                        <span>Peserta</span>
                                    </a>
                                    <a href="#!" class="btn-sq btn-sq-rekap" id="button-rekap-full-peserta" data-bs-toggle="modal" data-bs-target="#modal-monitoring" data-code="${item.company_mou_code}" title="Rekapitulasi">
                                        <i class="fas fa-notes-medical"></i>
                                        <span>Rekap</span>
                                    </a>
                                    <a href="#!" class="btn-sq btn-sq-export" id="button-detail-full-peserta" data-bs-toggle="modal" data-bs-target="#modal-monitoring" data-code="${item.company_mou_code}" title="Export Full">
                                        <i class="fas fa-file-export"></i>
                                        <span>Export</span>
                                    </a>
                                    <a href="#!" class="btn-sq btn-sq-live" id="button-live-mcu-peserta" data-code="${item.company_mou_code}" title="Live MCU Monitoring">
                                        <i class="fas fa-heartbeat"></i>
                                        <span>Live MCU</span>
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>`;
        });

        $('#menu-monitoring-mcu').html(html);
    }

    // Modal Handlers & fungsi pencarian
    $(document).on("click", "#button-detail-peserta", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        showModalLoading();
        $.ajax({
            url: "{{ route('monitoring_mcu_detail') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-monitoring').html(data);
        }).fail(function() {
            $('#menu-monitoring').html('<div class="p-4 text-center text-danger"><i class="fas fa-exclamation-circle me-1"></i> Gagal memuat data.</div>');
        });
    });

    $(document).on("click", "#button-belum-mcu", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        showModalLoading();
        $.ajax({
            url: "{{ route('monitoring_mcu_detail_belum') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-monitoring').html(data);
        }).fail(function() {
            $('#menu-monitoring').html('<div class="p-4 text-center text-danger"><i class="fas fa-exclamation-circle me-1"></i> Gagal memuat data.</div>');
        });
    });

    $(document).on("click", "#button-sudah-mcu", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        showModalLoading();
        $.ajax({
            url: "{{ route('monitoring_mcu_detail_sudah') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-monitoring').html(data);
        }).fail(function() {
            $('#menu-monitoring').html('<div class="p-4 text-center text-danger"><i class="fas fa-exclamation-circle me-1"></i> Gagal memuat data.</div>');
        });
    });

    $(document).on("click", "#button-print-peserta", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        showModalLoading();
        $.ajax({
            url: "{{ route('monitoring_mcu_rekap') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-monitoring').html('<iframe src="data:application/pdf;base64, ' + data + '" style="width:100%; height:533px;" frameborder="0"></iframe>');
        }).fail(function() {
            $('#menu-monitoring').html('<div class="p-4 text-center text-danger"><i class="fas fa-exclamation-circle me-1"></i> Gagal memuat data.</div>');
        });
    });

    $(document).on("click", "#button-rekap-full-peserta", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        showModalLoading();
        $.ajax({
            url: "{{ route('monitoring_mcu_rekap_full') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-monitoring').html(data);
        }).fail(function() {
            $('#menu-monitoring').html('<span class="badge bg-warning m-4">Gagal memuat modal.</span>');
        });
    });

    $(document).on("click", "#button-detail-full-peserta", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        showModalLoading();
        $.ajax({
            url: "{{ route('monitoring_mcu_rekap_full_detail') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-monitoring').html(data);
        });
    });

    $(document).on("click", "#button-download-data-excel", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        let timerInterval;
        Swal.fire({
            title: "Mohon Menunggu!",
            html: "Mengeksport data MCU...",
            timer: 2000,
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading();
            },
            willClose: () => {
                clearInterval(timerInterval);
            }
        });
        $.ajax({
            url: "{{ route('monitoring_mcu_rekap_download_excel') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            window.location.href = data;
        });
    });

    $(document).on("click", "#button-live-mcu-peserta", function(e) {
        e.preventDefault();

        var code = $(this).data("code");

        // Generate URL route Laravel dengan mengganti placeholder :code
        var url = "{{ route('monitoring_mcu_live_mcu_peserta_company', ':code') }}";
        url = url.replace(':code', code);

        // Tampilkan SweetAlert Loading
        Swal.fire({
            title: 'Memuat Data...',
            text: 'Membuka halaman live monitoring',
            allowOutsideClick: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading();

                // Beri jeda singkat agar indikator loading sempat terlihat oleh user
                setTimeout(function() {
                    // Buka di tab baru
                    window.open(url, '_blank');

                    // Tutup alert setelah halaman baru terbuka
                    Swal.close();
                }, 800);
            }
        });
    });

    var searchTimer = null;

    function searchMCU(element) {
        var keyword = $(element).val();

        $('#menu-monitoring-mcu').html(`
            <div class="col-12 text-center py-5">
                <div class="spinner-border text-primary" role="status"></div>
                <p class="mt-2 text-600 fs--1">Mencari project MCU...</p>
            </div>
        `);

        clearTimeout(searchTimer);

        searchTimer = setTimeout(function() {
            $.ajax({
                url: "{{ route('monitoring_mcu_cari_nama') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": keyword
                },
                dataType: 'json',
                success: function(res) {
                    if (res.status === 'success') {
                        $('#text-total-project').text('Showing ' + res.data.length + ' Project');
                        renderCardMCU(res.data);
                    } else {
                        $('#menu-monitoring-mcu').html('<div class="col-12"><div class="alert alert-danger m-3">Gagal memuat hasil pencarian.</div></div>');
                    }
                },
                error: function() {
                    $('#menu-monitoring-mcu').html('<div class="col-12"><div class="alert alert-danger m-3">Terjadi kesalahan pada server.</div></div>');
                }
            });
        }, 400);
    }

    $(document).on("click", "#button-monitoring-pilih-paket", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        var id = $(this).data("id");
        $('#peserta-monitoring-mcu').html('<div class="spinner-border my-3 d-block mx-auto text-primary" role="status"><span class="visually-hidden">Loading...</span></div>');
        $.ajax({
            url: "{{ route('monitoring_mcu_rekap_full_detail_paket') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code,
                "id": id
            },
            dataType: 'html',
        }).done(function(data) {
            $('#peserta-monitoring-mcu').html(data);
        }).fail(function() {
            $('#peserta-monitoring-mcu').html('eror');
        });
    });

    function showModalLoading() {
        $('#menu-monitoring').html(`
            <div class="text-center py-5">
                <div class="spinner-border text-primary" role="status"></div>
                <p class="mt-2 text-600 fs--1">Memuat data...</p>
            </div>
        `);
    }
</script>
@endsection
