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
                    <h4 class="text-danger fw-bold mb-0">Pengiriman <span class="text-danger fw-medium">MCU</span></h4>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header bg-danger">
        <div class="row align-items-center">
            <div class="col">
                <h5 class="mb-0">Pengiriman Management</h5>
            </div>
            <div class="col-auto py-0">
                <div class="btn-group  float-end" role="group">
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
        </div>
    </div>
    <form class="card">

        <div class="card-body p-0">
            <div class="row px-3 py-3">
                <div class="col-md-4" >
                    <label for="organizerSingle" class="my-0">Pilih Metode Kirim</label>
                    <select class="form-select js-choice bg-light" id="metode" name="metode">
                        <option value="">Pilih</option>
                        <option value="mail">Email</option>
                        <option value="whatsapp">Whatsapp</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="organizerSingle" class="my-0">Pilih Perusahaan</label>
                    <select class="form-select js-choice bg-light" id="perusahaan" name="perusahaan">
                        <option value="">Select Perusahaan</option>
                        @foreach ($perusahaan as $per)
                        <option value="{{ $per->master_company_code  }}">{{ $per->master_company_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="organizerSingle" class="my-0">Status Mcu</label>
                    <select class="form-select js-choice bg-light" id="status_mcu" name="status_mcu" disabled>
                        <option value="">Select Status</option>
                        <option value="all">All</option>
                        <option value="sudah">Sudah MCU</option>
                        <option value="belum">Belum MCU</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="organizerSingle" class="my-0">Template Pengiriman</label>
                    <select class="form-select js-choice bg-light" id="template" name="template">
                        <option value="">Pilih Template</option>
                        <option value="1">Template 1</option>
                        <option value="2">Template 2</option>
                    </select>
                </div>

                <div class="col-8">

                    <span id="option-project"></span>

                </div>
                <div class="col-md-12">
                    <span id="option-peserta"></span>
                </div>
            </div>
            <!-- <div class="border border-top border-200">
                <input class="form-control border-0 rounded-0 outline-none px-card" id="email-to" type="email" aria-describedby="email-to" placeholder="To" />
            </div> -->
            <div class="border border-y-0 border-200">
                <input class="form-control form-control-lg border-0 rounded-0 outline-none px-card" id="email-subject" type="text" aria-describedby="email-subject" placeholder="Subject" />
            </div>
            <div class="min-vh-50" id="menu-template" style="display: none;">
                <textarea class="tinymce d-none" name="textAreaName" id="pesan"></textarea>
            </div>
            <div class="min-vh-10 pt-4" id="menu-template-wa" style="display: none;">
                <textarea class="form-control" name="textAreaName" rows="10" id="pesan-wa"></textarea>
            </div>
            <!-- <div class="bg-light px-card py-3">
                <div class="d-inline-flex flex-column">
                    <div class="border px-2 rounded-3 d-flex flex-between-center bg-white dark__bg-1000 my-1 fs--1"><span class="fs-1 far fa-image"></span><span class="ms-2">winter.jpg (873kb)</span><a class="text-300 p-1 ms-6" href="#!" data-bs-toggle="tooltip" data-bs-placement="right" title="Detach"><span class="fas fa-times"></span></a></div>
                    <div class="border px-2 rounded-3 d-flex flex-between-center bg-white dark__bg-1000 my-1 fs--1"><span class="fs-1 far fa-file-archive"></span><span class="ms-2">coffee.zip (342kb)</span><a class="text-300 p-1 ms-6" href="#!" data-bs-toggle="tooltip" data-bs-placement="right" title="Detach"><span class="fas fa-times"></span></a></div>
                </div>
            </div> -->
        </div>
        <div class="card-footer border-top border-200 d-flex flex-between-center">
            <div class="d-flex align-items-center" id="loading-pengiriman">
                <button class="btn btn-primary btn-sm px-5 me-2" type="button" id="button-kirim-pesan" style="display: none;">Send</button>
                <!-- <input class="d-none" id="email-attachment" type="file" />
                <label class="me-2 btn btn-light btn-sm mb-0 cursor-pointer" for="email-attachment" data-bs-toggle="tooltip" data-bs-placement="top" title="Attach files"><span class="fas fa-paperclip fs-1" data-fa-transform="down-2"></span></label>
                <input class="d-none" id="email-image" type="file" accept="image/*" />
                <label class="btn btn-light btn-sm mb-0 cursor-pointer" for="email-image" data-bs-toggle="tooltip" data-bs-placement="top" title="Attach images"><span class="fas fa-image fs-1" data-fa-transform="down-2"></span></label> -->
            </div>
            <div class="d-flex align-items-center">
                <!-- <div class="dropdown font-sans-serif me-2 btn-reveal-trigger">
                    <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal dropdown-caret-none" id="email-options" type="button" data-bs-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false"><span class="fas fa-ellipsis-v" data-fa-transform="down-2"></span></button>
                    <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="email-options"><a class="dropdown-item" href="#!">Print</a><a class="dropdown-item" href="#!">Check spelling</a><a class="dropdown-item" href="#!">Plain text mode</a>
                        <div class="dropdown-divider"></div><a class="dropdown-item" href="#!">Archive</a>
                    </div>
                </div>
                <button class="btn btn-light btn-sm" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"> <span class="fas fa-trash"></span></button> -->
            </div>
        </div>
    </form>
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
<script src="{{ asset('vendors/tinymce/tinymce.min.js') }}"></script>
<script>
    new DataTable('#example', {
        responsive: true
    });
</script>
<script>
    new window.Choices(document.querySelector(".js-choice"));
</script>
<script>
    $(document).on("click", "#button-kirim-pesan", function(e) {
        e.preventDefault();
        var editorContent = tinymce.activeEditor.getContent();
        var subject = document.getElementById("email-subject").value;
        var pilihan = document.getElementById("project-site").value;
        var status = document.getElementById("status_mcu").value;
        var dataproject = document.getElementById("project").value;
        var metode = document.getElementById("metode").value;
        var pesan_wa = document.getElementById("pesan-wa").value;
        var peserta = $('#pesertamcu').val();

        if (pilihan == "" || peserta == "" || subject == "") {
            Lobibox.notify('warning', {
                pauseDelayOnHover: true,
                continueDelayOnInactiveTab: true,
                position: 'top right',
                icon: 'fas fa-info-circle',
                msg: 'Pastikan Pilihan diisi Terlebih Dahulu'
            });
        } else {
            $('#loading-pengiriman').html(
                '<span class="badge bg-warning">Prosess , Reload.. dalam 3 detik</span>'
            );
            $.ajax({
                url: "{{ route('menu_pengiriman_send_project') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "pesan": editorContent,
                    "subject": subject,
                    "pilihan": pilihan,
                    "status": status,
                    "dataproject": dataproject,
                    "peserta": peserta,
                    "metode": metode,
                    "pesan_wa": pesan_wa,
                },
                dataType: 'html',
            }).done(function(data) {
                location.reload();
            }).fail(function() {
                $('#menu-mcu').html(
                    '<span class="badge bg-warning m-4">Data Belum Lengkap , Reload.. dalam 3 detik</span>'
                );
                setTimeout(() => {
                    location.reload();
                }, 2000);
            });
        }
    });
</script>
<script>
    $('#template').on("change", function() {
        var template = document.getElementById("template").value;
        var metode = document.getElementById("metode").value;
        if (template == "") {
            Lobibox.notify('warning', {
                pauseDelayOnHover: true,
                continueDelayOnInactiveTab: true,
                position: 'top right',
                icon: 'fas fa-info-circle',
                msg: 'Pastikan Pilih Template Dulu'
            });
        } else {
            if (metode == "") {
                Lobibox.notify('warning', {
                    pauseDelayOnHover: true,
                    continueDelayOnInactiveTab: true,
                    position: 'top right',
                    icon: 'fas fa-info-circle',
                    msg: 'Pastikan Pilih Metode Kirim Dulu'
                });
            } else if (metode == "mail") {
                $("#menu-template-wa").hide();
                $("#menu-template").show();
                $("#button-kirim-pesan").show();
            } else if (metode == "whatsapp") {
                $("#menu-template").hide();
                $("#menu-template-wa").show();
                $("#button-kirim-pesan").show();
            }
        }
    });
    $('#metode').on("change", function() {
        var dataid = document.getElementById("metode").value;
        if (dataid == "") {
            Lobibox.notify('warning', {
                pauseDelayOnHover: true,
                continueDelayOnInactiveTab: true,
                position: 'top right',
                icon: 'fas fa-info-circle',
                msg: 'Pastikan Sudah dipilih'
            });
        } else {
            $("#menu-template-wa").hide();
            $("#menu-template").hide();
            $("#button-kirim-pesan").hide();
        }
    });
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
                url: "{{ route('menu_pengiriman_pilih_perusahaan') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": dataid,
                },
                dataType: 'html',
            }).done(function(data) {
                $("#option-project").html(data);
            }).fail(function() {
                console.log('eror');
            });
        }
    });
</script>
@endsection
