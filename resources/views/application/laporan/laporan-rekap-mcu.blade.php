@extends('layouts.template')
@section('base.css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
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
                        <h4 class="text-danger fw-bold mb-0">Laporan <span class="text-danger fw-medium">Rekap MCU</span>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="menu-detail-rekap">
        <div class="card mb-3">
            <div class="card-header bg-danger">
                <div class="row align-items-center">
                    <div class="col">
                        <h4 class="mb-0"><span class="badge bg-danger">REKAP PROJECT</span></h4>
                    </div>
                    <div class="col-auto"><a class="btn btn-falcon-danger btn-sm" href="#!" id="button-cari-project"
                            data-bs-toggle="modal" data-bs-target="#modal-laporan-lg"><span class="fas fa-search"></span>
                            Cari Data Project</a></div>
                </div>
            </div>
            <div class="card-body bg-light border-top">

            </div>
            <div class="card-footer border-top text-end">

            </div>
        </div>
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0">Logs</h5>
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
    <div class="modal fade" id="modal-laporan-lg" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="false">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content border-0">
                <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="menu-laporan-lg"></div>
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
        $(document).on("click", "#button-cari-project", function(e) {
            e.preventDefault();
            var code = 123
            $('#menu-laporan-lg').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('laporan_rekap_mcu_cari_data') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": code
                },
                dataType: 'html',
            }).done(function(data) {
                $('#menu-laporan-lg').html(data);
            }).fail(function() {
                $('#menu-laporan-lg').html('eror');
            });
        });
        $(document).on("click", "#button-detail-rekap-project", function(e) {
            e.preventDefault();
            var data = $("#form-rekap-mcu").serialize();
            $('#menu-detail-rekap').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('laporan_rekap_mcu_pilih_data') }}",
                type: "POST",
                cache: false,
                data: data,
                dataType: 'html',
            }).done(function(data) {
                $('#menu-detail-rekap').html(data);
            }).fail(function() {
                $('#menu-detail-rekap').html(
                    '<span class="badge bg-warning">Data Belum Lengkap , Reload.. dalam 3 detik</span>');
                setTimeout(() => {
                    location.reload();
                }, 3000);
            });
        });
        $(document).on("click", "#button-detail-rekap-kehadiran-peserta", function(e) {
            e.preventDefault();
            var code = $(this).data("code");
            $('#menu-mcu').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('laporan_rekap_mcu_kehadiran_peserta_mcu') }}",
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
                $('#menu-mcu').html(
                    '<span class="badge bg-warning">Data Belum Lengkap , Reload.. dalam 3 detik</span>');
                setTimeout(() => {
                    location.reload();
                }, 1000);
            });
        });
        // $(document).on("click", "#button-detail-rekap-kehadiran-peserta-excel", function(e) {
        //     e.preventDefault();
        //     var code = $(this).data("code");
        //     $('#menu-mcu').html(
        //         '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        //     );
        //     $.ajax({
        //         url: "{{ route('laporan_rekap_mcu_kehadiran_peserta_mcu') }}",
        //         type: "POST",
        //         cache: false,
        //         data: {
        //             "_token": "{{ csrf_token() }}",
        //             "code": code
        //         },
        //         dataType: 'html',
        //     }).done(function(data) {
        //         $('#menu-mcu').html(data);
        //     }).fail(function() {
        //         $('#menu-mcu').html(
        //             '<span class="badge bg-warning">Data Belum Lengkap , Reload.. dalam 3 detik</span>');
        //         setTimeout(() => {
        //             location.reload();
        //         }, 1000);
        //     });
        // });
    </script>
@endsection
