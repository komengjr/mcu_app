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
                        <img class="ms-3 mx-3 m-2" src="{{ asset('img/company.png') }}" alt="" width="50" />
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
                        <h4 class="text-danger fw-bold mb-0">Monitoring <span class="text-danger fw-medium">MCU</span></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-3" style="font-family: 'Calibri', sans-serif;">
        <div class="card-body">
            <div class="row flex-between-center">
                <div class="col-sm-auto mb-2 mb-sm-0">
                    <h6 class="mb-0">Showing {{ $data->count() }} Project</h6>
                </div>
                <div class="col-sm-auto">
                    <div class="row gx-2 align-items-center">
                        <div class="col-auto">
                            <form class="row gx-2">
                                <div class="col-auto"><small>Search by name: </small></div>
                                <div class="col-auto">
                                    <div class="search">
                                        <div class="position-relative">
                                            <input class="form-control search-input fuzzy-search" type="search"
                                                id="carimcu" onkeydown="search(this)" placeholder="Search..."
                                                aria-label="Search" />
                                            {{-- <span class="fas fa-search search-box-icon"></span> --}}
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card" style="font-family: 'Calibri', sans-serif;">
        <div class="card-body p-0 overflow-hidden">
            <div class="row g-0 p-2" id="menu-monitoring-mcu">
                @foreach ($data as $datas)
                    <div class="card border border-danger mb-2">
                        <div class="col-12 p-card border border-bottom ">
                            <div class="row">
                                <div class="col-sm-4 col-md-3">
                                    <div class="position-relative h-sm-100"><a class="d-block h-100" href="#"><img
                                                class="img-fluid fit-cover w-sm-100 h-sm-100 rounded-1 absolute-sm-centered"
                                                src="{{ asset('img/company/mcu.jpg') }}" alt="" /></a>
                                        <div
                                            class="badge rounded-pill bg-success position-absolute top-0 end-0 me-2 mt-2 fs--2 z-index-2">
                                            MOU</div>
                                    </div>
                                </div>
                                @php
                                    $total = DB::table('company_mou_peserta')
                                        ->where('company_mou_code', $datas->company_mou_code)
                                        ->count();
                                    $totalmcu = DB::table('log_lokasi_pasien')
                                        ->join(
                                            'company_mou_peserta',
                                            'company_mou_peserta.mou_peserta_code',
                                            '=',
                                            'log_lokasi_pasien.mou_peserta_code',
                                        )
                                        ->join(
                                            'master_cabang',
                                            'master_cabang.master_cabang_code',
                                            '=',
                                            'log_lokasi_pasien.lokasi_cabang',
                                        )
                                        ->where('company_mou_peserta.company_mou_code', $datas->company_mou_code)
                                        ->count();
                                @endphp
                                <div class="col-sm-8 col-md-9">
                                    <div class="row">
                                        <div class="col-lg-10">
                                            <h5 class="mt-3 mt-sm-0"><a class="text-dark fs-0 fs-lg-1"
                                                    href="#">{{ $datas->company_mou_name }}
                                                </a></h5>
                                            <p class="fs--1 mb-2 mb-md-2"><a class="text-500"
                                                    href="#!">{{ $datas->master_company_name }}</a></p>
                                            <div class="row g-3">
                                                <div class="col-md-8 mt-0">
                                                    <div class="card p-3 my-2 border border-danger">
                                                        {{-- <h6 class="fw-semi-bold ls text-uppercase">Informasi Perusahaan</h6> --}}
                                                        <div class="row">
                                                            <div class="col-7 col-sm-7">
                                                                <p class="fs--1 fs-md-1 mb-1 fw-semi-bold">Total Peserta</p>
                                                            </div>
                                                            <div class="col">
                                                                <h5 class="fs--1 fs-md-1 text-warning mb-0">
                                                                    {{ $total }}
                                                                    Peserta
                                                                </h5>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-7 col-sm-7">
                                                                <p class="fs--1 fs-md-1 mb-1 fw-semi-bold">Total Sudah MCU
                                                                </p>
                                                            </div>
                                                            <div class="col">
                                                                <a href="#" id="button-sudah-mcu"
                                                                    data-code="{{ $datas->company_mou_code }}"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#modal-monitoring">
                                                                    <h5 class="fs--1 fs-md-1 text-warning mb-0">
                                                                        {{ $totalmcu }}
                                                                        Peserta
                                                                    </h5>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-7 col-sm-7">
                                                                <p class="fs--1 fs-md-1 mb-1 fw-semi-bold">Total Belum MCU
                                                                </p>
                                                            </div>
                                                            <div class="col">
                                                                <a href="#" id="button-belum-mcu"
                                                                    data-code="{{ $datas->company_mou_code }}"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#modal-monitoring">
                                                                    <h5 class="fs--1 fs-md-1 text-warning mb-0">
                                                                        {{ $total - $totalmcu }}
                                                                        Peserta
                                                                    </h5>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-7 col-sm-7">
                                                                <p class="fs--1 fs-md-1 mb-1 fw-semi-bold">Persentase</p>
                                                            </div>
                                                            <div class="col">
                                                                <h5 class="fs-1 fs-md-2 text-primary mb-0">
                                                                    @if ($total == 0)
                                                                        0
                                                                    @else
                                                                        {{ round(($totalmcu / $total) * 100, 2) }}
                                                                    @endif
                                                                    %
                                                                </h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mt-0">
                                                    <div class="card p-3 my-2 border border-danger">
                                                        {{-- <h6 class="fw-semi-bold ls text-uppercase">Informasi Perusahaan</h6> --}}
                                                        <div class="d-lg-block">
                                                            <p class="fs--1 mb-0">Date : <strong
                                                                    class="text-success">{{ date('d-m-Y', strtotime($datas->company_mou_start)) }}
                                                                    -
                                                                    {{ date('d-m-Y', strtotime($datas->company_mou_end)) }}
                                                                </strong></strong>
                                                            </p>
                                                            <p class="fs--1 mb-1">MCU : <strong
                                                                    class="text-success">Available</strong>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- <ul class="list-unstyled d-none d-lg-block">
                                            @php
                                                $pemeriksaan = DB::table('company_mou_pemeriksaan')
                                                    ->join(
                                                        'master_pemeriksaan',
                                                        'master_pemeriksaan.master_pemeriksaan_code',
                                                        '=',
                                                        'company_mou_pemeriksaan.master_pemeriksaan_code',
                                                    )
                                                    ->where(
                                                        'company_mou_pemeriksaan.company_mou_code',
                                                        $datas->company_mou_code,
                                                    )
                                                    ->get();
                                            @endphp
                                            @foreach ($pemeriksaan as $item)
                                                <li><span class="fas fa-circle" data-fa-transform="shrink-12"></span>
                                                    {{ $item->master_pemeriksaan_name }}</li>
                                            @endforeach

                                        </ul> --}}
                                        </div>
                                        <div class="col-lg-2 justify-content-between flex-column ">
                                            <div class="mt-2 g-2 float-end">
                                                <a class="btn btn-sm btn-warning border-300 d-lg-block me-lg-0"href="#!"
                                                    id="button-print-peserta" data-bs-toggle="modal"
                                                    data-bs-target="#modal-monitoring"
                                                    data-code="{{ $datas->company_mou_code }}">
                                                    <span class="far fa-file-pdf"></span>
                                                    <span class="ms-2 d-none d-md-inline-block">Report</span></a>
                                                <a class="btn btn-sm btn-primary d-lg-block mt-lg-2" href="#!"
                                                    id="button-detail-peserta" data-bs-toggle="modal"
                                                    data-bs-target="#modal-monitoring"
                                                    data-code="{{ $datas->company_mou_code }}">
                                                    <span class="far fa-user"></span>
                                                    <span class="ms-2 d-none d-md-inline-block">Peserta</span></a>
                                                <a class="btn btn-sm btn-danger d-lg-block mt-lg-2" href="#!"
                                                    id="button-rekap-full-peserta" data-bs-toggle="modal"
                                                    data-bs-target="#modal-monitoring"
                                                    data-code="{{ $datas->company_mou_code }}">
                                                    <span class="far fa-address-card"></span>
                                                    <span class="ms-2 d-none d-md-inline-block">Rekap</span></a>
                                                <a class="btn btn-sm btn-info d-lg-block mt-lg-2" href="#!"
                                                    id="button-detail-full-peserta" data-bs-toggle="modal"
                                                    data-bs-target="#modal-monitoring"
                                                    data-code="{{ $datas->company_mou_code }}">
                                                    <span class="fas fa-file-export"></span>
                                                    <span class="d-none d-md-inline-block">Export</span></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="card-footer border-top d-flex justify-content-center">

        </div>
    </div>
@endsection
@section('base.js')
    <div class="modal fade" id="modal-monitoring" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="false">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 95%;">
            <div class="modal-content border-0">
                <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                        data-bs-dismiss="modal" aria-label="Close"></button>
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
    <script>
        new DataTable('#example', {
            responsive: true
        });
    </script>
    <script>
        $(document).on("click", "#button-detail-peserta", function(e) {
            e.preventDefault();
            var code = $(this).data("code");
            $('#menu-monitoring').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
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
                $('#menu-monitoring').html('eror');
            });
        });
        $(document).on("click", "#button-belum-mcu", function(e) {
            e.preventDefault();
            var code = $(this).data("code");
            $('#menu-monitoring').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
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
                $('#menu-monitoring').html('eror');
            });
        });
        $(document).on("click", "#button-sudah-mcu", function(e) {
            e.preventDefault();
            var code = $(this).data("code");
            $('#menu-monitoring').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
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
                $('#menu-monitoring').html('eror');
            });
        });
        $(document).on("click", "#button-print-peserta", function(e) {
            e.preventDefault();
            var code = $(this).data("code");
            $('#menu-monitoring').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
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
                $('#menu-monitoring').html(
                    '<iframe src="data:application/pdf;base64, ' +
                    data +
                    '" style="width:100%; height:533px;" frameborder="0"></iframe>');
            }).fail(function() {
                $('#menu-monitoring').html('eror');
            });
        });
        $(document).on("click", "#button-rekap-full-peserta", function(e) {
            e.preventDefault();
            var code = $(this).data("code");
            $('#menu-monitoring').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
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
                $('#menu-monitoring').html(
                    '<span class="badge bg-warning m-4">Data Belum Lengkap , Reload.. dalam 3 detik</span>'
                );
                setTimeout(() => {
                    location.reload();
                }, 2000);
            });
        });
        $(document).on("click", "#button-detail-full-peserta", function(e) {
            e.preventDefault();
            var code = $(this).data("code");
            $('#menu-monitoring').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
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
            }).fail(function() {
                // $('#menu-monitoring').html(
                //     '<span class="badge bg-warning m-4">Data Belum Lengkap , Reload.. dalam 3 detik</span>'
                // );
                // setTimeout(() => {
                //     location.reload();
                // }, 2000);
            });
        });
    </script>
    <script>
        function search(ele) {
            var code = document.getElementById("carimcu").value;
            $.ajax({
                    url: "{{ route('monitoring_mcu_cari_nama') }}",
                    type: "POST",
                    cache: false,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "code": code
                    },
                    dataType: 'html',
                })
                .done(function(data) {
                    $("#menu-monitoring-mcu").html(data);
                })
                .fail(function() {
                    $("#menu-monitoring-mcu").html(
                        '<i class="fa fa-info-sign"></i> Something went wrong, Please try again...'
                    );
                });
        };
    </script>
@endsection
