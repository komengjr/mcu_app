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
                        <h4 class="text-primary fw-bold mb-0">Service <span class="text-info fw-medium">MCU</span></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-body">
            <div class="row flex-between-center">
                <div class="col-sm-auto mb-2 mb-sm-0">
                    <h6 class="mb-0">Showing 1-24 of 205 Products</h6>
                </div>
                <div class="col-sm-auto">
                    <div class="row gx-2 align-items-center">
                        <div class="col-auto">
                            <form class="row gx-2">
                                <div class="col-auto"><small>Sort by:</small></div>
                                <div class="col-auto">
                                    <select class="form-select form-select-sm" aria-label="Bulk actions">
                                        <option selected="">Best Match</option>
                                        <option value="Refund">Newest</option>
                                        <option value="Delete">Price</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                        <div class="col-auto pe-0">
                            <a class="text-600 px-1" href="../../../app/e-commerce/product/product-list.html"
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Product List"><span
                                    class="fas fa-list-ul"></span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header bg-primary">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="m-0"><span class="badge bg-primary m-0 p-0">Service MCU</span></h3>
                </div>
                <div class="col-auto">
                    <div class="btn-group" role="group">
                        <button class="btn btn-sm btn-falcon-primary dropdown-toggle" id="btnGroupVerticalDrop2"
                            type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span
                                class="fas fa-align-left me-1" data-fa-transform="shrink-3"></span>Menu Service</button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop2">

                            <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-cabang"
                                id="button-data-barang-cabang" data-code="123"><span class="far fa-folder-open"></span>
                                History</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body border-top p-3">
            <table id="example" class="table table-striped nowrap" style="width:100%">
                <thead class="bg-200 text-700 fs--2">
                    <tr>
                        <th>No</th>
                        <th>Nama Peserta</th>
                        <th>Nama MOU</th>
                        <th>Email</th>
                        <th>No Handphone</th>
                        <th>Status Pemeriksaan</th>
                        <th>Status Hasil</th>
                        <th>Status Konsultasi</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="fs--2">
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($data as $datas)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $datas->mou_peserta_name }}</td>
                            <td class="text-primary">{{ $datas->company_mou_name }}</td>
                            <td>{{ $datas->mou_peserta_email }}</td>
                            <td>{{ $datas->mou_peserta_no_hp }}</td>
                            {{-- Pemeriksaan --}}
                            <td>
                                @php
                                    $pemeriksaan = DB::table('company_mou_agreement_sub')
                                        ->join(
                                            'master_pemeriksaan',
                                            'master_pemeriksaan.master_pemeriksaan_code',
                                            '=',
                                            'company_mou_agreement_sub.master_pemeriksaan_code',
                                        )
                                        ->where(
                                            'company_mou_agreement_sub.mou_agreement_code',
                                            $datas->mou_agreement_code,
                                        )
                                        ->get();
                                @endphp
                                @foreach ($pemeriksaan as $pem)
                                    @php
                                        $check = DB::table('log_pemeriksaan_pasien')
                                            ->where('master_pemeriksaan_code', $pem->master_pemeriksaan_code)
                                            ->where('mou_peserta_code', $datas->mou_peserta_code)
                                            ->first();
                                    @endphp
                                    @if ($check)
                                        @if ($check->log_pemeriksaan_status == 1)
                                            <li>{{ $pem->master_pemeriksaan_name }} <span
                                                    class="fas fa-check-square text-success"></span></li>
                                        @else
                                            <li>{{ $pem->master_pemeriksaan_name }} <span
                                                    class="fas fa-exclamation-circle text-warning"></span></li>
                                        @endif
                                    @else
                                        <li>{{ $pem->master_pemeriksaan_name }} <span
                                                class="fas fa-window-close text-danger"></span></li>
                                    @endif
                                @endforeach
                                {{-- @if ($konsul)
                                    <span class="badge bg-primary">Selesai</span>
                                @else
                                    <span class="badge bg-danger">Belum Selesai</span>
                                @endif --}}
                            </td>
                            {{-- Pengiriman --}}
                            <td>
                                @php
                                    $pengiriman = DB::table('log_pengiriman_pasien')
                                        ->where('mou_peserta_code', $datas->mou_peserta_code)
                                        ->first();
                                @endphp
                                @if ($pengiriman)
                                    <span class="badge bg-primary">Terkirim</span><br>
                                    {{$pengiriman->log_pengiriman_date}}
                                @else
                                    <span class="badge bg-danger">Belum Terkirim</span>
                                @endif
                            </td>
                            {{-- Konsultasi --}}
                            <td>
                                @php
                                    $konsul = DB::table('log_konsultasi_pasien')
                                        ->where('mou_peserta_code', $datas->mou_peserta_code)
                                        ->first();
                                @endphp
                                @if ($konsul)
                                    <span class="badge bg-primary">Sudah dilakukan</span>
                                @else
                                    <span class="badge bg-danger">Belum dilakukan</span>
                                @endif
                            </td>

                            <td>
                                <div class="btn-group" role="group">
                                    <button class="btn btn-sm btn-falcon-primary dropdown-toggle" id="btnGroupVerticalDrop2"
                                        type="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false"><span class="fas fa-align-left me-1"
                                            data-fa-transform="shrink-3"></span>Option</button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop2">
                                        <button class="dropdown-item" data-bs-toggle="modal"
                                            data-bs-target="#modal-mcu-xl" id="button-proses-peserta-mcu"
                                            data-code="{{ $datas->mou_peserta_code }}"><span
                                                class="far fa-folder-open"></span>
                                            Proses Service</button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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
                url: "{{ route('menu_service_proses') }}",
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
        $(document).on("click", "#button-penyelesaian-peserta-mcu", function(e) {
            e.preventDefault();
            var code = $(this).data("code");
            $('#button-penyelesaian-peserta-mcu').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('menu_service_proses_penyelesaian_peserta_mcu') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": code
                },
                dataType: 'html',
            }).done(function(data) {
                $('#button-penyelesaian-peserta-mcu').html(data);
                location.reload();
            }).fail(function() {
                $('#button-penyelesaian-peserta-mcu').html('eror');
            });
        });
    </script>
@endsection
