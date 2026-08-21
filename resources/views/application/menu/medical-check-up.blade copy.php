@extends('layouts.template')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.2.4/css/buttons.dataTables.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<style>
    .mcu-card {
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        transition: all 0.25s ease-in-out;
        /* background: #ffffff; */
    }

    .mcu-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08) !important;
        border-color: #cbd5e1;
    }

    .mcu-card-img-wrapper {
        position: relative;
        height: 140px;
        overflow: hidden;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
    }

    .mcu-card-img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .mcu-badge-status {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 0.65rem;
        padding: 4px 8px;
        border-radius: 20px;
        font-weight: 600;
    }

    .search-box-minimal {
        border-radius: 20px;
        padding-left: 35px;
        font-size: 0.85rem;
        border: 1px solid #cbd5e1;
    }

    .search-icon-wrapper {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 0.85rem;
    }

    /* Memastikan card tidak memotong (crop) dropdown yang keluar dari area card */
    .mcu-card {
        position: relative;
        overflow: visible !important;
        /* Izinkan dropdown keluar dari batas card */
    }

    /* Mengatur z-index card saat di-hover/diklik agar berada di atas card lainnya */
    .mcu-card:hover,
    .mcu-card:focus-within {
        z-index: 10 !important;
    }

    /* Memastikan dropdown menu selalu berada di paling atas */
    .mcu-card .dropdown-menu {
        z-index: 1050 !important;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15) !important;
    }
</style>
@endsection

@section('content')
<!-- Header Minimalis -->
<div class="row mb-3">
    <div class="col">
        <div class="card bg-200 shadow-sm border border-danger">
            <div class="row gx-0 flex-between-center">
                <div class="col-sm-auto d-flex align-items-center border-bottom border-sm-0 p-3">
                    <img class="me-3" src="{{ asset('img/company.png') }}" alt="" width="45" />
                    <div>
                        <h6 class="text-danger fs--1 mb-0">Welcome to</h6>
                        <h4 class="text-danger fw-bold mb-0">MCU <span class="fw-medium">Management System</span></h4>
                    </div>
                </div>
                <div class="col-xl-auto px-3 py-2 text-sm-end">
                    <span class="badge bg-danger-subtle text-danger px-3 py-2 rounded-pill fw-semibold">
                        <i class="fas fa-stethoscope me-1"></i> Medical Check Up Project
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Pencarian & Counter Minimalis -->
<div class="card mb-3 shadow-sm border-0">
    <div class="card-body p-3">
        <div class="row align-items-center justify-content-between g-2">
            <div class="col-auto">
                <div class="d-flex align-items-center gap-2">
                    <span class="fw-bold text-dark fs--1">Total Project:</span>
                    <span class="badge bg-primary rounded-pill" id="projectCount">{{ $data->count() }}</span>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4">
                <div class="position-relative">
                    <i class="fas fa-search search-icon-wrapper"></i>
                    <input type="text" id="searchInput" class="form-control form-control-sm search-box-minimal" placeholder="Cari nama project / perusahaan...">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Cards Grid -->
<div class="card mb-3 border-0 bg-transparent">
    <div class="card-body p-0">
        <div class="row g-3" id="mcuCardContainer">
            @foreach ($data as $datas)
            <div class="col-md-6 col-lg-4 col-xl-3 mcu-card-item"
                data-company="{{ strtolower($datas->company_mou_name) }}"
                data-master="{{ strtolower($datas->master_company_name) }}">

                <div class="card mcu-card h-100 shadow-sm d-flex flex-column justify-content-between">
                    <div>
                        <!-- Image & Badge -->
                        <div class="mcu-card-img-wrapper">
                            <img src="{{ asset('img/company/mcu.jpg') }}" alt="MCU Project" />
                            <span class="badge bg-success mcu-badge-status shadow-sm">
                                <i class="fas fa-check-circle me-1"></i> Available
                            </span>
                        </div>

                        <!-- Card Content -->
                        <div class="p-3">
                            <h6 class="fw-bold text-dark text-truncate mb-1" title="{{ $datas->company_mou_name }}">
                                {{ $datas->company_mou_name }}
                            </h6>
                            <p class="fs--2 text-500 text-truncate mb-2" title="{{ $datas->master_company_name }}">
                                <i class="far fa-building me-1"></i>{{ $datas->master_company_name }}
                            </p>

                            <hr class="my-2 text-200" />

                            @php
                            $total = DB::table('company_mou_peserta')
                            ->where('company_mou_code', $datas->company_mou_code)
                            ->count();
                            @endphp

                            <div class="d-flex justify-content-between align-items-center fs--2 mb-1">
                                <span class="text-600"><i class="fas fa-users me-1 text-primary"></i> Total Peserta:</span>
                                <span class="fw-bold text-dark">{{ $total }} Orang</span>
                            </div>

                            <div class="d-flex justify-content-between align-items-center fs--2">
                                <span class="text-600"><i class="far fa-calendar-alt me-1 text-success"></i> Periode:</span>
                                <span class="fw-semibold text-success">
                                    {{ date('d/m/Y', strtotime($datas->company_mou_start)) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Card Footer Action Buttons -->
                    <div class="p-3 pt-0">
                        <div class="d-flex gap-2">
                            <!-- Utama: Process Button -->
                            <a class="btn btn-sm btn-primary flex-grow-1 d-flex align-items-center justify-content-center gap-1 rounded-2 shadow-none"
                                href="#!" data-bs-toggle="modal" data-bs-target="#modal-mcu"
                                id="button-proses-check-up" data-code="{{ $datas->company_mou_code }}" title="Proses Check Up">
                                <i class="fas fa-user-check fs--2"></i> <span>Proses</span>
                            </a>

                            <!-- Dropdown Menu Option -->
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary rounded-2 px-2" type="button"
                                    id="dropdownMenu{{ $loop->index }}" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end shadow-sm border-0 fs--1" aria-labelledby="dropdownMenu{{ $loop->index }}">
                                    <button class="dropdown-item py-1 text-secondary" data-bs-toggle="modal"
                                        data-bs-target="#modal-mcu-xl" id="button-monitoring-peserta-all-mcu"
                                        data-code="{{ $datas->company_mou_code }}">
                                        <i class="fas fa-map-marked-alt text-info me-2"></i> Monitoring Lokasi
                                    </button>

                                    <button class="dropdown-item py-1 text-secondary" data-bs-toggle="modal"
                                        data-bs-target="#modal-mcu" id="button-data-monitoring-peserta-mcu"
                                        data-code="{{ $datas->company_mou_code }}">
                                        <i class="fas fa-file-invoice text-warning me-2"></i> Status Pemeriksaan
                                    </button>

                                    <div class="dropdown-divider my-1"></div>

                                    <button class="dropdown-item py-1 text-secondary" data-bs-toggle="modal"
                                        data-bs-target="#modal-mcu-xl" id="button-preview-kehadiran-peserta-mcu"
                                        data-code="{{ $datas->company_mou_code }}">
                                        <i class="fas fa-file-alt text-success me-2"></i> Preview Kehadiran
                                    </button>

                                    <button class="dropdown-item py-1 text-secondary" data-bs-toggle="modal"
                                        data-bs-target="#modal-mcu-xl" id="button-kehadiran-peserta-mcu"
                                        data-code="{{ $datas->company_mou_code }}">
                                        <i class="fas fa-file-contract text-primary me-2"></i> Report Kehadiran
                                    </button>

                                    <div class="dropdown-divider my-1"></div>

                                    <button class="dropdown-item py-1 text-secondary" data-bs-toggle="modal"
                                        data-bs-target="#modal-mcu-xl" id="button-proses-summary-check-up"
                                        data-code="{{ $datas->company_mou_code }}">
                                        <i class="fas fa-upload text-danger me-2"></i> Upload Summary
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            @endforeach
        </div>

        <!-- Empty State Jika Tidak Ditemukan -->
        <div id="noDataAlert" class="text-center py-5 d-none">
            <i class="fas fa-search-minus text-400 fs-4 mb-2"></i>
            <p class="text-600 mb-0">Project / Perusahaan tidak ditemukan.</p>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<div class="modal fade" id="modal-mcu" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document" style="max-width: 95%;">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-mcu"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-mcu-xl" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-mcu-xl"></div>
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

<!-- JS Realtime Filter Pencarian Card -->
<script>
    $(document).ready(function() {
        $('#searchInput').on('keyup', function() {
            var value = $(this).val().toLowerCase().trim();
            var visibleCount = 0;

            $('.mcu-card-item').each(function() {
                var companyName = $(this).data('company');
                var masterName = $(this).data('master');

                if (companyName.indexOf(value) > -1 || masterName.indexOf(value) > -1) {
                    $(this).fadeIn(200);
                    visibleCount++;
                } else {
                    $(this).fadeOut(100);
                }
            });

            $('#projectCount').text(visibleCount);

            if (visibleCount === 0) {
                $('#noDataAlert').removeClass('d-none');
            } else {
                $('#noDataAlert').addClass('d-none');
            }
        });
    });
</script>

<!-- AJAX Handlers -->
<script>
    $(document).on("click", "#button-proses-check-up", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-mcu').html('<div class="spinner-border my-4 d-block mx-auto text-primary" role="status"></div>');
        $.ajax({
            url: "{{ route('medical_check_up_detail') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-mcu').html(data);
        }).fail(function() {
            $('#menu-mcu').html('<div class="alert alert-danger m-3">Gagal memuat data.</div>');
        });
    });

    $(document).on("click", "#button-add-peserta-mcu", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-mcu-xl').html('<div class="spinner-border my-4 d-block mx-auto text-primary" role="status"></div>');
        $.ajax({
            url: "{{ route('medical_check_up_add_pesertal') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-mcu-xl').html(data);
        }).fail(function() {
            $('#menu-mcu-xl').html('<div class="alert alert-danger m-3">Gagal memuat data.</div>');
        });
    });

    $(document).on("click", "#button-monitoring-peserta-all-mcu", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-mcu-xl').html('<div class="spinner-border my-4 d-block mx-auto text-primary" role="status"></div>');
        $.ajax({
            url: "{{ route('medical_check_up_data_mointoring_all_peserta') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-mcu-xl').html(data);
        }).fail(function() {
            $('#menu-mcu-xl').html('<div class="alert alert-danger m-3">Gagal memuat data.</div>');
        });
    });

    $(document).on("click", "#button-data-monitoring-peserta-mcu", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-mcu').html('<div class="spinner-border my-4 d-block mx-auto text-primary" role="status"></div>');
        $.ajax({
            url: "{{ route('medical_check_up_data_mointoring_peserta') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-mcu').html(data);
        }).fail(function() {
            $('#menu-mcu').html('<div class="alert alert-danger m-3">Gagal memuat data.</div>');
        });
    });

    $(document).on("click", "#button-proses-summary-check-up", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-mcu-xl').html('<div class="spinner-border my-4 d-block mx-auto text-primary" role="status"></div>');
        $.ajax({
            url: "{{ route('medical_check_up_summary') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-mcu-xl').html(data);
        }).fail(function() {
            $('#menu-mcu-xl').html('<div class="alert alert-danger m-3">Gagal memuat data.</div>');
        });
    });

    $(document).on("click", "#button-preview-kehadiran-peserta-mcu", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-mcu-xl').html('<div class="spinner-border my-4 d-block mx-auto text-primary" role="status"></div>');
        $.ajax({
            url: "{{ route('medical_check_up_preview_cetak_absensi') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-mcu-xl').html(data);
        }).fail(function() {
            $('#menu-mcu-xl').html('<div class="alert alert-danger m-3">Gagal memuat data.</div>');
        });
    });

    $(document).on("click", "#button-kehadiran-peserta-mcu", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-mcu-xl').html('<div class="spinner-border my-4 d-block mx-auto text-primary" role="status"></div>');
        $.ajax({
            url: "{{ route('medical_check_up_prosess_cetak_absensi') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-mcu-xl').html(data);
        }).fail(function() {
            $('#menu-mcu-xl').html('<div class="alert alert-danger m-3">Gagal memuat data.</div>');
        });
    });
</script>
@endsection
