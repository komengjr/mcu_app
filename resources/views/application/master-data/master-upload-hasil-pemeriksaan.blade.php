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
                        <h4 class="text-danger fw-bold mb-1">Management <span class="text-danger fw-medium">
                                System</span></h4>
                    </div>
                    <img class="ms-n4 d-none d-lg-block "
                        src="{{ asset('asset/img/illustrations/crm-line-chart.png') }}" alt="" width="150" />
                </div>
                <div class="col-xl-auto px-3 py-2">
                    <h6 class="text-danger fs--1 mb-0">Menu : </h6>
                    <h4 class="text-danger fw-bold mb-0">Upload <span class="text-danger fw-medium">Hasil</span>
                    </h4>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card mb-3">
    <div class="card-header bg-danger">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="m-0"><span class="badge bg-danger m-0 p-0">Upload Hasil</span></h3>
            </div>
            <div class="col-auto">
                <div class="btn-group" role="group">

                </div>
            </div>
        </div>
    </div>
    <div class="card-body border-top p-3">
        <table id="example" class="table table-striped fs--2" style="width:100%">
            <thead class="bg-200 text-700">
                <tr>
                    <th>No</th>
                    <th>Rujukan</th>
                    <th>Nama Pasien / No Reg</th>
                    <th>Jenis Kelamin</th>
                    <th>Tanggal Lahir</th>
                    <th>Pemeriksaan</th>
                    <th>Pengambilan Sample</th>
                    <th>Proses Sample</th>
                    <th>Status Hasil</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @php
                $no = 1;
                @endphp
                @foreach ($data as $datas)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $datas->fullname }} <br><span class="badge bg-primary">{{ date("d-m-Y H:i:s", strtotime($datas->created_at)) }}</span></td>
                    <td>{{ $datas->monitoring_hasil_pasien_nama }} <br><span class="badge bg-primary">{{ $datas->monitoring_hasil_pasien_reg }}</span></td>
                    <td>
                        @if ($datas->monitoring_hasil_pasien_jk == "L")
                        Laki - Laki
                        @elseif ($datas->monitoring_hasil_pasien_jk == "P")
                        Perempuan
                        @endif
                    </td>
                    <td>{{ date("d-m-Y", strtotime($datas->monitoring_hasil_pasien_tgl_lahir)) }}</td>
                    <td>
                        @php
                        $pemeriksaan = DB::table('monitoring_hasil_pemeriksaan')
                        ->join('master_test','master_test.master_test_code','=','monitoring_hasil_pemeriksaan.master_test_code')
                        ->where('monitoring_hasil_pasien_code',$datas->monitoring_hasil_pasien_code)->get();
                        @endphp
                        @foreach ($pemeriksaan as $pem)
                        <li>{{ $pem->master_test_name }}</li>
                        @endforeach
                    </td>
                    <td>
                        @php
                        $kurir = DB::table('monitoring_hasil_kurir')->where('monitoring_hasil_pasien_code',$datas->monitoring_hasil_pasien_code)->first();
                        @endphp
                        @if ($kurir)
                        {{ $kurir->monitoring_hasil_kurir_name }} <br>
                        {{ date("d-m-Y H:i:s", strtotime($kurir->monitoring_hasil_kurir_date )) }}
                        @endif
                    </td>
                    <td>
                        @if ($datas->monitoring_hasil_pasien_tgl_periksa != "")
                        {{ date("d-m-Y H:i:s", strtotime($datas->monitoring_hasil_pasien_tgl_periksa)) }}
                        @endif
                    </td>
                    <td class="text-center">
                        @if ($datas->monitoring_hasil_pasien_status == 0)
                        <span class="badge bg-dark">Order Baru</span>
                        @elseif($datas->monitoring_hasil_pasien_status == 1)
                        <span class="badge bg-warning">Order Telah di ambil</span>
                        @elseif($datas->monitoring_hasil_pasien_status == 2)
                        <span class="badge bg-primary">Order Proses</span>
                        @elseif($datas->monitoring_hasil_pasien_status == 3)
                        <span class="badge bg-success">Order selesai</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <button class="btn btn-primary btn-sm" id="button-detail-order-pasien" data-code="{{ $datas->monitoring_hasil_pasien_code }}" data-bs-toggle="modal" data-bs-target="#modal-mcu">Detail</button>
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
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-mcu"></div>
        </div>
    </div>
</div>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    new DataTable('#example', {
        responsive: true
    });
</script>
<script>
    $(document).on("click", "#button-detail-order-pasien", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-mcu').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('master_upload_hasil_pemeriksaan_detail') }}",
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
    $(document).on("click", "#button-edit-pemeriksaan", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-pemeriksaan').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('master_pemeriksaan_update') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-pemeriksaan').html(data);
        }).fail(function() {
            $('#menu-pemeriksaan').html('eror');
        });
    });
</script>
<script>
    $(document).on("click", "#button-proses-data-pasien", function(e) {
        e.preventDefault();
        $('#loading-button').html(
            '<button class="btn btn-primary" type="button" disabled=""><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...</button>'
        );
        const no_reg = document.getElementById('no_reg').value;

        if (no_reg == "") {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "No Registrasi Harus diisi",
                footer: "<a href=\"#\">Why do I have this issue?</a>"
            });
            $('#loading-button').html(
                '<button class="btn btn-primary" type="button" id="button-save-data-pasien"><span class="fas fa-save"></span> Simpan & Kirim</button>'
            );
        } else {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success",
                    cancelButton: "btn btn-danger"
                },
                buttonsStyling: true
            });
            swalWithBootstrapButtons.fire({
                title: "Apakah Kamu yakin Untuk Simpan?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "YA, Simpan",
                cancelButtonText: "Tidak, Batal!",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    var data = $("#form-proses-pasien").serialize();
                    $.ajax({
                        url: "{{ route('master_upload_hasil_pemeriksaan_detail_proses') }}",
                        type: "POST",
                        cache: false,
                        data: data,
                        dataType: 'html',
                    }).done(function(data) {
                        if (data == 1) {
                            swalWithBootstrapButtons.fire({
                                title: "Sukses!",
                                text: "Your Data has Been Success.",
                                icon: "success"
                            });
                            location.reload();
                        } else {
                            swalWithBootstrapButtons.fire({
                                title: "Cancelled",
                                text: "Failed",
                                icon: "error"
                            });
                            $('#loading-button').html(
                                '<button class="btn btn-primary" type="button" id="button-save-data-pasien"><span class="fas fa-save"></span> Simpan & Kirim</button>'
                            );
                        }

                    }).fail(function() {
                        swalWithBootstrapButtons.fire({
                            title: "Cancelled",
                            text: "Failed",
                            icon: "error"
                        });
                        $('#loading-button').html(
                            '<button class="btn btn-primary" type="button" id="button-save-data-pasien"><span class="fas fa-save"></span> Simpan & Kirim</button>'
                        );
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel)
                    swalWithBootstrapButtons.fire({
                        title: "Cancelled",
                        text: "Failed",
                        icon: "error"
                    });
                $('#loading-button').html(
                    '<button class="btn btn-primary" type="button" id="button-save-data-pasien"><span class="fas fa-save"></span> Simpan & Kirim</button>'
                );
            });
        }

    });
</script>
@endsection
