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
                                            <input type="text" name="jumlah" id="jumlah"
                                                value="{{ $pemeriksaan->count() }}" hidden>
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
                                                    <div class="divider-content-center">Status Pemeriksaan Disini</div>
                                                </div>
                                                <div class="col-12">
                                                    <div id="tableExample2" data-list='{"valueNames":["name","email","age"],"page":5,"pagination":true}'>
                                                        <div class="table-responsive scrollbar">
                                                            <table class="table table-bordered table-striped fs--1 mb-0 border">
                                                                <thead class="bg-200 text-900">
                                                                    <tr>
                                                                        <th class="sort" data-sort="name">Nama Pemeriksaan</th>
                                                                        <th class="text-center" data-sort="email">Status</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="list">
                                                                    <?php $hitung = 0; ?>
                                                                    @foreach ($pemeriksaan as $pem)
                                                                    <tr>
                                                                        <td class="name">{{$pem->master_pemeriksaan_name}}</td>
                                                                        <td class="text-center">
                                                                            <?php

                                                                            $cek = Illuminate\Support\Facades\DB::table('log_pemeriksaan_pasien')->where('mou_peserta_code', $data->mou_peserta_code)->where('master_pemeriksaan_code', $pem->master_pemeriksaan_code)->first()
                                                                            ?>
                                                                            @if ($cek)
                                                                            <input class="form-check-input" name="pemeriksaan" id="pem{{$pem->master_pemeriksaan_code}}" type="checkbox" onclick="MyFunction('{{$pem->master_pemeriksaan_code}}','{{ $data->mou_peserta_code }}')" checked />
                                                                            <?php $hitung = $hitung + 1; ?>
                                                                            @else
                                                                            <input class="form-check-input" name="pemeriksaan" id="pem{{$pem->master_pemeriksaan_code}}" type="checkbox" onclick="MyFunction('{{$pem->master_pemeriksaan_code}}','{{ $data->mou_peserta_code }}')" />
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <!-- <div class="d-flex justify-content-center mt-3">
                                                            <button class="btn btn-sm btn-falcon-default me-1" type="button" title="Previous" data-list-pagination="prev"><span class="fas fa-chevron-left"></span></button>
                                                            <ul class="pagination mb-0"></ul>
                                                            <button class="btn btn-sm btn-falcon-default ms-1" type="button" title="Next" data-list-pagination="next"><span class="fas fa-chevron-right"> </span></button>
                                                        </div> -->
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
                                                <input type="text" name="cabang"
                                                    value="{{ $data->log_kehadiran_pasien_lokasi }}" hidden>
                                                <input type="text" name="peserta"
                                                    value="{{ $data->mou_peserta_code }}" hidden>

                                                <div class="col-md-12">
                                                    @if ($hitung == $pemeriksaan->count())
                                                    <button class="btn btn-danger w-100 " id="button-submit-selesai"
                                                        type="submit" name="submit">Simpan</button>
                                                    @else
                                                    <button class="btn btn-danger w-100 " id="button-submit-selesai"
                                                        type="submit" name="submit" style="display: none;">Simpan</button>

                                                    @endif
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
    <script>
        function MyFunction(id, x) {
            var total = document.getElementById('jumlah').value;
            if ($('#pem' + id).is(":checked")) {
                var pilihan = 'on';
            } else {
                var pilihan = 'off';
            }
            $.ajax({
                url: "{{ route('signaturepad.update_pemeriksaan') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": id,
                    "user": x,
                    "option": pilihan,
                },
                dataType: 'html',
            }).done(function(data) {
                if (data == total) {
                    $("#button-submit-selesai").show();
                } else {
                    $("#button-submit-selesai").hide();
                }
            }).fail(function() {
                console.log('eror');

            });
        }
    </script>

</body>

</html>
