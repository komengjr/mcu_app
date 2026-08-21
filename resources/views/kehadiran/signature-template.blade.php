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

    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
    <link href="{{ asset('vendors/overlayscrollbars/OverlayScrollbars.min.css') }}" rel="stylesheet">
    <link href="{{ asset('asset/css/theme-rtl.min.css') }}" rel="stylesheet" id="style-rtl">
    <link href="{{ asset('asset/css/theme.min.css') }}" rel="stylesheet" id="style-default">
    <link href="{{ asset('asset/css/user-rtl.min.css') }}" rel="stylesheet" id="user-style-rtl">
    <link href="{{ asset('asset/css/user.min.css') }}" rel="stylesheet" id="user-style-default">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            background-color: #f8fafc;
        }

        /* Keyframe Bounce / Float Effect */
        @keyframes bounceFloat {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-12px);
            }
        }

        /* Animasi Mengambang untuk Shapes Latar Belakang Body */
        .bg-auth-circle-shape {
            animation: bounceFloat 6s ease-in-out infinite;
        }

        .bg-auth-circle-shape-2 {
            animation: bounceFloat 8s ease-in-out infinite reverse;
        }

        /* Multi-Layered Radiant Red Background (Panel Kiri) */
        .bg-gradient-red-vibrant {
            background: linear-gradient(155deg, #FF3355 0%, #C80022 55%, #7A0010 100%) !important;
            position: relative;
            overflow: hidden;
        }

        /* Glowing Orbs di Background Panel Kiri */
        .glow-orb {
            position: absolute;
            width: 220px;
            height: 220px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 50%;
            filter: blur(50px);
            pointer-events: none;
            animation: bounceFloat 5s ease-in-out infinite alternate;
        }

        .glow-orb-1 {
            top: -50px;
            right: -50px;
        }

        .glow-orb-2 {
            bottom: -70px;
            left: -50px;
            background: rgba(0, 0, 0, 0.25);
        }

        /* Floating Logo Container */
        .logo-box {
            background: rgba(255, 255, 255, 0.95);
            padding: 8px 18px;
            border-radius: 14px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .logo-box img {
            max-height: 38px;
            width: auto;
            object-fit: contain;
        }

        /* Glassmorphism Info Card (Panel Kiri) */
        .glass-info-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 18px;
            padding: 1.25rem;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        }

        /* Badge Accent */
        .badge-accent {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 5px 14px;
            border-radius: 50px;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            color: #ffffff;
            margin-bottom: 0.8rem;
        }

        /* Shiny Title Gradient Effect */
        .gradient-heading {
            background: linear-gradient(180deg, #FFFFFF 0%, #FFE0E6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        /* Left Accent Border for Quote / Info */
        .quote-border {
            border-left: 3px solid rgba(255, 255, 255, 0.8);
            padding-left: 1rem;
        }

        /* ===============================================*/
        /* PANEL KANAN - BORDER GRADASI MERAH MODERN       */
        /* ===============================================*/
        .right-panel-gradient-border {
            position: relative;
            background: #ffffff;
            border-radius: 0 24px 24px 0;
            padding: 2px;
            /* Tebal Border */
            background-image: linear-gradient(135deg, #FF3355 0%, #E60026 50%, rgba(200, 0, 34, 0.2) 100%);
        }

        /* Container Dalam Panel Kanan */
        .right-panel-content {
            background: #ffffff;
            border-radius: 0 22px 22px 0;
            height: 100%;
        }

        @media (max-width: 767.98px) {
            .right-panel-gradient-border {
                border-radius: 0 0 24px 24px;
                background-image: linear-gradient(180deg, #FF3355 0%, #E60026 50%, rgba(200, 0, 34, 0.2) 100%);
            }

            .right-panel-content {
                border-radius: 0 0 22px 22px;
            }
        }

        /* Signature Area Simetris */
        .signature-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 100%;
        }

        .wrapper {
            position: relative;
            width: 100%;
            max-width: 450px;
            height: 200px;
            border-radius: 14px;
            overflow: hidden;
            border: 2px dashed #E2E8F0;
            background-color: #FAFAFA;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.02);
            transition: all 0.3s ease;
        }

        .wrapper:hover {
            border-color: #E60026;
            box-shadow: 0 4px 15px rgba(230, 0, 38, 0.08);
        }

        .signature-pad {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            cursor: crosshair;
        }

        /* Custom Input & Card Main */
        .card {
            border-radius: 24px !important;
            border: none !important;
            box-shadow: 0 20px 45px -15px rgba(230, 0, 38, 0.12) !important;
        }

        .form-control {
            border-radius: 12px !important;
            padding: 0.65rem 1rem !important;
            border: 1px solid #E2E8F0 !important;
            background-color: #F8FAFC !important;
            color: #334155 !important;
            font-weight: 500;
        }

        .form-control:disabled {
            background-color: #F1F5F9 !important;
        }

        .btn-vibrant-red {
            background: linear-gradient(135deg, #FF3B5C 0%, #E60026 100%);
            color: #fff;
            border: none;
            font-weight: 700;
            border-radius: 12px;
            padding: 12px 24px;
            box-shadow: 0 10px 25px -5px rgba(230, 0, 38, 0.4);
            transition: all 0.3s ease;
        }

        .btn-vibrant-red:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px -5px rgba(230, 0, 38, 0.5);
            color: #fff;
        }

        .btn-outline-action {
            border-radius: 10px;
            font-weight: 600;
            padding: 6px 18px;
            transition: all 0.2s ease;
        }
    </style>
    <script src="{{ asset('asset/js/signature.js') }}"></script>
</head>


<body>

    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">
        <div class="container-fluid">
            <div class="row min-vh-100 flex-center g-0">
                <div class="col-lg-10 col-xxl-7 py-4 position-relative">

                    <!-- Latar Belakang Ornamen Lingkaran dengan Efek Bounce -->
                    <img class="bg-auth-circle-shape" src="../../../asset/img/icons/spot-illustrations/bg-shape.png" alt="" width="250">
                    <img class="bg-auth-circle-shape-2" src="../../../asset/img/icons/spot-illustrations/shape-1.png" alt="" width="150">

                    <div class="card overflow-hidden z-index-1">
                        <div class="card-body p-0">
                            <div class="row g-0 h-100">

                                <!-- Panel Kiri (Banner Gradasi Merah Modern & Elegan) -->
                                <div class="col-md-5 text-center bg-gradient-red-vibrant d-flex flex-column justify-content-between p-4 p-md-5">
                                    <!-- Background Elements -->
                                    <div class="glow-orb glow-orb-1"></div>
                                    <div class="glow-orb glow-orb-2"></div>
                                    <div class="bg-holder bg-auth-card-shape" style="background-image:url(../../../asset/img/icons/spot-illustrations/half-circle.png); opacity: 0.12;"></div>

                                    <div class="z-index-1 w-100 position-relative">
                                        <!-- Header Logos (Kiri: Logo Utama, Kanan: Logo Company) -->
                                        <div class="d-flex justify-content-between align-items-center w-100 mb-4">
                                            <div class="logo-box">
                                                <img src="{{ asset('img/pram.png') }}" alt="Logo Utama">
                                            </div>
                                            <div class="logo-box">
                                                @if (!empty($data->master_company_logo) && file_exists(public_path('uploads/company_logo/' . $data->master_company_logo)))
                                                <img src="{{ asset('uploads/company_logo/' . $data->master_company_logo) }}" alt="Logo {{ $data->master_company_name }}">
                                                @else
                                                <img src="{{ asset('img/company.png') }}" alt="Default Logo">
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Informasi Teks Kiri Mode Modern -->
                                        <div class="text-white text-start mt-4">
                                            <div class="badge-accent">
                                                <span class="fas fa-heartbeat"></span> MCU Management System
                                            </div>

                                            <h2 class="gradient-heading mb-3">Selamat Datang!</h2>

                                            <p class="opacity-90 fs--1 lh-lg mb-3 text-white-50">
                                                Peserta Medical Check Up. Mohon periksa kelengkapan nama dan data Anda sebelum menyetujui formulir ini.
                                            </p>

                                            <!-- Card Transparan / Glassmorphism -->
                                            <div class="glass-info-card">
                                                <div class="quote-border">
                                                    <p class="opacity-95 fs--1 lh-lg mb-0 text-white fw-light italic">
                                                        "Terima kasih atas kepercayaan yang telah diberikan kepada <strong class="fw-bold">Pramita</strong> untuk memenuhi kebutuhan pemeriksaan Medical Check Up (MCU). Kami berkomitmen memberikan pelayanan terbaik, menjaga kualitas pemeriksaan, serta pengalaman layanan yang optimal bagi seluruh peserta."
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="z-index-1 text-white-50 fs--2 text-start mt-4 pt-3 border-top border-white-10">
                                        &copy; {{ date('Y') }} MCU Management System. All rights reserved.
                                    </div>
                                </div>

                                <!-- Panel Kanan dengan Border Gradasi Merah -->
                                <div class="col-md-7 right-panel-gradient-border">
                                    <div class="right-panel-content d-flex align-items-center p-4 p-md-5">
                                        <div class="w-100">
                                            <div class="mb-4">
                                                <h4 class="fw-bold text-900 mb-1">Konfirmasi Kehadiran</h4>
                                                <p class="text-500 fs--1">Verifikasi identitas dan sertakan tanda tangan digital Anda.</p>
                                            </div>

                                            <form method="POST" action="{{ route('signaturepad.update') }}">
                                                @csrf
                                                <input type="text" name="token" value="{{ $data->log_kehadiran_pasien_token }}" hidden>

                                                <!-- Field Nama & NIP -->
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-semibold text-700 fs--1 mb-1" for="card-name">Nama Lengkap</label>
                                                        <input class="form-control" type="text" id="card-name" value="{{ $data->mou_peserta_name }}" disabled />
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-semibold text-700 fs--1 mb-1" for="card-email">Nomor Induk Pegawai</label>
                                                        <input class="form-control" type="text" id="card-email" value="{{ $data->mou_peserta_nip }}" disabled />
                                                    </div>

                                                    <!-- Divider Tanda Tangan -->
                                                    <div class="col-12 my-3">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-grow-1 border-bottom"></div>
                                                            <span class="px-3 text-400 fs--1 fw-bold tracking-wider">TANDA TANGAN</span>
                                                            <div class="flex-grow-1 border-bottom"></div>
                                                        </div>
                                                    </div>

                                                    <!-- Area Canvas Sign Simetris Tengah -->
                                                    <div class="col-12">
                                                        <div class="signature-container">
                                                            <div class="wrapper mb-2">
                                                                <canvas id="signature-pad" class="signature-pad"></canvas>
                                                            </div>

                                                            <!-- Tombol Action Simetris di Bawah Canvas -->
                                                            <div class="d-flex justify-content-center gap-2 mb-2">
                                                                <button class="btn btn-sm btn-outline-secondary btn-outline-action" type="button" id="clear">
                                                                    <span class="fas fa-undo me-1"></span> Reset
                                                                </button>
                                                                <button class="btn btn-sm btn-outline-primary btn-outline-action" type="button" id="save">
                                                                    <span class="fas fa-check me-1"></span> Lock Signature
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Agreement Checkbox -->
                                                    <div class="col-12 mt-3">
                                                        <div class="form-check d-flex align-items-center">
                                                            <input class="form-check-input mt-0" type="checkbox" id="card-register-checkbox" required />
                                                            <label class="form-label mb-0 ms-2 fs--1 text-600" for="card-register-checkbox">
                                                                Saya menyetujui <a href="#!" class="text-danger fw-semibold">syarat & ketentuan</a> yang berlaku.
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <textarea id="signature64" name="signed" hidden></textarea>
                                                    <input type="text" name="cabang" value="{{ $data->log_kehadiran_pasien_lokasi }}" hidden>
                                                    <input type="text" name="peserta" value="{{ $data->mou_peserta_code }}" hidden>

                                                    <!-- Submit Button -->
                                                    <div class="col-12 mt-4">
                                                        <button class="btn btn-vibrant-red w-100" id="button-submit-selesai" type="submit" name="submit" style="display: none;">
                                                            <span class="fas fa-paper-plane me-2"></span> Selesaikan Registrasi
                                                        </button>
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
    <script src="{{ asset('asset/js/theme.js') }}"></script>

    <script>
        // Adjust Canvas Size Responsively
        function resizeCanvas() {
            var canvas = document.getElementById('signature-pad');
            var ratio = Math.max(window.devicePixelRatio || 1, 1);
            canvas.width = canvas.offsetWidth * ratio;
            canvas.height = canvas.offsetHeight * ratio;
            canvas.getContext("2d").scale(ratio, ratio);
        }

        window.addEventListener("resize", resizeCanvas);

        var canvas = document.getElementById('signature-pad');
        var signaturePad = new SignaturePad(canvas, {
            backgroundColor: 'rgba(255, 255, 255, 0)',
            penColor: 'rgb(15, 23, 42)' // Soft dark color for clear ink
        });

        // Trigger initial resize
        resizeCanvas();

        var saveButton = document.getElementById('save');
        var cancelButton = document.getElementById('clear');

        saveButton.addEventListener('click', function(event) {
            if (signaturePad.isEmpty()) {
                alert("Silakan masukan tanda tangan terlebih dahulu.");
                return;
            }
            var data = signaturePad.toDataURL('image/png');
            $('#signature64').html(data);
            $("#button-submit-selesai").fadeIn();
            $("#save").addClass('btn-primary').removeClass('btn-outline-primary');
        });

        cancelButton.addEventListener('click', function(event) {
            signaturePad.clear();
            $('#signature64').html('');
            $("#button-submit-selesai").fadeOut();
            $("#save").removeClass('btn-primary').addClass('btn-outline-primary');
        });
    </script>

</body>

</html>
