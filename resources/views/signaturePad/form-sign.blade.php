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


    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:300,400,500,600,700,800,900&amp;display=swap"
        rel="stylesheet">
    {{-- <link href="{{ asset('vendors/overlayscrollbars/OverlayScrollbars.min.css') }}" rel="stylesheet"> --}}
    <link href="{{ asset('asset/css/theme-rtl.min.css') }}" rel="stylesheet" id="style-rtl">
    <link href="{{ asset('asset/css/theme.min.css') }}" rel="stylesheet" id="style-default">
    <link href="{{ asset('asset/css/user-rtl.min.css') }}" rel="stylesheet" id="user-style-rtl">
    <link href="{{ asset('asset/css/user.min.css') }}" rel="stylesheet" id="user-style-default">
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.css">

    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <link type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css"
        rel="stylesheet">

    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script type="text/javascript" src="http://keith-wood.name/js/jquery.signature.js"></script>
    <link rel="stylesheet" type="text/css" href="http://keith-wood.name/css/jquery.signature.css">
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
    .kbw-signature {
        width: 100%;
        height: 200px;
    }

    #sig canvas {
        cursor: url('../../pin.png') 1 26, pointer;
        border: 2px solid var(--primary-color);
        border-radius: 4px;
        width: 100% !important;

        height: auto;

    }

    #sig {
        cursor: url('../../pin.png') 1 26, pointer;
        border: 2px solid var(--primary-color);
        border-radius: 4px;
    }

    @media (pointer: coarse) {
        body {
            overflow: hidden;
        }
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
                                            <p class="opacity-75 text-white">With the power of Falcon, you can now focus
                                                only on functionaries for your digital products, while leaving the UI
                                                design on us!</p>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-7 d-flex flex-center">
                                    <div class="p-4 p-md-3 flex-grow-1">
                                        <h3>Peserta MCU</h3>
                                        <form method="POST" action="{{ route('signaturepad.update') }}">
                                            @csrf
                                            <input type="text" name="token"
                                                value="{{ $data->log_kehadiran_pasien_token }}" hidden>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label class="form-label" for="card-name">Nama Lengkap</label>
                                                    <input class="form-control" type="text" autocomplete="on"
                                                        id="card-name" value="{{ $data->mou_peserta_name }}"
                                                        disabled />
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label" for="card-email">Nomor Induk
                                                        Pegawai</label>
                                                    <input class="form-control" type="text" autocomplete="on"
                                                        id="card-email" value="{{ $data->mou_peserta_nip }}"
                                                        disabled />
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label" for="card-email">Nomor Whatsapp</label>
                                                    <input class="form-control" type="text" autocomplete="on"
                                                        value="{{ $data->mou_peserta_no_hp }}" disabled />
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label" for="card-email">Email</label>
                                                    <input class="form-control" type="text" autocomplete="on"
                                                        value="{{ $data->mou_peserta_email }}" disabled />
                                                </div>
                                                <div class="position-relative mt-2">
                                                    <hr class="bg-300" />
                                                    <div class="divider-content-center">Sign Here</div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="card-register-checkbox" required />
                                                        <label class="form-label" for="card-register-checkbox">I
                                                            accept
                                                            the <a href="#!">terms </a>and <a
                                                                href="#!">privacy
                                                                policy</a></label>
                                                    </div>
                                                </div>
                                                <textarea id="signature64" name="signed" style="display: none" required></textarea>
                                                <div class="col-md-12">
                                                    <button class="btn btn-danger d-block w-100 " type="submit"
                                                        name="submit">Register</button>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <div class="col-md-12">
        <a href="#" id="clear" class="text-danger float-end">Clear Signature</a>
        <div id="sig"></div>
    </div>

    <!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->



    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->
    {{-- <script src="{{ asset('vendors/popper/popper.min.js') }}"></script> --}}
    <script src="{{ asset('vendors/bootstrap/bootstrap.min.js') }}"></script>
    {{-- <script src="{{ asset('vendors/anchorjs/anchor.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('vendors/is/is.min.js') }}"></script> --}}
    <script src="{{ asset('vendors/fontawesome/all.min.js') }}"></script>
    <script src="{{ asset('vendors/lodash/lodash.min.js') }}"></script>
    <script src="{{ asset('vendors/list.js/list.min.js') }}"></script>
    {{-- <script src="{{ asset('asset/js/theme.js') }}"></script> --}}
    <script type="text/javascript">
        var sig = $('#sig').signature({
            syncField: '#signature64',
            syncFormat: 'PNG'
        });
        sig.focus();
        $('#clear').click(function(e) {

            e.preventDefault();

            sig.signature('clear');

            $("#signature64").val('');

        });
    </script>
</body>

</html>
