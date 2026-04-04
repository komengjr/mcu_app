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
    <link href="{{ asset('vendors/overlayscrollbars/OverlayScrollbars.min.css') }}" rel="stylesheet">
    <link href="{{ asset('asset/css/theme-rtl.min.css') }}" rel="stylesheet" id="style-rtl">
    <link href="{{ asset('asset/css/theme.min.css') }}" rel="stylesheet" id="style-default">
    <link href="{{ asset('asset/css/user-rtl.min.css') }}" rel="stylesheet" id="user-style-rtl">
    <link href="{{ asset('asset/css/user.min.css') }}" rel="stylesheet" id="user-style-default">
    {{-- <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.css"> --}}

    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <link type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css"
        rel="stylesheet">

    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    {{-- <script type="text/javascript" src="http://keith-wood.name/js/jquery.signature.js"></script> --}}
    <link rel="stylesheet" type="text/css" href="http://keith-wood.name/css/jquery.signature.css">
    {{-- <script>
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
    </script> --}}
</head>
<style>
    .wrapper {
        position: relative;
        width: 200px;
        height: 200px;
        -moz-user-select: none;
        -webkit-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    img {
        /* position: absolute; */
        left: 0;
        top: 0;
    }

    .signature-pad {
        position: absolute;
        left: 0;
        top: 0;
        /* width: 400px;
            height: 200px; */
    }
</style>
<script src="{{ asset('asset/js/signature.js') }}"></script>

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
                                            <p class="opacity-75 text-white">With the power of System, you can now focus
                                                only on functionaries for your digital System, while leaving the UI
                                                design on us!</p>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-7 d-flex flex-center">
                                    <div class="p-4 p-md-3 flex-grow-1">
                                        <h3>Form Pengambilan Sample</h3>
                                        <form id="form-pengambilan-sample" method="POST">
                                            @csrf
                                            <input type="text" name="token"
                                                value="{{$token}}" hidden>
                                            <div class="row g-3">
                                                <div class="col-md-12">
                                                    <label class="form-label" for="card-name">Nama Lengkap</label>
                                                    <input class="form-control" type="text" autocomplete="on"
                                                        id="nama_lengkap" name="nama_lengkap" />
                                                </div>

                                                <div class="position-relative mt-2">
                                                    <hr class="bg-300" />
                                                    <div class="divider-content-center">Sign Here</div>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="wrapper">
                                                        <img src="{{ asset('img/bg.jpg') }}" width='300' height='200' />
                                                        <canvas id="signature-pad" class="signature-pad" width='300' height='200' style="border: 2px solid black;"></canvas>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 justify-content-between flex-column">
                                                    <div class="d-grid gap-2 mt-2 g-2 float-end">
                                                        <button class="btn btn-falcon-primary px-3" type="button" id="save"><span class="fas fa-file-signature"></span> Save</button>
                                                        <!-- <br> -->
                                                        <button class="btn btn-falcon-danger px-3" type="button" id="clear"><span class="fas fa-remove-format"></span> Clear</button>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="card-register-checkbox" />
                                                        <label class="form-label" for="card-register-checkbox">I
                                                            accept
                                                            the <a href="#!">terms </a>and <a
                                                                href="#!">privacy
                                                                policy</a></label>
                                                    </div>
                                                </div>
                                                <textarea id="signature64" name="signed" hidden></textarea>


                                                <div class="col-md-12" id="loading-button">
                                                    <button class="btn btn-danger w-100 " id="button-submit-sign-pengambilan-sample" type="button" name="submit">Register</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                {{-- <a href="#" onclick="myFunction()">Selsai</a> --}}
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
    <script src="{{ asset('asset/js/theme.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        var signaturePad = new SignaturePad(document.getElementById('signature-pad'), {
            backgroundColor: 'rgba(255, 255, 255, 0)',
            penColor: 'rgb(0, 0, 0)'
        });
        var saveButton = document.getElementById('save');
        var cancelButton = document.getElementById('clear');

        saveButton.addEventListener('click', function(event) {
            var data = signaturePad.toDataURL('image/png');
            $('#signature64').html(data);
            $("#button-submit-selesai").show();
            $("#save").hide();
        });

        cancelButton.addEventListener('click', function(event) {
            signaturePad.clear();
            $("#save").show();
            $("#button-submit-selesai").hide();
        });
    </script>
    <script>
        $(document).on("click", "#button-submit-sign-pengambilan-sample", function(e) {
            e.preventDefault();
            $('#loading-button').html(
                '<button class="btn btn-danger w-100 " type="button" disabled=""><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...</button>'
            );
            const nama = document.getElementById('nama_lengkap').value;
            const signature64 = document.getElementById('signature64').value;
            if (nama == "" || signature64 == "") {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Nama dan Tanda Tangan diisi Dulu Boss",
                    footer: "<a href=\"#\">Why do I have this issue?</a>"
                });
                $('#loading-button').html(
                    '<button class="btn btn-danger w-100 " id="button-submit-sign-pengambilan-sample" type="button" name="submit">Register</button>'
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
                        var data = $("#form-pengambilan-sample").serialize();
                        $.ajax({
                            url: "{{ route('pengambilan_sample_save') }}",
                            type: "POST",
                            cache: false,
                            data: data,
                            dataType: 'html',
                        }).done(function(data) {
                            if (data == 1) {
                                swalWithBootstrapButtons.fire({
                                    title: "Sukses!",
                                    text: "Your file has been deleted.",
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
                                    '<button class="btn btn-danger w-100 " id="button-submit-sign-pengambilan-sample" type="button" name="submit">Register</button>'
                                );
                            }

                        }).fail(function() {
                            swalWithBootstrapButtons.fire({
                                title: "Cancelled",
                                text: "Failed",
                                icon: "error"
                            });
                            $('#loading-button').html(
                                '<button class="btn btn-danger w-100 " id="button-submit-sign-pengambilan-sample" type="button" name="submit">Register</button>'
                            );
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel)
                        swalWithBootstrapButtons.fire({
                            title: "Cancelled",
                            text: "Failed",
                            icon: "error"
                        });
                    $('#loading-button').html(
                        '<button class="btn btn-danger w-100 " id="button-submit-sign-pengambilan-sample" type="button" name="submit">Register</button>'
                    );
                });
            }

        });
    </script>
</body>

</html>
