@extends('layouts.template')
@section('content')
<div class="row g-3 mb-3">
    <div class="col-xl-6 col-lg-12">
        <div class="card h-100">
            <div class="bg-holder bg-card" style="background-image:url(../../../asset/img/icons/spot-illustrations/corner-3.png);">
            </div>
            <!--/.bg-holder-->

            <div class="card-header z-index-1">
                <h5 class="text-primary">Welcome {{ Auth::user()->fullname }}! </h5>
                <h6 class="text-600">Here are some quick links for you to start </h6>
            </div>
            <div class="card-body z-index-1">
                <div class="row g-2 h-100 align-items-end">
                    <div class="col-sm-6 col-md-5">
                        <div class="d-flex position-relative">
                            <div class="icon-item icon-item-sm border rounded-3 shadow-none me-2"><span class="fas fa-user text-primary"></span></div>
                            <div class="flex-1">
                                <a class="stretched-link" href="#!" data-bs-toggle="modal" data-bs-target="#modal-gateway-xl" id="button-add-penerima">
                                    <h6 class="text-800 mb-0">Tambah Penerima</h6>
                                </a>
                                <p class="mb-0 fs--2 text-500">Customize with a few clicks</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-5">
                        <div class="d-flex position-relative">
                            <div class="icon-item icon-item-sm border rounded-3 shadow-none me-2"><span class="fas fa-crown text-warning"></span></div>
                            <div class="flex-1"><a class="stretched-link" href="#!">
                                    <h6 class="text-800 mb-0">Tambah Aktifitas</h6>
                                </a>
                                <p class="mb-0 fs--2 text-500">Sesuaikan Aktiftas yang ada</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-5">
                        <div class="d-flex position-relative">
                            <div class="icon-item icon-item-sm border rounded-3 shadow-none me-2"><span class="fas fa-mail-bulk text-success"></span></div>
                            <div class="flex-1"><a class="stretched-link" href="#!">
                                    <h6 class="text-800 mb-0">Pengiriman Manual</h6>
                                </a>
                                <p class="mb-0 fs--2 text-500">Buat Pengirimanmu Menjadi Mudah</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-5">
                        <div class="d-flex position-relative">
                            <div class="icon-item icon-item-sm border rounded-3 shadow-none me-2"><span class="fas fa-headset text-info"></span></div>
                            <div class="flex-1"><a class="stretched-link" href="#!">
                                    <h6 class="text-800 mb-0">Setting Brodcast</h6>
                                </a>
                                <p class="mb-0 fs--2 text-500">Monitor activity and supervise</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card h-100">
            <div class="card-header d-flex flex-between-center">
                <h5 class="mb-0">Proses Pengiriman</h5><a class="btn btn-link btn-sm px-0" href="#!" id="button-proses-aktifitas-notifikasi">Proses<span class="fas fa-chevron-right ms-1 fs--2"> </span></a>
            </div>
            <div class="card-body">
                <p class="fs--1 text-600">See team members' time worked, <br /> activity levels, and progress</p>
                <div class="progress mb-3 rounded-pill" style="height: 6px;">
                    <div class="progress-bar bg-progress-gradient rounded-pill" role="progressbar" style="width: 75%" aria-valuenow="43.72" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <p class="mb-0 text-primary">75% completed</p>
                <p class="mb-0 fs--2 text-500">Jan 1st to 30th</p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card h-100">
            <div class="card-header pb-0">
                <div class="row">
                    <div class="col">
                        <p class="mb-1 fs--2 text-500">Upcoming schedule</p>
                        <h5 class="text-primary fs-0">Proses Penjadwalan</h5>
                    </div>
                    <div class="col-auto">
                        <div class="bg-soft-primary px-3 py-3 rounded-circle text-center" style="width:60px;height:60px;">
                            <h5 class="text-primary mb-0 d-flex flex-column mt-n1"><span>09</span><small class="text-primary fs--2 lh-1">MAR</small></h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body d-flex align-items-end">
                <div class="row g-3 justify-content-between">
                    <div class="col-10 mt-0">
                        <p class="fs--1 text-600 mb-0">Lorem ipsum dolor sit amet consectetur adipisicing elit. Iste fugiat, voluptas doloremque atque ipsum similique.</p>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-success w-100 fs--1" type="button" data-bs-toggle="modal" data-bs-target="#modal-gateway-xl" id="button-tambah-aktifitas"><span class="fab fa-whmcs me-2"></span>Aktifitas Baru</button>
                    </div>
                    <div class="col-auto ps-0">
                        <div class="avatar-group avatar-group-dense">
                            <div class="avatar avatar-xl border border-3 border-light rounded-circle">
                                <img class="rounded-circle" src="{{ asset('asset/img/team/1-thumb.png') }}" alt="" />

                            </div>
                            <div class="avatar avatar-xl border border-3 border-light rounded-circle">
                                <div class="avatar-name rounded-circle "><span>+50</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row g-3 mb-3">
    <div class="col-xl-6 col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                <div class="row g-3">
                    <div class="col-sm-6 col-md-6">
                        <div class="card overflow-hidden" style="min-width: 12rem">
                            <div class="bg-holder bg-card" style="background-image:url(../../../asset/img/icons/spot-illustrations/corner-1.png);">
                            </div>
                            <!--/.bg-holder-->

                            <div class="card-body position-relative">
                                <h6>Total Penerima<span class="badge badge-soft-warning rounded-pill ms-2">-0.23%</span></h6>
                                <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-warning" data-countup='{"endValue":58.386,"decimalPlaces":2,"suffix":"k"}'>
                                    {{ $penerima }}
                                </div><a class="fw-semi-bold fs--1 text-nowrap" href="#" data-bs-toggle="modal" data-bs-target="#modal-gateway" id="button-show-data-penerima">Lihat Data<span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6">
                        <div class="card overflow-hidden" style="min-width: 12rem">
                            <div class="bg-holder bg-card" style="background-image:url(../../../asset/img/icons/spot-illustrations/corner-2.png);">
                            </div>
                            <!--/.bg-holder-->

                            <div class="card-body position-relative">
                                <h6>Total Orders<span class="badge badge-soft-info rounded-pill ms-2">0.0%</span></h6>
                                <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-info" data-countup='{"endValue":23.434,"decimalPlaces":2,"suffix":"k"}'>0</div><a class="fw-semi-bold fs--1 text-nowrap" href="#">
                                    Lihat Order <span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-lg-6 order-xxl-1">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Jadwal Aktifitas</h6>
            </div>
            <div class="card-body scrollbar recent-activity-body-height ps-2">
                @foreach ($jadwal as $jadwals)
                <div class="row g-3 timeline timeline-primary timeline-past pb-card">
                    <div class="col-auto ps-4 ms-2">
                        <div class="ps-2">
                            <div class="icon-item icon-item-sm rounded-circle bg-200 shadow-none"><span class="text-primary fab fa-whatsapp"></span></div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="row gx-0 border-bottom pb-card">
                            <div class="col">
                                <h6 class="text-800 mb-1">{{ $jadwals->gateway_jadwal_date }} , {{ $jadwals->gateway_jadwal_time }}</h6>
                                <p class="fs--1 text-600 mb-0">{{ $jadwals->gateway_jadwal_pesan }}</p>
                            </div>
                            <div class="col-auto">
                                <p class="fs--2 text-500 mb-0"><span class="badge bg-primary">{{ $jadwals->gateway_jadwal_type }}</span></p>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                <!-- <div class="row g-3 timeline timeline-primary timeline-past pb-card">
                    <div class="col-auto ps-4 ms-2">
                        <div class="ps-2">
                            <div class="icon-item icon-item-sm rounded-circle bg-200 shadow-none"><span class="text-primary fas fa-archive"></span></div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="row gx-0 border-bottom pb-card">
                            <div class="col">
                                <h6 class="text-800 mb-1">Emma archived a board</h6>
                                <p class="fs--1 text-600 mb-0">A finished project's board is archived recently</p>
                            </div>
                            <div class="col-auto">
                                <p class="fs--2 text-500 mb-0">26m ago</p>
                            </div>
                        </div>
                    </div>
                </div> -->
                <div class="row g-3 timeline timeline-primary">
                    <div class="col-auto ps-4 ms-2">
                        <div class="ps-2">
                            <div class="icon-item icon-item-sm rounded-circle bg-200 shadow-none"><span class="text-primary far fa-file-code"></span></div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="row gx-0">
                            <div class="col">
                                <h6 class="text-800 mb-1">Coming Soon</h6>
                                <p class="fs--1 text-600 mb-0">Fixed some bugs and spelling errors on this update</p>
                            </div>
                            <div class="col-auto">
                                <p class="fs--2 text-500 mb-0">4h ago</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('base.js')
<div class="modal fade" id="modal-gateway" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document" style="max-width: 95%;">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-gateway"></div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-gateway-xl" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-gateway-xl"></div>
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
    $(document).on("click", "#button-add-penerima", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-gateway-xl').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('gateway_pengiriman_notifikasi_add_penerima') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-gateway-xl').html(data);
        }).fail(function() {
            $('#menu-gateway-xl').html('eror');
        });
    });
    $(document).on("click", "#button-show-data-penerima", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-gateway').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('gateway_pengiriman_notifikasi_data_penerima') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-gateway').html(data);
        }).fail(function() {
            $('#menu-gateway').html('eror');
        });
    });
    $(document).on("click", "#button-edit-data-penerima", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-data-penerima-notifikasi').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('gateway_pengiriman_notifikasi_edit_data_penerima') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-data-penerima-notifikasi').html(data);
        }).fail(function() {
            $('#menu-data-penerima-notifikasi').html('eror');
        });
    });
    $(document).on("click", "#button-tambah-aktifitas", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-gateway-xl').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('gateway_pengiriman_notifikasi_add_aktifitas') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-gateway-xl').html(data);
        }).fail(function() {
            $('#menu-gateway-xl').html('eror');
        });
    });
    $(document).on("click", "#button-proses-aktifitas-notifikasi", function(e) {
        e.preventDefault();
        $.ajax({
            url: "{{ route('gateway_pengiriman_notifikasi_proses_aktifitas') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": 0
            },
            dataType: 'html',
        }).done(function(data) {
            console.log(data);
        }).fail(function() {
            console.log('error');
        });
    });
    setInterval(() => {
        document.getElementById("button-proses-aktifitas-notifikasi").click();
    }, 5000);
</script>
<script>
    $(document).on("click", "#button-save-data-penerima", function(e) {
        e.preventDefault();
        $('#loading-button').html(
            '<button class="btn btn-primary" type="button" disabled=""><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...</button>'
        );
        const nama = document.getElementById('nama_lengkap').value;
        const no_hp = document.getElementById('no_hp').value;
        const jk = document.getElementById('jk').value;
        if (nama == "" || no_hp == "" || jk == "") {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Nama , Jenis Kelamin dan Tanggal Lahir Tidak boleh kosong",
                footer: "<a href=\"#\">Why do I have this issue?</a>"
            });
            $('#loading-button').html(
                '<button class="btn btn-primary" type="button" id="button-save-data-penerima"><span class="fas fa-save"></span> Simpan & Kirim</button>'
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
                    var data = $("#form-add-penerima").serialize();
                    $.ajax({
                        url: "{{ route('gateway_pengiriman_notifikasi_save_penerima') }}",
                        type: "POST",
                        cache: false,
                        data: data,
                        dataType: 'html',
                    }).done(function(data) {
                        if (data == 1) {
                            swalWithBootstrapButtons.fire({
                                title: "Sukses!",
                                text: "Your data has been Success.",
                                icon: "success"
                            });
                            location.reload();
                        } else {
                            swalWithBootstrapButtons.fire({
                                title: "Gagal Menyimpan",
                                text: "Ada Kesalahan pada Saat menyimpan",
                                icon: "error"
                            });
                            $('#loading-button').html(
                                '<button class="btn btn-primary" type="button" id="button-save-data-penerima"><span class="fas fa-save"></span> Simpan & Kirim</button>'
                            );
                        }

                    }).fail(function() {
                        swalWithBootstrapButtons.fire({
                            title: "Cancelled",
                            text: "Failed",
                            icon: "error"
                        });
                        $('#loading-button').html(
                            '<button class="btn btn-primary" type="button" id="button-save-data-penerima"><span class="fas fa-save"></span> Simpan & Kirim</button>'
                        );
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel)
                    swalWithBootstrapButtons.fire({
                        title: "Cancelled",
                        text: "Failed",
                        icon: "error"
                    });
                $('#loading-button').html(
                    '<button class="btn btn-primary" type="button" id="button-save-data-penerima"><span class="fas fa-save"></span> Simpan & Kirim</button>'
                );
            });
        }

    });
    $(document).on("click", "#button-save-data-aktifitas", function(e) {
        e.preventDefault();
        $('#loading-button').html(
            '<button class="btn btn-primary" type="button" disabled=""><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...</button>'
        );
        const tgl_aktifitas = document.getElementById('tgl_aktifitas').value;
        const time_aktifitas = document.getElementById('time_aktifitas').value;
        const type_send = document.getElementById('type_send').value;
        const pesan = document.getElementById('pesan').value;
        if (tgl_aktifitas == "" || type_send == "" || pesan == "" || time_aktifitas == "") {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Inputan TIdak Boleh Kosong",
                footer: "<a href=\"#\">Why do I have this issue?</a>"
            });
            $('#loading-button').html(
                '<button class="btn btn-primary" type="button" id="button-save-data-aktifitas"><span class="fas fa-save"></span> Simpan & Kirim</button>'
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
                    var data = $("#form-add-aktifitas").serialize();
                    $.ajax({
                        url: "{{ route('gateway_pengiriman_notifikasi_save_aktifitas') }}",
                        type: "POST",
                        cache: false,
                        data: data,
                        dataType: 'html',
                    }).done(function(data) {
                        if (data == 1) {
                            swalWithBootstrapButtons.fire({
                                title: "Sukses!",
                                text: "Your data has been Success.",
                                icon: "success"
                            });
                            location.reload();
                        } else {
                            swalWithBootstrapButtons.fire({
                                title: "Gagal Menyimpan",
                                text: "Ada Kesalahan pada Saat menyimpan",
                                icon: "error"
                            });
                            $('#loading-button').html(
                                '<button class="btn btn-primary" type="button" id="button-save-data-aktifitas"><span class="fas fa-save"></span> Simpan & Kirim</button>'
                            );
                        }

                    }).fail(function() {
                        swalWithBootstrapButtons.fire({
                            title: "Cancelled",
                            text: "Failed",
                            icon: "error"
                        });
                        $('#loading-button').html(
                            '<button class="btn btn-primary" type="button" id="button-save-data-aktifitas"><span class="fas fa-save"></span> Simpan & Kirim</button>'
                        );
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel)
                    swalWithBootstrapButtons.fire({
                        title: "Cancelled",
                        text: "Failed",
                        icon: "error"
                    });
                $('#loading-button').html(
                    '<button class="btn btn-primary" type="button" id="button-save-data-aktifitas"><span class="fas fa-save"></span> Simpan & Kirim</button>'
                );
            });
        }

    });
</script>
@endsection
