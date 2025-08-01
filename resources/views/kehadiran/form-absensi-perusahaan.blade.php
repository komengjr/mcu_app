<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>Medical Check Up | Management System</title>


    <!-- ===============================================-->
    <!--    Favicons-->
    <!-- ===============================================-->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/dashboard.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/dashboard.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/dashboard.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/dashboard.png') }}">
    <link rel="manifest" href="{{ asset('asset/img/favicons/manifest.json') }}">
    <meta name="msapplication-TileImage" content="{{ asset('img/dashboard.png') }}">
    <meta name="theme-color" content="#ffffff">
    <script src="{{ asset('asset/js/config.js') }}"></script>
    {{-- <script src="{{ asset('vendors/overlayscrollbars/OverlayScrollbars.min.js') }}"></script> --}}
    <link rel="stylesheet" href="{{ asset('asset/notifications/css/lobibox.min.css') }}" />

    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:300,400,500,600,700,800,900&amp;display=swap"
        rel="stylesheet">
    <link href="{{ asset('vendors/overlayscrollbars/OverlayScrollbars.min.css') }}" rel="stylesheet">
    <link href="{{ asset('asset/css/theme-rtl.min.css') }}" rel="stylesheet" id="style-rtl">
    <link href="{{ asset('asset/css/theme.min.css') }}" rel="stylesheet" id="style-default">
    <link href="{{ asset('asset/css/user-rtl.min.css') }}" rel="stylesheet" id="user-style-rtl">
    <link href="{{ asset('asset/css/user.min.css') }}" rel="stylesheet" id="user-style-default">
    {{-- <link rel="stylesheet" type="text/css"  href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.css"> --}}

    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <link type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css"
        rel="stylesheet">

    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script type="text/javascript" src="http://keith-wood.name/js/jquery.signature.js"></script>
    <link rel="stylesheet" type="text/css" href="http://keith-wood.name/css/jquery.signature.css">
    <link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
    <script>
        var isRTL = JSON.parse(localStorage.getItem('isRTL'));
        if (isRTL) {
            var linkDefault = document.getElementById('style-default');
            var userLinkDefault = document.getElementById('user-style-default');
            linkDefault.setAttribute('disabled', true);
            userLinkDefault.setAttribute('disabled', true);
            document.querySelector('html').setAttribute('dir', 'rtl');
        } else {
            var linkRTL = document.getElementById('style-rtl');
            var userLinkRTL = document.getElementById('user-style-rtl');
            linkRTL.setAttribute('disabled', true);
            userLinkRTL.setAttribute('disabled', true);
        }
    </script>
</head>
<style>
    /* .kbw-signature {
        width: 100%;
        height: 200px;
    } */
    canvas {
        background-color: #b00a0a;
        display: block;
        margin: 0 auto;
        /* width: 100%; */
        height: 200px;
    }
    .choices .choices__inner {
        background-color: aliceblue;
    }
</style>

<body>

    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">
        <div class="container-fluid">
            <div class="row min-vh-100 flex-center g-0">
                <div class="col-lg-8 col-xxl-5 py-3 position-relative"><img class="bg-auth-circle-shape"
                        src="../../../asset/img/icons/spot-illustrations/bg-shape.png" alt=""
                        width="250"><img class="bg-auth-circle-shape-2"
                        src="../../../asset/img/icons/spot-illustrations/shape-1.png" alt="" width="150">
                    <div class="card overflow-hidden z-index-1">
                        <div class="card-body p-0">
                            <div class="row g-0 h-100">
                                <div class="col-md-5 text-center bg-gradient bg-danger ">
                                    <div class="position-relative p-4 pt-md-5 pb-md-7 light">
                                        <div class="bg-holder bg-auth-card-shape"
                                            style="background-image:url(../../../asset/img/icons/spot-illustrations/half-circle.png);">
                                        </div>
                                        <!--/.bg-holder-->

                                        <div class="z-index-1 position-relative">
                                            <a class="link-light mb-4 font-sans-serif fs-4 d-inline-block fw-bolder"
                                                href="#"><img src="{{ asset('img/pram.png') }}"
                                                    alt=""></a>
                                            <p class="opacity-100 text-white">
                                                Selamat Datang <strong>{{ $data->master_company_name }}</strong>
                                            </p>
                                            <p class="opacity-75 text-white">
                                                Form ini Untuk verifikasi data Absensi pada Project
                                                <strong>{{ $data->company_mou_name }}</strong>
                                            </p>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-7 d-flex flex-center">
                                    <div class="p-4 flex-grow-1">
                                        <h3 class="text-dark"><span class="badge bg-danger">Peserta MCU</span></h3>

                                        {{-- <input type="text" name="token"
                                                value="{{ $data->log_kehadiran_pasien_token }}" hidden> --}}
                                        <div class="row g-2">
                                            <div class="col-md-12">
                                                <label class="form-label" for="card-email">Pilih Lokasi MCU</label>
                                                <select class="form-select js-choice bg-light" id="organizerSingle"
                                                    size="1" name="organizerSingle"
                                                    data-options='{"removeItemButton":true,"placeholder":true}'>
                                                    <option value="">Select Cabang</option>
                                                    @foreach ($cabang as $cabangs)
                                                        <option value="{{ $cabangs->master_cabang_code }}">{{ $cabangs->master_cabang_name }}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                            <div class="col-md-12">
                                                <label class="form-label" for="card-email">No Induk Pegawai</label>
                                                <input class="form-control form-control-lg text-center" type="text"
                                                    name="nip" id="nip" autocomplete="on" />
                                                <input type="text" name="code" id="code"
                                                    value="{{ $data->company_mou_code }}" hidden>
                                            </div>
                                            <div class="col-md-12">
                                                <button class="btn btn-danger float-end"
                                                    id="button-cari-data-peserta"><span class="fas fa-search"></span>
                                                    Cari</button>
                                            </div>
                                            <span id="menu-template-sign"></span>
                                        </div>


                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>


    <!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->

    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->
    {{-- <script src="{{ asset('vendors/popper/popper.min.js') }}"></script> --}}
    <script src="{{ asset('vendors/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendors/anchorjs/anchor.min.js') }}"></script>
    <script src="{{ asset('vendors/is/is.min.js') }}"></script>
    <script src="{{ asset('vendors/fontawesome/all.min.js') }}"></script>
    <script src="{{ asset('vendors/lodash/lodash.min.js') }}"></script>
    <script src="{{ asset('vendors/list.js/list.min.js') }}"></script>
    <script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
    <script src="{{ asset('asset/notifications/js/notifications.min.js') }}"></script>
    {{-- <script src="{{ asset('asset/js/theme.js') }}"></script> --}}
    <script>
        new window.Choices(document.querySelector(".js-choice"));
    </script>
    <script>
        $(document).on("click", "#button-cari-data-peserta", function(e) {
            e.preventDefault();
            var code = document.getElementById("code").value;
            var nip = document.getElementById("nip").value;
            var cab = document.getElementById("organizerSingle").value;
            if (cab == "" || nip == "") {
                Lobibox.notify('warning', {
                    pauseDelayOnHover: true,
                    continueDelayOnInactiveTab: true,
                    position: 'top right',
                    icon: 'fas fa-info-circle',
                    msg: 'Pastikan Lokasi MCU dan NIP Sudah diisi'
                });
            } else {
                $('#menu-template-sign').html(
                    '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
                );
                $.ajax({
                    url: "{{ route('cari_data_absensi_peserta_mcu') }}",
                    type: "POST",
                    cache: false,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "code": code,
                        "nip": nip,
                        "cab": cab,
                    },
                    dataType: 'html',
                }).done(function(data) {
                    $('#menu-template-sign').html(data);
                }).fail(function() {
                    $('#menu-template-sign').html(
                        '<span class="badge bg-warning m-4">Data Belum Lengkap , Reload.. dalam 3 detik</span>'
                    );
                });
            }
        });
    </script>
</body>

</html>
