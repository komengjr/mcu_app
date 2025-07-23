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
                    <h4 class="text-danger fw-bold mb-0">Service <span class="text-danger fw-medium">MCU</span></h4>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card mb-3">
    <div class="card-body">
        <div class="row flex-between-center">
            <div class="col-sm-auto mb-2 mb-sm-0">
                <h6 class="mb-0">Showing {{ $data->count() }} Data</h6>
            </div>
            <div class="col-sm-auto">
                <div class="row gx-2 align-items-center">
                    <div class="col-auto">
                        <div class="btn-group" role="group">
                            <button class="btn btn-sm btn-falcon-danger dropdown-toggle" id="btnGroupVerticalDrop2"
                                type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span
                                    class="fas fa-align-left me-1" data-fa-transform="shrink-3"></span>Menu</button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop2">
                                <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-mcu"
                                    id="button-data-history-mcu"><span class="far fa-folder-open"></span>
                                    History</button>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-auto pe-0">
                            <a class="text-600 px-1" href="../../../app/e-commerce/product/product-list.html"
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Product List"><span
                                    class="fas fa-list-ul"></span></a>
                        </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card mb-3">
    <div class="card-header bg-danger">
        <div class="row align-items-center">
            <div class="col-md-4">
                <label for="organizerSingle" class="my-0 text-white">Pilih Perusahaan</label>
                <select class="form-select js-choice bg-light" id="perusahaan" name="perusahaan">
                    <option value="">Select Perusahaan</option>
                    @foreach ($perusahaan as $per)
                    <option value="{{ $per->master_company_code  }}">{{ $per->master_company_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4" id="menu-agreement">

            </div>
            <div class="col-md-4 py-0">

            </div>
        </div>
    </div>
    <div class="card-body border-top p-3" id="table-service">
        <table id="example" class="table table-striped nowrap border" style="width:100%">
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
                </tr>
            </thead>
            <tbody class="fs--2">
                @php
                $no = 1;
                @endphp
                @foreach ($data as $datas)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>
                        {{ $datas->mou_peserta_name }} <br>
                        <div class="btn-group pt-2" role="group">
                            <button class="btn btn-sm btn-danger dropdown-toggle" id="btnGroupVerticalDrop2"
                                type="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false"><span class="fas fa-align-left me-1"
                                    data-fa-transform="shrink-3"></span>Option</button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop2">
                                <button class="dropdown-item text-primary" data-bs-toggle="modal" data-bs-target="#modal-mcu-xl"
                                    id="button-proses-peserta-mcu" data-code="{{ $datas->mou_peserta_code }}"><span
                                        class="fas fa-project-diagram"></span>
                                    Proses Service</button>
                                <div class="dropdown-divider"></div>
                                <button class="dropdown-item text-warning" data-bs-toggle="modal" data-bs-target="#modal-mcu-xl"
                                    id="button-proses-update-status-mcu" data-code="{{ $datas->mou_peserta_code }}" data-company="{{ $datas->company_mou_code }}"><span
                                        class="fas fa-scroll"></span>
                                    Update Pemeriksaan</button>
                            </div>
                        </div>
                    </td>
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
                        {{ $pengiriman->log_pengiriman_date }}
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
    new window.Choices(document.querySelector(".js-choice"));
</script>
<script>
    $(document).on("click", "#button-data-history-mcu", function(e) {
        e.preventDefault();
        $('#menu-mcu').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('menu_service_history') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": 1
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
    $(document).on("click", "#button-proses-update-status-mcu", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        var company = $(this).data("company");
        $('#menu-mcu-xl').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('menu_service_proses_update_status') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code,
                "company": company,
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
<script>
    $('#perusahaan').on("change", function() {
        var dataid = document.getElementById("perusahaan").value;
        if (dataid == "") {
            Lobibox.notify('warning', {
                pauseDelayOnHover: true,
                continueDelayOnInactiveTab: true,
                position: 'top right',
                icon: 'fas fa-info-circle',
                msg: 'Pastikan Sudah dipilih'
            });
        } else {
            $.ajax({
                url: "{{ route('menu_service_pilih_perusahaan') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": dataid,
                },
                dataType: 'html',
            }).done(function(data) {
                $("#menu-agreement").html(data);
            }).fail(function() {
                console.log('eror');
            });
        }
    });
</script>
<script>
    function MyFunction(id, x) {
        $(this).removeAttr('checked');
        var ket = document.getElementById('ket' + id).value;
        if ($('#pem' + id).is(":checked")) {
            var pilihan = 'on';
        } else {
            var pilihan = 'off';
        }
        if (pilihan == 'off') {
            if (ket == '') {
                Lobibox.notify('warning', {
                    pauseDelayOnHover: true,
                    continueDelayOnInactiveTab: true,
                    position: 'top right',
                    icon: 'fas fa-info-circle',
                    msg: 'Pastikan Untuk Mengisi Keterangan Terlebih dahulu'
                });
                setTimeout(() => {
                    location.reload();
                }, 1000);
            } else {
                $.ajax({
                    url: "{{ route('signaturepad.update_pemeriksaan') }}",
                    type: "POST",
                    cache: false,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "code": id,
                        "user": x,
                        "option": pilihan,
                        "ket": ket,
                    },
                    dataType: 'html',
                }).done(function(data) {

                }).fail(function() {
                    console.log('eror');
                });
            }
        } else {
            $.ajax({
                url: "{{ route('signaturepad.update_pemeriksaan') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": id,
                    "user": x,
                    "option": pilihan,
                    "ket": ket,
                },
                dataType: 'html',
            }).done(function(data) {

            }).fail(function() {
                console.log('eror');
            });
        }
    }
</script>
@endsection
