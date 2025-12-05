@extends('layouts.template')
@section('base.css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.2.4/css/buttons.dataTables.css">
    <link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
@endsection
@section('content')
    <div class="row mb-3">
        <div class="col">
            <div class="card bg-200 shadow border border-danger">
                <div class="row gx-0 flex-between-center">
                    <div class="col-sm-auto d-flex align-items-center border-bottom">
                        <img class="ms-3 mx-3" src="{{ asset('img/company.png') }}" alt="" width="50" />
                        <div>
                            <h6 class="text-danger fs--1 mb-0 pt-2">Welcome to </h6>
                            <h4 class="text-danger fw-bold mb-1">MCU <span class="text-danger fw-medium">Management
                                    System</span></h4>
                        </div>
                        <img class="ms-n4 d-none d-lg-block "
                            src="{{ asset('asset/img/illustrations/crm-line-chart.png') }}" alt="" width="150" />
                    </div>
                    <div class="col-xl-auto px-3 py-2">
                        <h6 class="text-danger fs--1 mb-0">Menu : </h6>
                        <h4 class="text-danger fw-bold mb-0">Medical <span class="text-danger fw-medium">Check Up</span>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-body">
            <div class="row flex-between-center">
                <div class="col-sm-auto mb-2 mb-sm-0">
                    <h6 class="mb-0">Showing {{ $data->count() }} Project</h6>
                </div>
                <div class="col-sm-auto">
                    <div class="row gx-2 align-items-center">
                        <div class="col-auto">
                            <div class="row gx-2">
                                <div class="col-auto"><small>Search by:</small></div>
                                <div class="col-auto">
                                    <input type="text" class="form-control" name="" id="">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-body">
            <div class="row g-3">
                @foreach ($data as $datas)
                    <div class="mb-4 mb-lg-0 col-md-4 col-lg-3">
                        <div class="border border-warning rounded-1 h-100 d-flex flex-column justify-content-between pb-3">
                            <div class="overflow-hidden">
                                <div class="position-relative rounded-top overflow-hidden ">
                                    <a class="d-block" href="#">
                                        <img class="img-fluid rounded-top" src="{{ asset('img/company/mcu.jpg') }}" alt="" />
                                    </a>
                                </div>
                                <div class="p-3">
                                    <h5 class="fs-0">
                                        <a class="text-dark" href="#">{{ $datas->company_mou_name }}</a>
                                    </h5>
                                    <p class="fs--1 mb-0">
                                        <a class="text-500" href="#!">{{ $datas->master_company_name }}</a>
                                    </p>

                                    <p class="fs--1 mb-1">
                                        @php
                                            $total = DB::table('company_mou_peserta')
                                                ->where('company_mou_code', $datas->company_mou_code)
                                                ->count();
                                        @endphp
                                        Total Peserta: <strong>{{ $total }} Peserta</strong>
                                    </p>
                                    <p class="fs--1 mb-1">
                                        Date : <strong
                                            class="text-success">{{ date('d-m-Y', strtotime($datas->company_mou_start)) }}
                                            - {{ date('d-m-Y', strtotime($datas->company_mou_end)) }}
                                        </strong>
                                    </p>
                                    <p class="fs--1 mb-1">
                                        Status : <strong class="text-success">Available</strong>
                                    </p>
                                </div>
                            </div>
                            <div class="d-flex flex-between-center px-3">
                                <a class="btn btn-sm btn-falcon-default text-primary" href="#!" data-bs-toggle="modal"
                                    data-bs-target="#modal-mcu" id="button-proses-check-up"
                                    data-code="{{ $datas->company_mou_code }}" title="Proses Check Up"><span
                                        class="fas fa-user-check"></span> Prosess</a>
                                <div class="btn-group" role="group">
                                    <button class="btn btn-sm btn-falcon-success" id="btnGroupVerticalDrop2" type="button"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span
                                            class="far fa-address-card"></span><span
                                            class="ms-1 d-none d-md-inline-block">Option</span></button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop2">
                                        <!-- <button class="dropdown-item text-primary" data-bs-toggle="modal"
                                            data-bs-target="#modal-mcu-xl" id="button-add-peserta-mcu"
                                            data-code="{{ $datas->company_mou_code }}"><span class="far fa-user"></span>
                                            Tambah Peserta</button> -->
                                        <button class="dropdown-item text-dark" data-bs-toggle="modal"
                                            data-bs-target="#modal-mcu-xl" id="button-monitoring-peserta-all-mcu"
                                            data-code="{{ $datas->company_mou_code }}"><span class="fas fa-map-marked-alt"></span>
                                            Monitoring Lokasi Peserta</button>
                                        <div class="dropdown-divider"></div>
                                        <button class="dropdown-item text-warning" data-bs-toggle="modal"
                                            data-bs-target="#modal-mcu" id="button-data-monitoring-peserta-mcu"
                                            data-code="{{ $datas->company_mou_code }}"><span class="fas fa-file-invoice"></span>
                                            Status Pemeriksaan Peserta</button>
                                        <button class="dropdown-item text-success" data-bs-toggle="modal"
                                            data-bs-target="#modal-mcu-xl" id="button-preview-kehadiran-peserta-mcu"
                                            data-code="{{ $datas->company_mou_code }}"><span class="fas fa-file-alt"></span>
                                            Preview Data Kehadiran</button>
                                        <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-mcu-xl"
                                            id="button-kehadiran-peserta-mcu" data-code="{{ $datas->company_mou_code }}"><span
                                                class="fas fa-file-contract"></span>
                                            Report Data Kehadiran</button>
                                        <div class="dropdown-divider"></div>
                                        <button class="dropdown-item text-youtube" data-bs-toggle="modal"
                                            data-bs-target="#modal-mcu-xl" id="button-proses-summary-check-up"
                                            data-code="{{ $datas->company_mou_code }}"><span class="fas fa-upload"></span>
                                            Upload Summary</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="card-footer bg-light d-flex justify-content-center">
            <div>
                {{-- <button class="btn btn-falcon-default btn-sm me-2" type="button" disabled="disabled"
                    data-bs-toggle="tooltip" data-bs-placement="top" title="Prev">
                    <span class="fas fa-chevron-left"></span></button><a
                    class="btn btn-sm btn-falcon-default text-primary me-2" href="#!">1</a><a
                    class="btn btn-sm btn-falcon-default me-2" href="#!">2</a><a class="btn btn-sm btn-falcon-default me-2"
                    href="#!">
                    <span class="fas fa-ellipsis-h"></span></a><a class="btn btn-sm btn-falcon-default me-2"
                    href="#!">35</a>
                <button class="btn btn-falcon-default btn-sm" type="button" data-bs-toggle="tooltip" data-bs-placement="top"
                    title="Next">
                    <span class="fas fa-chevron-right"> </span>
                </button> --}}
            </div>
        </div>
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
        $(document).on("click", "#button-proses-check-up", function (e) {
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
            }).done(function (data) {
                $('#menu-mcu').html(data);
            }).fail(function () {
                $('#menu-mcu').html('eror');
            });
        });
        $(document).on("click", "#button-add-peserta-mcu", function (e) {
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
            }).done(function (data) {
                $('#menu-mcu-xl').html(data);
            }).fail(function () {
                $('#menu-mcu-xl').html('eror');
            });
        });
        $(document).on("click", "#button-monitoring-peserta-all-mcu", function (e) {
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
            }).done(function (data) {
                $('#menu-mcu-xl').html(data);
            }).fail(function () {
                $('#menu-mcu-xl').html('eror');
            });
        });
        $(document).on("click", "#button-data-monitoring-peserta-mcu", function (e) {
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
            }).done(function (data) {
                $('#menu-mcu').html(data);
            }).fail(function () {
                $('#menu-mcu').html('eror');
            });
        });
        $(document).on("click", "#button-proses-peserta-mcu", function (e) {
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
            }).done(function (data) {
                $('#menu-mcu-xl').html(data);
            }).fail(function () {
                $('#menu-mcu-xl').html('eror');
            });
        });
        $(document).on("click", "#button-proses-summary-check-up", function (e) {
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
            }).done(function (data) {
                $('#menu-mcu-xl').html(data);
            }).fail(function () {
                $('#menu-mcu-xl').html('eror');
            });
        });
        $(document).on("click", "#button-proses-update-peserta-mcu", function (e) {
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
            }).done(function (data) {
                $('#menu-mcu-xl').html(data);
            }).fail(function () {
                $('#menu-mcu-xl').html('eror');
            });
        });
        $(document).on("click", "#button-generate-barcode-kehadiran", function (e) {
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
            }).done(function (data) {
                $('#menu-absensi-kehadiran').html(data);
            }).fail(function () {
                $('#menu-absensi-kehadiran').html('eror');
            });
        });
        $(document).on("click", "#button-tambah-pemeriksaan-peserta-mcu", function (e) {
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
            }).done(function (data) {
                $('#data-table-pemeriksaan-peserta').html(data);
            }).fail(function () {
                $('#data-table-pemeriksaan-peserta').html('eror');
            });
        });
        $(document).on("click", "#button-simpan-penambahan-pemeriksaan-peserta-mcu", function (e) {
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
            }).done(function (data) {
                $('#data-table-pemeriksaan-peserta').html(data);
            }).fail(function () {
                $('#data-table-pemeriksaan-peserta').html('eror');
            });
        });
        $(document).on("click", "#button-remove-pemeriksaan-peserta-mcu", function (e) {
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
            }).done(function (data) {
                $('#data-table-pemeriksaan-peserta').html(data);
            }).fail(function () {
                $('#data-table-pemeriksaan-peserta').html('eror');
            });
        });
        $(document).on("click", "#button-preview-kehadiran-peserta-mcu", function (e) {
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
            }).done(function (data) {
                $('#menu-mcu-xl').html(data);
            }).fail(function () {
                $('#menu-mcu-xl').html('eror');
            });
        });
        $(document).on("click", "#button-kehadiran-peserta-mcu", function (e) {
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
            }).done(function (data) {
                $('#menu-mcu-xl').html(data);
            }).fail(function () {
                $('#menu-mcu-xl').html('eror');
            });
        });
        $(document).on("click", "#button-pilih-paket-mcu", function (e) {
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
            }).done(function (data) {
                $('#menu-table-peserta-mcu').html(data);
            }).fail(function () {
                $('#menu-table-peserta-mcu').html('eror');
            });
        });
        $(document).on("click", "#button-fix-pilih-paket-mcu", function (e) {
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
            }).done(function (data) {
                $('#menu-table-peserta-mcu').html("");
                location.reload();
            }).fail(function () {
                $('#menu-table-peserta-mcu').html('eror');
            });
        });
    </script>
    <script>
        $(document).on("click", "#button-cetak-data-kehadiran-peserta-mcu", function (e) {
            e.preventDefault();
            var page_data = document.getElementById("page_data").value;
            var code = $(this).data("code");
            console.log(page_data);

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
                }).done(function (data) {
                    $('#report-kehadiran-mcu').html(
                        '<iframe src="data:application/pdf;base64, ' +
                        data +
                        '" style="width:100%; height:533px;" frameborder="0"></iframe>');
                }).fail(function () {
                    $('#report-kehadiran-mcu').html('eror');
                });
            }
        });
    </script>
@endsection
