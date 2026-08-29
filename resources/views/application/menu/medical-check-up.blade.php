@extends('layouts.template')
@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.2.4/css/buttons.dataTables.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<style>
    /* Card Minimalis & Accent Modern */
    .card-mcu {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        border: 1px solid #e2e8f0 !important;
        /* background: #ffffff; */
        border-radius: 10px;
    }

    .card-mcu:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08) !important;
        border-color: #cbd5e1 !important;
    }

    .badge-company {
        background-color: #eff6ff;
        color: #1d4ed8;
        border: 1px solid #bfdbfe;
        font-weight: 600;
    }

    .badge-soft-primary {
        background-color: #e0f2fe;
        color: #0284c7;
    }

    .badge-soft-success {
        background-color: #dcfce7;
        color: #166534;
    }

    .mcu-detail-box {
        background-color: #f8fafc;
        border: 1px solid #f1f5f9;
        border-radius: 8px;
    }
</style>
@endsection

@section('content')
<!-- Header Welcome -->
<div class="row mb-3">
    <div class="col">
        <div class="card bg-200 shadow-sm border border-danger">
            <div class="row gx-0 flex-between-center">
                <div class="col-sm-auto d-flex align-items-center border-bottom border-sm-0">
                    <img class="ms-3 mx-3" src="{{ asset('img/company.png') }}" alt="" width="50" />
                    <div>
                        <h6 class="text-danger fs--1 mb-0 pt-2">Welcome to </h6>
                        <h4 class="text-danger fw-bold mb-1">MCU <span class="text-danger fw-medium">Management System</span></h4>
                    </div>
                    <img class="ms-n4 d-none d-lg-block " src="{{ asset('asset/img/illustrations/crm-line-chart.png') }}" alt="" width="150" />
                </div>
                <div class="col-xl-auto px-3 py-2">
                    <h6 class="text-danger fs--1 mb-0">Menu : </h6>
                    <h4 class="text-danger fw-bold mb-0">Medical <span class="text-danger fw-medium">Check Up</span></h4>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Select Perusahaan & Search Bar Card -->
<div class="card mb-3 shadow-sm border-0">
    <div class="card-body">
        <div class="row g-2 align-items-center justify-content-between">
            <!-- Filter Select Perusahaan -->
            <div class="col-md-5 col-sm-6">
                <label class="form-label fs--2 fw-bold text-600 mb-1" for="mcu-company-filter">
                    <i class="fas fa-building text-primary me-1"></i> Filter Perusahaan:
                </label>
                <select id="mcu-company-filter" class="form-select form-select-sm">
                    <option value="all">-- Semua Perusahaan --</option>
                    @php
                    $uniqueCompanies = $data->pluck('master_company_name')->unique()->filter();
                    @endphp
                    @foreach($uniqueCompanies as $company)
                    <option value="{{ strtolower($company) }}">{{ $company }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Live Search & Info -->
            <div class="col-md-5 col-sm-6">
                <div class="d-flex flex-column align-items-sm-end">
                    <label class="form-label fs--2 fw-bold text-600 mb-1">
                        Pencarian Agreement / Project:
                    </label>
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-white border-end-0 text-400">
                            <span class="fas fa-search"></span>
                        </span>
                        <input type="text" id="mcu-search-input" class="form-control border-start-0 ps-0" placeholder="Cari nama agreement...">
                    </div>
                </div>
            </div>

            <div class="col-12 mt-2 pt-2 border-top d-flex justify-content-between align-items-center">
                <span class="fs--1 text-600">
                    Menampilkan <span id="project-count" class="fw-bold text-primary">{{ $data->count() }}</span> Agreement
                </span>
                <button type="button" id="btn-reset-filter" class="btn btn-link text-danger p-0 fs--1 text-decoration-none d-none">
                    <i class="fas fa-undo me-1"></i>Reset Filter
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Container Card Grid -->
<div class="row g-3" id="mcu-card-container">
    @foreach ($data as $datas)
    @php
    $total = DB::table('company_mou_peserta')
    ->where('company_mou_code', $datas->company_mou_code)
    ->count();
    @endphp
    <div class="col-md-6 col-lg-4 col-xl-3 mcu-card-item"
        data-title="{{ strtolower($datas->company_mou_name) }}"
        data-company="{{ strtolower($datas->master_company_name) }}">

        <div class="card card-mcu h-100 shadow-sm d-flex flex-column justify-content-between p-3">
            <div>
                <!-- Header Perusahaan -->
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <span class="badge badge-company rounded-2 px-2 py-1 fs--1 text-truncate d-inline-flex align-items-center" style="max-width: 80%;" title="{{ $datas->master_company_name }}">
                        @php
                        $logoPath = 'uploads/company_logo/' . $datas->master_company_logo;
                        $hasLogo = !empty($datas->master_company_logo) && file_exists(public_path($logoPath));
                        @endphp

                        <img src="{{ asset($hasLogo ? $logoPath : 'uploads/company_logo/default-logo.png') }}"
                            alt="Logo {{ $datas->master_company_name }}"
                            class="me-1 rounded-1 bg-white p-2px"
                            style="width: 18px; height: 18px; object-fit: contain;">

                        <span class="text-truncate">{{ $datas->master_company_name }}</span>
                    </span>
                    <span class="badge badge-soft-success rounded-pill px-2 py-1 fs--2">
                        <i class="fas fa-check-circle me-1"></i>Active
                    </span>
                </div>

                <!-- Nama Agreement MOU -->
                <div class="mb-3">
                    <h6 class="fs-0 fw-bold mb-0 text-900 line-clamp-2" title="{{ $datas->company_mou_name }}">
                        <i class="fas fa-file-contract text-danger me-1"></i>{{ $datas->company_mou_name }}
                    </h6>
                    <small class="text-400 fs--2">Kode: {{ $datas->company_mou_code }}</small>
                </div>

                <!-- Detail MOU (Peserta & Periode) -->
                <div class="mcu-detail-box p-2 mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-1 fs--1">
                        <span class="text-600"><i class="fas fa-users text-primary me-1"></i>Total Peserta:</span>
                        <span class="badge badge-soft-primary rounded-pill px-2">{{ $total }} Peserta</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center fs--1">
                        <span class="text-600"><i class="fas fa-calendar-alt text-success me-1"></i>Periode MOU:</span>
                        <span class="fw-semibold text-700 fs--2">
                            {{ date('d/m/Y', strtotime($datas->company_mou_start)) }} - {{ date('d/m/Y', strtotime($datas->company_mou_end)) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Footer Action Buttons -->
            <div class="pt-2 border-top d-flex justify-content-between align-items-center">
                <button class="btn btn-sm btn-outline-danger rounded-pill px-3"
                    data-bs-toggle="modal"
                    data-bs-target="#modal-mcu"
                    id="button-proses-check-up"
                    data-code="{{ $datas->company_mou_code }}"
                    title="Proses Check Up">
                    <i class="fas fa-user-check me-1"></i> Proses
                </button>

                <div class="btn-group dropup">
                    <button class="btn btn-sm btn-light border rounded-pill dropdown-toggle"
                        type="button"
                        id="dropdownMenu-{{ $datas->company_mou_code }}"
                        data-bs-toggle="dropdown"
                        data-bs-display="static"
                        aria-expanded="false">
                        <i class="far fa-address-card text-600 me-1"></i> Option
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 fs--1"
                        style="z-index: 1050;"
                        aria-labelledby="dropdownMenu-{{ $datas->company_mou_code }}">
                        <li>
                            <button class="dropdown-item text-dark" data-bs-toggle="modal" data-bs-target="#modal-mcu-xl" id="button-monitoring-peserta-all-mcu" data-code="{{ $datas->company_mou_code }}">
                                <i class="fas fa-map-marked-alt text-info me-2"></i> Monitoring Lokasi Peserta
                            </button>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <button class="dropdown-item text-dark" data-bs-toggle="modal" data-bs-target="#modal-mcu" id="button-data-monitoring-peserta-mcu" data-code="{{ $datas->company_mou_code }}">
                                <i class="fas fa-file-invoice text-warning me-2"></i> Status Pemeriksaan Peserta
                            </button>
                        </li>
                        <li>
                            <button class="dropdown-item text-dark" data-bs-toggle="modal" data-bs-target="#modal-mcu-xl" id="button-preview-kehadiran-peserta-mcu" data-code="{{ $datas->company_mou_code }}">
                                <i class="fas fa-file-alt text-success me-2"></i> Preview Data Kehadiran
                            </button>
                        </li>
                        <li>
                            <button class="dropdown-item text-dark" data-bs-toggle="modal" data-bs-target="#modal-mcu-xl" id="button-kehadiran-peserta-mcu" data-code="{{ $datas->company_mou_code }}">
                                <i class="fas fa-file-contract text-primary me-2"></i> Report Data Kehadiran
                            </button>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#modal-mcu-xl" id="button-proses-summary-check-up" data-code="{{ $datas->company_mou_code }}">
                                <i class="fas fa-upload me-2"></i> Upload Summary
                            </button>
                        </li>
                        <li>
                            <button class="dropdown-item text-dark" data-bs-toggle="modal" data-bs-target="#modal-mcu-xl" id="button-pengisian-data-form" data-code="{{ $datas->company_mou_code }}">
                                <i class="fab fa-wpforms me-2"></i> Data Pengisian Form
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection

@section('base.js')
<div class="modal fade" id="modal-mcu" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document" style="max-width: 95%;">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-mcu"></div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-mcu-xl" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                    data-bs-dismiss="modal" aria-label="Close"></button>
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

<script>
    new DataTable('#example', {
        responsive: true
    });
</script>

<script>
    $(document).ready(function() {
        // Logika Filter Perusahaan & Search Bar
        function filterMCUData() {
            var selectedCompany = $('#mcu-company-filter').val();
            var searchValue = $('#mcu-search-input').val().toLowerCase().trim();
            var visibleCount = 0;

            if (selectedCompany !== 'all' || searchValue !== '') {
                $('#btn-reset-filter').removeClass('d-none');
            } else {
                $('#btn-reset-filter').addClass('d-none');
            }

            $('.mcu-card-item').each(function() {
                var cardCompany = ($(this).data('company') || '').toString().toLowerCase();
                var cardTitle = ($(this).data('title') || '').toString().toLowerCase();

                var isCompanyMatch = (selectedCompany === 'all' || cardCompany === selectedCompany);
                var isSearchMatch = (searchValue === '' || cardTitle.indexOf(searchValue) > -1 || cardCompany.indexOf(searchValue) > -1);

                if (isCompanyMatch && isSearchMatch) {
                    $(this).show();
                    visibleCount++;
                } else {
                    $(this).hide();
                }
            });

            $('#project-count').text(visibleCount);
        }

        // Trigger saat dropdown perusahaan berubah
        $('#mcu-company-filter').on('change', function() {
            filterMCUData();
        });

        // Trigger saat input pencarian diketik
        $('#mcu-search-input').on('keyup input', function() {
            filterMCUData();
        });

        // Reset Filter
        $('#btn-reset-filter').on('click', function() {
            $('#mcu-company-filter').val('all');
            $('#mcu-search-input').val('');
            filterMCUData();
        });
    });
</script>

<script>
    $(document).on("click", "#button-proses-check-up", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-mcu').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
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
            $('#menu-mcu').html('eror');
        });
    });
    $(document).on("click", "#button-add-peserta-mcu", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-mcu-xl').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
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
            $('#menu-mcu-xl').html('eror');
        });
    });
    $(document).on("click", "#button-monitoring-peserta-all-mcu", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-mcu-xl').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
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
            $('#menu-mcu-xl').html('eror');
        });
    });
    $(document).on("click", "#button-data-monitoring-peserta-mcu", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-mcu').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
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
            $('#menu-mcu').html('eror');
        });
    });
    $(document).on("click", "#button-proses-peserta-mcu", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-mcu-xl').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('medical_check_up_prosess') }}",
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
            $('#menu-mcu-xl').html('eror');
        });
    });
    $(document).on("click", "#button-proses-summary-check-up", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-mcu-xl').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
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
            $('#menu-mcu-xl').html('eror');
        });
    });
    $(document).on("click", "#button-proses-update-peserta-mcu", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-mcu-xl').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('medical_check_up_prosess_update') }}",
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
            $('#menu-mcu-xl').html('eror');
        });
    });
    $(document).on("click", "#button-generate-barcode-kehadiran", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-absensi-kehadiran').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('medical_check_up_prosess_generate_absensi') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-absensi-kehadiran').html(data);
        }).fail(function() {
            $('#menu-absensi-kehadiran').html('eror');
        });
    });
    $(document).on("click", "#button-tambah-pemeriksaan-peserta-mcu", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        var mou = $(this).data("mou");
        $('#data-table-pemeriksaan-peserta').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('medical_check_up_prosess_tambah_pemeriksaan') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code,
                "mou": mou
            },
            dataType: 'html',
        }).done(function(data) {
            $('#data-table-pemeriksaan-peserta').html(data);
        }).fail(function() {
            $('#data-table-pemeriksaan-peserta').html('eror');
        });
    });
    $(document).on("click", "#button-simpan-penambahan-pemeriksaan-peserta-mcu", function(e) {
        e.preventDefault();
        var peserta_code = document.getElementById("peserta_code").value;
        var mou_code = document.getElementById("mou_code").value;
        var pemeriksaan = document.getElementById("pemeriksaan").value;
        $('#data-table-pemeriksaan-peserta').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('medical_check_up_prosess_tambah_pemeriksaan_save') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "peserta_code": peserta_code,
                "mou_code": mou_code,
                "pemeriksaan": pemeriksaan,
            },
            dataType: 'html',
        }).done(function(data) {
            $('#data-table-pemeriksaan-peserta').html(data);
        }).fail(function() {
            $('#data-table-pemeriksaan-peserta').html('eror');
        });
    });
    $(document).on("click", "#button-remove-pemeriksaan-peserta-mcu", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        var pem = $(this).data("pem");
        $('#data-table-pemeriksaan-peserta').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('medical_check_up_prosess_tambah_pemeriksaan_remove') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code,
                "pem": pem,
            },
            dataType: 'html',
        }).done(function(data) {
            $('#data-table-pemeriksaan-peserta').html(data);
        }).fail(function() {
            $('#data-table-pemeriksaan-peserta').html('eror');
        });
    });
    $(document).on("click", "#button-preview-kehadiran-peserta-mcu", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-mcu-xl').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
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
            $('#menu-mcu-xl').html('eror');
        });
    });
    $(document).on("click", "#button-kehadiran-peserta-mcu", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-mcu-xl').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
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
            $('#menu-mcu-xl').html('eror');
        });
    });
    $(document).on("click", "#button-pilih-paket-mcu", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-table-peserta-mcu').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('medical_check_up_prosess_update_paket_mcu') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-table-peserta-mcu').html(data);
        }).fail(function() {
            $('#menu-table-peserta-mcu').html('eror');
        });
    });
    $(document).on("click", "#button-fix-pilih-paket-mcu", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        var paket = $(this).data("paket");
        $('#menu-table-peserta-mcu').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        console.log(paket);

        $.ajax({
            url: "{{ route('medical_check_up_prosess_update_paket_mcu_save') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code,
                "paket": paket,
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-table-peserta-mcu').html("");
            location.reload();
        }).fail(function() {
            $('#menu-table-peserta-mcu').html('eror');
        });
    });
    $(document).on("click", "#button-kirim-whatsapp-peserta-mcu", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        var peserta = $(this).data("id");
        $('#loading-proses-send-message').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('medical_check_up_send_message_whatsapp_peserta_mcu') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code,
                "peserta": peserta,
            },
            dataType: 'html',
        }).done(function(data) {
            $('#loading-proses-send-message').html(data);
            location.reload();
        }).fail(function() {
            $('#loading-proses-send-message').html('eror');
        });
    });
</script>

<script>
    $(document).on("click", "#button-cetak-data-kehadiran-peserta-mcu", function(e) {
        e.preventDefault();
        var page_data = document.getElementById("page_data").value;
        var code = $(this).data("code");

        if (page_data == "") {
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            Toast.fire({
                icon: "error",
                title: "Pilih Page Dulu Guys"
            });
        } else {
            $('#report-kehadiran-mcu').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('medical_check_up_prosess_cetak_absensi_mcu') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": code,
                    "page": page_data
                },
                dataType: 'html',
            }).done(function(data) {
                $('#report-kehadiran-mcu').html(
                    '<iframe src="data:application/pdf;base64, ' +
                    data +
                    '" style="width:100%; height:533px;" frameborder="0"></iframe>');
            }).fail(function() {
                $('#report-kehadiran-mcu').html('eror');
            });
        }
    });
</script>
<script>
    $(document).on("click", "#button-pengisian-data-form", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-mcu-xl').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('medical_check_up_data_pengisian_form') }}",
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
            $('#menu-mcu-xl').html('eror');
        });
    });
</script>
@endsection
