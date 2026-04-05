<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login | Penilaian Supplier</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/header.png') }}">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #e8f1fc, #ffffff);
            overflow: hidden;
            position: relative;
        }

        /* === Animated Background === */
        .background-animation {
            position: absolute;
            inset: 0;
            overflow: hidden;
            z-index: 0;
        }

        .bg-shape {
            position: absolute;
            border-radius: 50%;
            opacity: 0.4;
            animation: float 12s ease-in-out infinite;
        }

        .bg-shape:nth-child(1) {
            width: 180px;
            height: 180px;
            background: #a0d3ff;
            top: 10%;
            left: 5%;
            animation-delay: 0s;
        }

        .bg-shape:nth-child(2) {
            width: 250px;
            height: 250px;
            background: #f5cba7;
            bottom: 5%;
            right: 8%;
            animation-delay: 3s;
        }

        .bg-shape:nth-child(3) {
            width: 220px;
            height: 220px;
            background: #c8e6c9;
            top: 40%;
            left: 70%;
            animation-delay: 5s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0) scale(1);
            }

            50% {
                transform: translateY(-20px) scale(1.05);
            }
        }

        /* === Background Illustration === */
        .background-illustration {
            position: absolute;
            inset: 0;
            z-index: 1;
            background: url('https://pustaka.bca.co.id/Promo/A2C31A68-BC10-4CBD-AB51-85474A36CC50/Detail/ImageListing/20250723_PRAMITA-LAB-SBY-thumb.jpeg') center/cover no-repeat;
            opacity: 0.15;
            filter: blur(1px);
        }

        /* === Login Card === */
        .login-card {
            position: relative;
            z-index: 2;
            background: rgba(243, 243, 243, 0.85);
            backdrop-filter: blur(12px);
            border-radius: 1.5rem;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            max-width: 450px;
            width: 100%;
            padding: 1.5rem 1.5rem;
            margin: 1rem;
            animation: fadeInUp 1s ease forwards;
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(30px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-card h2 {
            font-weight: 600;
            color: #316bb3;
            text-align: center;
            margin-bottom: 0.5rem;
        }

        .login-card p {
            text-align: center;
            font-size: 0.95rem;
            color: #555;
            margin-bottom: 2rem;
        }

        .form-control {
            border-radius: 0.75rem;
            padding: 0.75rem;
            border-color: #d0d9e2;
        }

        .form-control:focus {
            border-color: #90caf9;
            box-shadow: 0 0 0 0.25rem rgba(144, 202, 249, 0.25);
        }

        .btn-primary {
            background-color: #5a9bd5;
            border: none;
            border-radius: 0.75rem;
            padding: 0.75rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: scale(1.03);
            background-color: #4689c4;
        }

        .footer-text {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.9rem;
            color: #666;
        }

        .footer-text a {
            color: #316bb3;
            text-decoration: none;
        }

        .footer-text a:hover {
            text-decoration: underline;
        }

        @media (max-width: 576px) {
            .login-card {
                padding: 2rem 1.5rem;
            }
        }
    </style>
</head>

<body>
    <!-- Animated background shapes -->
    <div class="background-animation">
        <div class="bg-shape"></div>
        <div class="bg-shape"></div>
        <div class="bg-shape"></div>
    </div>

    <!-- Illustration background -->
    <div class="background-illustration"></div>

    <!-- Login Card -->
    <div class="login-card">
        <div class="text-center mb-4">
            <img class="mb-2" src="{{ asset('img/pram.png') }}" alt="" width="150">
            <h3><strong>Monitoring System</strong></h3>
            <p style="margin-bottom: 0;"> <small>Halaman Login</small></p>
        </div>
        <span id="notifikasi-login" class="pb-0 mt-0"></span>
        <form id="loginForm">
            <div class="mb-3">
                <label for="username" class="form-label fw-semibold">Username</label>
                <input type="text" id="username" class="form-control" placeholder="Masukkan username Anda" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label fw-semibold">Kata Sandi</label>
                <input type="password" id="password" class="form-control" placeholder="Masukkan kata sandi" required>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="rememberMe">
                    <label for="rememberMe" class="form-check-label">Ingat saya</label>
                </div>
                <a href="#" class="text-decoration-none text-primary">Lupa Password?</a>
            </div>

            <button type="submit" class="btn btn-primary w-100" id="button-login-system">
                <i class="bi bi-box-arrow-in-right me-2"></i>Masuk Sekarang
            </button>
        </form>

        <div class="footer-text">
            <strong>Copyright © 2026</strong>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        const form = document.getElementById('loginForm');
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value.trim();
            const btn = form.querySelector('button');

            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Memeriksa...';
            btn.disabled = true;
            $.ajax({
                url: "{{ route('verifikasi_Login') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "username": username,
                    "password": password
                },
                dataType: 'html',
            }).done(function(data) {
                $('#notifikasi-login').html(data);
                btn.innerHTML = '<i class="bi bi-box-arrow-in-right me-2"></i>Masuk Sekarang';
                btn.disabled = false;
            }).fail(function() {
                console.log('error');
            });
        });
    </script>
</body>

</html>
