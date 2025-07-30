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

    <!-- <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> -->
    <!-- <link type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css"
        rel="stylesheet"> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    {{-- <script type="text/javascript" src="http://keith-wood.name/js/jquery.signature.js"></script> --}}
    <!-- <link rel="stylesheet" type="text/css" href="http://keith-wood.name/css/jquery.signature.css"> -->
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
</head>


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
                                            <p class="opacity-75 text-white">Selamat Data Peserta di Monitoring Medical Check Up System Management, Pastiksan Sebelum Mengisi Semua Data Untuk Melakukan pengecekan Nama dan Gelar</p>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-7 d-flex flex-center">
                                    <div class="p-4 flex-grow-1">
                                        <h3>Peserta MCU</h3>
                                        <form method="POST" action="{{ route('signaturepad.update_pemeriksaan_save') }}">
                                            @csrf
                                            <input type="text" name="token"
                                                value="{{ $data->log_kehadiran_pasien_token }}" hidden>
                                            <div class="row g-3">
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
                                                    <div class="divider-content-center">Pilih Paket Pemeriksaan</div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="accordion" id="accordionExample">
                                                        @foreach ($paket as $pakets)
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header" id="heading2">
                                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#colspan{{$pakets->id_mou_agreement}}" aria-expanded="true" aria-controls="collapse2">{{$pakets->mou_agreement_name}}</button>
                                                            </h2>
                                                            <div class="accordion-collapse collapse" id="colspan{{$pakets->id_mou_agreement }}" aria-labelledby="heading2" data-bs-parent="#accordionExample">
                                                                <div class="accordion-body">
                                                                    <?php
                                                                    $pemeriksaan = DB::table('company_mou_agreement_sub')
                                                                        ->join('master_pemeriksaan', 'master_pemeriksaan.master_pemeriksaan_code', '=', 'company_mou_agreement_sub.master_pemeriksaan_code')
                                                                        ->where('company_mou_agreement_sub.mou_agreement_code', $pakets->mou_agreement_code)->get();
                                                                    ?>
                                                                    @foreach ($pemeriksaan as $pem)
                                                                    <li>{{ $pem->master_pemeriksaan_name }}</li>
                                                                    @endforeach
                                                                    <button class="btn btn-primary btn-sm float-end" id="button-pilih-paket-pemeriksaan" data-id="{{ $data->mou_peserta_code }}" data-code="{{$pakets->mou_agreement_code}}" data-name="{{$pakets->mou_agreement_name}}">Pilih Paket</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endforeach
                                                        <!-- <div class="accordion-item">
                                                            <h2 class="accordion-header" id="heading4">
                                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="true" aria-controls="collapse4">Is there a fee to use Apple Pay or Google Pay?</button>
                                                            </h2>
                                                            <div class="accordion-collapse collapse" id="collapse4" aria-labelledby="heading4" data-bs-parent="#accordionExample">
                                                                <div class="accordion-body">There are no additional fees for using our mobile SDKs or to accept payments using consumer wallets like Apple Pay or Google Pay.</div>
                                                            </div>
                                                        </div> -->
                                                    </div>
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
    <!-- <script src="{{ asset('vendors/list.js/list.min.js') }}"></script> -->
    <script src="{{ asset('asset/js/theme.js') }}"></script>
    <script src="{{ asset('asset/notifications/js/notifications.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).on("click", "#button-pilih-paket-pemeriksaan", function(e) {
            e.preventDefault();
            var id = $(this).data("id");
            var code = $(this).data("code");
            var name = $(this).data("name");
            Swal.fire({
                title: "Apakah Kamu Yakin Memilih Paket " + name + " ?",
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: "Save",
                denyButtonText: `Don't save`
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire("Saved!", "", "success");
                    $.ajax({
                        url: "{{ route('signaturepad_pilih_pemeriksaan') }}",
                        type: "POST",
                        cache: false,
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "id": id,
                            "code": code
                        },
                        dataType: 'html',
                    }).done(function(data) {
                        location.reload();
                    }).fail(function() {
                        setTimeout(() => {
                            location.reload();
                        }, 2000);
                    });
                } else if (result.isDenied) {
                    Swal.fire("Changes are not saved", "", "info");
                }
            });
            // $('#menu-mcu').html(
            //     '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            // );

        });
    </script>
</body>

</html>
