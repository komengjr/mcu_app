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
    <link rel="stylesheet" href="{{ asset('asset/notifications/css/lobibox.min.css') }}" />

    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link href="{{ asset('vendors/overlayscrollbars/OverlayScrollbars.min.css') }}" rel="stylesheet">
    <link href="{{ asset('asset/css/theme-rtl.min.css') }}" rel="stylesheet" id="style-rtl">
    <link href="{{ asset('asset/css/theme.min.css') }}" rel="stylesheet" id="style-default">
    <link href="{{ asset('asset/css/user-rtl.min.css') }}" rel="stylesheet" id="user-style-rtl">
    <link href="{{ asset('asset/css/user.min.css') }}" rel="stylesheet" id="user-style-default">

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <link type="text/css" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css" rel="stylesheet">

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script type="text/javascript" src="https://keith-wood.name/js/jquery.signature.js"></script>
    <link rel="stylesheet" type="text/css" href="https://keith-wood.name/css/jquery.signature.css">
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

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f4f7f6;
        }

        canvas {
            background-color: #b00a0a;
            display: block;
            margin: 0 auto;
            height: 200px;
        }

        .choices .choices__inner {
            background-color: #f8f9fa;
            border-radius: 8px;
            border: 1px solid #dee2e6;
        }

        /* Modern Glass/Card Styling */
        .auth-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }

        .bg-gradient-danger-custom {
            background: linear-gradient(135deg, #e63946 0%, #b00a0a 100%);
        }

        /* Header Logo Styling */
        .header-logos {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            margin-bottom: 2rem;
        }

        .logo-box {
            background: rgba(244, 239, 239, 0.15);
            backdrop-filter: blur(25px);
            padding: 8px 14px;
            border-radius: 12px;
            border: 1px solid rgba(73, 230, 16, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-box img {
            max-height: 45px;
            width: auto;
            object-fit: contain;
        }

        .form-control-modern {
            border-radius: 8px;
            padding: 10px 15px;
            border: 1px solid #ced4da;
            transition: all 0.2s ease-in-out;
        }

        .form-control-modern:focus {
            border-color: #e63946;
            box-shadow: 0 0 0 0.25rem rgba(230, 57, 70, 0.15);
        }

        .btn-modern {
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.2s;
        }

        .btn-modern:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(230, 57, 70, 0.3);
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
                <div class="col-lg-10 col-xxl-8 py-3 position-relative">
                    <img class="bg-auth-circle-shape" src="../../../asset/img/icons/spot-illustrations/bg-shape.png" alt="" width="250">
                    <img class="bg-auth-circle-shape-2" src="../../../asset/img/icons/spot-illustrations/shape-1.png" alt="" width="150">

                    <div class="card auth-card overflow-hidden z-index-1">
                        <div class="card-body p-0">
                            <div class="row g-0 h-100">

                                <!-- SISI KIRI (RED GRADIENT PANEL) -->
                                <div class="col-md-5 bg-gradient-danger-custom text-white d-flex flex-column justify-content-between position-relative p-4 p-lg-5">
                                    <div class="bg-holder bg-auth-card-shape" style="background-image:url(../../../asset/img/icons/spot-illustrations/half-circle.png);"></div>

                                    <div class="z-index-1 position-relative w-100">
                                        <!-- LOGO HEADER: LOGO UTAMA DI KIRI, LOGO PERUSAHAAN DI KANAN -->
                                        <div class="header-logos" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 2rem;">
                                            <!-- Logo Utama (Atas Kiri) -->
                                            <div class="logo-box" style="background: #ffffff; padding: 10px 16px; border-radius: 12px; border: 1px solid rgba(255, 255, 255, 0.8); box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15); display: flex; align-items: center; justify-content: center;">
                                                <img src="{{ asset('img/pram.png') }}" alt="Logo Utama" style="max-height: 45px; width: auto; object-fit: contain;">
                                            </div>

                                            <!-- Logo Perusahaan (Atas Kanan) -->
                                            <div class="logo-box" style="background: #ffffff; padding: 10px 16px; border-radius: 12px; border: 1px solid rgba(255, 255, 255, 0.8); box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15); display: flex; align-items: center; justify-content: center;">
                                                @if (!empty($data->master_company_logo) && file_exists(public_path('uploads/company_logo/' . $data->master_company_logo)))
                                                <img src="{{ asset('uploads/company_logo/' . $data->master_company_logo) }}" alt="Logo {{ $data->master_company_name }}" style="max-height: 45px; width: auto; object-fit: contain;">
                                                @else
                                                <img src="{{ asset('img/company.png') }}" alt="Default Logo" style="max-height: 45px; width: auto; object-fit: contain;">
                                                @endif
                                            </div>
                                        </div>

                                        <!-- TEKS UCAPAN & INFORMASI -->
                                        <div class="mt-4">
                                            <span class="badge bg-white text-danger fw-bold px-3 py-2 rounded-pill mb-3">Sistem Absensi MCU</span>
                                            <h3 class="text-white fw-bold lh-sm mb-2">Selamat Datang Peserta MCU</h3>
                                            <h4 class="text-white-50 fw-normal mb-4">{{ $data->master_company_name }}</h4>

                                            <p class="text-white-50 fs--1 lh-lg mb-0">
                                                Silakan lengkapi verifikasi data absensi Anda untuk pelaksanaan Project
                                                <strong class="text-white">{{ $data->company_mou_name }}</strong>.
                                            </p>
                                        </div>
                                    </div>

                                    <div class="z-index-1 position-relative mt-4 pt-3 border-top border-white-subtle">
                                        <small class="text-white-50">&copy; {{ date('Y') }} Medical Check Up Management System</small>
                                    </div>
                                </div>

                                <!-- SISI KANAN (FORM PANEL) -->
                                <div class="col-md-7 d-flex flex-center bg-white">
                                    <div class="p-4 p-lg-5 flex-grow-1">
                                        <div class="d-flex align-items-center mb-4">
                                            <div class="avatar avatar-xl me-2">
                                                <div class="avatar-name rounded-circle bg-soft-danger text-danger">
                                                    <span class="fas fa-user-check"></span>
                                                </div>
                                            </div>
                                            <div>
                                                <h4 class="text-dark fw-bold mb-0">Verifikasi Peserta MCU</h4>
                                                <small class="text-muted">Isi form di bawah untuk melanjutkan</small>
                                            </div>
                                        </div>

                                        <div class="row g-3">
                                            <div class="col-md-12">
                                                <label class="form-label fw-semibold text-700" for="organizerSingle">Pilih Lokasi MCU <span class="text-danger">*</span></label>
                                                <select class="form-select js-choice" id="organizerSingle" size="1" name="organizerSingle" data-options='{"removeItemButton":true,"placeholder":true}'>
                                                    <option value="">Select Cabang</option>
                                                    @foreach ($cabang as $cabangs)
                                                    @if ($cabangs->master_cabang_code != 'COBA')
                                                    <option value="{{ $cabangs->master_cabang_code }}">{{ $cabangs->master_cabang_name }}</option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-12">
                                                <label class="form-label fw-semibold text-700" for="nip">No Induk Pegawai (NIP) <span class="text-danger">*</span></label>
                                                <input class="form-control form-control-modern text-center fw-bold fs-0" type="text" name="nip" id="nip" placeholder="Masukkan NIP Anda" autocomplete="off" />
                                                <input type="text" name="code" id="code" value="{{ $data->company_mou_code }}" hidden>
                                            </div>

                                            <div class="col-md-12 pt-2">
                                                <button class="btn btn-danger btn-modern w-100 shadow-sm" id="button-cari-data-peserta">
                                                    <span class="fas fa-search me-2"></span> Cari Data Peserta
                                                </button>
                                            </div>

                                            <div class="col-md-12 mt-3">
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
        </div>
    </main>

    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->
    <script src="{{ asset('vendors/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendors/anchorjs/anchor.min.js') }}"></script>
    <script src="{{ asset('vendors/is/is.min.js') }}"></script>
    <script src="{{ asset('vendors/fontawesome/all.min.js') }}"></script>
    <script src="{{ asset('vendors/lodash/lodash.min.js') }}"></script>
    <script src="{{ asset('vendors/list.js/list.min.js') }}"></script>
    <script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
    <script src="{{ asset('asset/notifications/js/notifications.min.js') }}"></script>

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
                    '<div class="spinner-border my-3 text-danger" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
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
                        '<div class="alert alert-warning text-center" role="alert">Data Belum Lengkap, Reload dalam 3 detik</div>'
                    );
                });
            }
        });
    </script>
</body>

</html>
