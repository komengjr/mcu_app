@extends('layouts.template')
@section('base.css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
    <link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
@endsection
@section('content')
    <div class="row mb-3">
        <div class="col">
            <div class="card bg-200 shadow border border-primary">
                <div class="row gx-0 flex-between-center">
                    <div class="col-sm-auto d-flex align-items-center border-bottom">
                        <img class="ms-3 mx-3" src="{{ asset('img/company.png') }}" alt="" width="50" />
                        <div>
                            <h6 class="text-primary fs--1 mb-0 pt-2">Welcome to </h6>
                            <h4 class="text-primary fw-bold mb-1">MCU <span class="text-info fw-medium">Management
                                    System</span></h4>
                        </div>
                        <img class="ms-n4 d-none d-lg-block "
                            src="{{ asset('asset/img/illustrations/crm-line-chart.png') }}" alt="" width="150" />
                    </div>
                    <div class="col-xl-auto px-3 py-2">
                        <h6 class="text-primary fs--1 mb-0">Menu : </h6>
                        <h4 class="text-primary fw-bold mb-0">Medical <span class="text-info fw-medium">Check Up</span></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-body">
            <div class="row flex-between-center">
                <div class="col-sm-auto mb-2 mb-sm-0">
                    <h6 class="mb-0">Showing {{$data->count()}}  Project</h6>
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
                        <div class="border rounded-1 h-100 d-flex flex-column justify-content-between pb-3">
                            <div class="overflow-hidden">
                                <div class="position-relative rounded-top overflow-hidden ">
                                    <a class="d-block" href="#">
                                        <img class="img-fluid rounded-top"  src="{{ asset('img/company/pln.png') }}"
                                            alt="" />
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
                                            $total = DB::table('company_mou_peserta')->where('company_mou_code',$datas->company_mou_code)->count();
                                        @endphp
                                        Total Peserta: <strong>{{$total}} Peserta</strong>
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

                                <div>
                                    {{-- <a class="btn btn-sm btn-falcon-default me-2" href="#!" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Add to Wish List"><span
                                            class="far fa-heart"></span></a> --}}
                                    <a class="btn btn-sm btn-falcon-default fs--2 text-warning" href="#!" data-bs-toggle="modal"
                                        data-bs-target="#modal-mcu-xl" id="button-proses-summary-check-up" data-code="{{$datas->company_mou_code}}" title="Proses Check Up"><span
                                            class="fas fa-file"></span> Summary</a>
                                    <a class="btn btn-sm btn-falcon-default fs--2 text-primary" href="#!" data-bs-toggle="modal"
                                        data-bs-target="#modal-mcu" id="button-proses-check-up" data-code="{{$datas->company_mou_code}}" title="Proses Check Up"><span
                                            class="fas fa-user-check"></span> Prosess</a>
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
                    class="btn btn-sm btn-falcon-default me-2" href="#!">2</a><a
                    class="btn btn-sm btn-falcon-default me-2" href="#!">
                    <span class="fas fa-ellipsis-h"></span></a><a class="btn btn-sm btn-falcon-default me-2"
                    href="#!">35</a>
                <button class="btn btn-falcon-default btn-sm" type="button" data-bs-toggle="tooltip"
                    data-bs-placement="top" title="Next">
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
    <script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
    <script>
        new DataTable('#example', {
            responsive: true
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
    </script>
@endsection
