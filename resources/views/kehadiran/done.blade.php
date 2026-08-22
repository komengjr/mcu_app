<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Pemeriksaan Selesai | Medical Check Up</title>

    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/dashboard.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/dashboard.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/dashboard.png') }}">
    <meta name="theme-color" content="#ffffff">
    <script src="{{ asset('asset/js/config.js') }}"></script>

    <!-- Fonts & Core Styles -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="{{ asset('asset/css/theme.min.css') }}" rel="stylesheet" id="style-default">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            background-color: #f8fafc;
        }

        /* Minimal Card Container */
        .card-minimal-success {
            border-radius: 24px !important;
            border: none !important;
            box-shadow: 0 20px 40px -15px rgba(230, 0, 38, 0.12) !important;
            background: #ffffff;
            position: relative;
            overflow: hidden;
        }

        .card-minimal-success::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, #FF3355 0%, #E60026 100%);
        }

        /* Logo Box */
        .logo-box {
            background: #ffffff;
            padding: 6px 16px;
            border-radius: 12px;
            box-shadow: 0 6px 15px -3px rgba(0, 0, 0, 0.06);
            border: 1px solid #F1F5F9;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .logo-box img {
            max-height: 38px;
            width: auto;
            object-fit: contain;
        }

        /* Minimal Success Pulse Icon */
        .icon-circle {
            width: 76px;
            height: 76px;
            background: linear-gradient(135deg, #FF3B5C 0%, #E60026 100%);
            color: #ffffff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.2rem;
            margin: 0 auto 1.25rem auto;
            box-shadow: 0 10px 25px -5px rgba(230, 0, 38, 0.35);
        }

        /* Timer Badge */
        .timer-badge {
            background-color: #FFF0F2;
            color: #900018;
            border: 1px solid rgba(230, 0, 38, 0.2);
            border-radius: 50px;
            padding: 6px 16px;
            font-size: 0.8rem;
            font-weight: 600;
            display: inline-block;
        }

        /* Action Button */
        .btn-vibrant-red {
            background: linear-gradient(135deg, #FF3B5C 0%, #E60026 100%);
            color: #fff;
            border: none;
            font-weight: 700;
            border-radius: 10px;
            padding: 8px 20px;
            box-shadow: 0 8px 20px -5px rgba(230, 0, 38, 0.3);
            transition: all 0.2s ease;
        }

        .btn-vibrant-red:hover {
            color: #fff;
            transform: translateY(-1px);
        }
    </style>
</head>

<body>

    <main class="main" id="top">
        <div class="container">
            <div class="row flex-center min-vh-100 py-4">
                <div class="col-sm-9 col-md-7 col-lg-5 col-xl-4 text-center">

                    <!-- Header Logo -->
                    <div class="d-flex justify-content-center align-items-center gap-2 mb-4">
                        <div class="logo-box">
                            <img src="{{ asset('img/pram.png') }}" alt="Logo Utama">
                        </div>
                        @if (!empty($data->master_company_logo) && file_exists(public_path('uploads/company_logo/' . $data->master_company_logo)))
                        <div class="logo-box">
                            <img src="{{ asset('uploads/company_logo/' . $data->master_company_logo) }}" alt="Logo Company">
                        </div>
                        @endif
                    </div>

                    <!-- Minimal Success Card -->
                    <div class="card card-minimal-success">
                        <div class="card-body p-4 p-sm-5">

                            <!-- Success Icon -->
                            <div class="icon-circle">
                                <span class="fas fa-check"></span>
                            </div>

                            <h3 class="fw-bold text-900 mb-2">Pemeriksaan Selesai!</h3>
                            <p class="text-600 fs--1 mb-4">
                                Data status pemeriksaan Anda telah berhasil diperbarui dan tersimpan.
                            </p>

                            <!-- Timer Alert -->
                            <div class="timer-badge mb-4">
                                Halaman menutup otomatis dalam <span id="countdown" class="fw-bold text-danger">3</span> detik
                            </div>

                            <!-- Close Button -->
                            <div>
                                <button onclick="window.location.href='https://www.google.com'" class="btn btn-vibrant-red w-100 fs--1">
                                    Tutup Halaman
                                </button>
                            </div>

                        </div>
                    </div>

                    <div class="text-400 fs--2 mt-3">
                        &copy; {{ date('Y') }} MCU Management System
                    </div>

                </div>
            </div>
        </div>
    </main>

    <!-- Essential Scripts -->
    <script src="{{ asset('vendors/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendors/fontawesome/all.min.js') }}"></script>

    <!-- Countdown Timer -->
    <script>
        let timeLeft = 3;
        const countdownElement = document.getElementById('countdown');

        const timer = setInterval(() => {
            timeLeft--;
            if (countdownElement) {
                countdownElement.textContent = timeLeft;
            }
            if (timeLeft <= 0) {
                clearInterval(timer);
                window.close();
            }
        }, 1000);
    </script>
</body>

</html>
