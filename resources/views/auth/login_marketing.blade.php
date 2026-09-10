<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Halaman Login | Marketing System</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/pram.png') }}">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts (Plus Jakarta Sans) -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #6366f1 0%, #a855f7 50%, #ec4899 100%);
            --btn-gradient: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            --btn-hover: linear-gradient(135deg, #4338ca 0%, #6d28d9 100%);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #0f172a;
            position: relative;
            overflow-x: hidden;
        }

        /* === Dynamic Gradient Animated Background === */
        .background-animation {
            position: fixed;
            inset: 0;
            z-index: 0;
            overflow: hidden;
            background: radial-gradient(circle at 50% 50%, #1e1b4b 0%, #0f172a 100%);
        }

        .bg-shape {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.6;
            animation: floatShape 20s infinite alternate ease-in-out;
        }

        .bg-shape:nth-child(1) {
            width: 380px;
            height: 380px;
            background: #6366f1;
            top: -10%;
            left: -10%;
        }

        .bg-shape:nth-child(2) {
            width: 450px;
            height: 450px;
            background: #ec4899;
            bottom: -15%;
            right: -10%;
            animation-delay: -5s;
        }

        .bg-shape:nth-child(3) {
            width: 320px;
            height: 320px;
            background: #3b82f6;
            top: 40%;
            left: 60%;
            animation-delay: -10s;
        }

        .bg-shape:nth-child(4) {
            width: 280px;
            height: 280px;
            background: #f59e0b;
            bottom: 20%;
            left: 10%;
            animation-delay: -15s;
        }

        @keyframes floatShape {
            0% {
                transform: translate(0, 0) scale(1);
            }

            50% {
                transform: translate(60px, 40px) scale(1.1);
            }

            100% {
                transform: translate(-40px, 80px) scale(0.9);
            }
        }

        /* === Glassmorphism Login Card === */
        .login-card {
            position: relative;
            z-index: 2;
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 2rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35);
            max-width: 440px;
            width: 90%;
            padding: 2.5rem 2rem;
            margin: 1.5rem auto;
            animation: cardAppear 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes cardAppear {
            0% {
                opacity: 0;
                transform: translateY(40px) scale(0.95);
            }

            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* === Header & Logo === */
        .brand-logo-wrapper {
            background: linear-gradient(135deg, #e0e7ff 0%, #fae8ff 100%);
            width: 90px;
            height: 90px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.25rem;
            box-shadow: 0 8px 20px rgba(99, 102, 241, 0.15);
            border: 3px solid #ffffff;
        }

        .brand-title {
            font-weight: 800;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-size: 1.65rem;
            letter-spacing: -0.5px;
        }

        .brand-subtitle {
            color: #64748b;
            font-size: 0.875rem;
            font-weight: 500;
        }

        /* === Form Inputs === */
        .form-label {
            color: #334155;
            font-size: 0.875rem;
            margin-bottom: 0.4rem;
        }

        .input-group-custom {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-group-custom .input-icon {
            position: absolute;
            left: 1rem;
            color: #94a3b8;
            font-size: 1.1rem;
            z-index: 4;
            transition: color 0.3s ease;
        }

        .form-control {
            border-radius: 1rem;
            padding: 0.75rem 1rem 0.75rem 2.8rem;
            border: 2px solid #e2e8f0;
            background-color: #f8fafc;
            font-size: 0.925rem;
            font-weight: 500;
            color: #1e293b;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background-color: #ffffff;
            border-color: #818cf8;
            box-shadow: 0 0 0 4px rgba(129, 140, 248, 0.15);
        }

        .form-control:focus+.input-icon,
        .input-group-custom:focus-within .input-icon {
            color: #4f46e5;
        }

        .password-toggle {
            position: absolute;
            right: 1rem;
            cursor: pointer;
            color: #94a3b8;
            z-index: 4;
            transition: color 0.2s;
        }

        .password-toggle:hover {
            color: #475569;
        }

        /* === Checkbox & Links === */
        .form-check-input {
            width: 1.1em;
            height: 1.1em;
            border-radius: 0.35em;
            border: 2px solid #cbd5e1;
            cursor: pointer;
        }

        .form-check-input:checked {
            background-color: #6366f1;
            border-color: #6366f1;
        }

        .form-check-label {
            color: #475569;
            font-size: 0.85rem;
            cursor: pointer;
            user-select: none;
        }

        .forgot-link {
            font-size: 0.85rem;
            color: #6366f1;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s;
        }

        .forgot-link:hover {
            color: #4338ca;
            text-decoration: underline;
        }

        /* === Colorful Button === */
        .btn-gradient {
            background: var(--btn-gradient);
            border: none;
            border-radius: 1rem;
            padding: 0.85rem;
            font-weight: 700;
            color: #ffffff;
            letter-spacing: 0.3px;
            box-shadow: 0 10px 20px -5px rgba(79, 70, 229, 0.4);
            transition: all 0.3s ease;
        }

        .btn-gradient:hover {
            background: var(--btn-hover);
            transform: translateY(-2px);
            box-shadow: 0 15px 25px -5px rgba(79, 70, 229, 0.5);
            color: #ffffff;
        }

        .btn-gradient:active {
            transform: translateY(0);
        }

        /* === Footer === */
        .footer-text {
            text-align: center;
            margin-top: 1.75rem;
            font-size: 0.8rem;
            color: #94a3b8;
            font-weight: 500;
        }

        @media (max-width: 576px) {
            .login-card {
                padding: 2rem 1.5rem;
                border-radius: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <!-- Animated colorful background shapes -->
    <div class="background-animation">
        <div class="bg-shape"></div>
        <div class="bg-shape"></div>
        <div class="bg-shape"></div>
        <div class="bg-shape"></div>
    </div>

    <!-- Login Card -->
    <div class="login-card">
        <div class="text-center mb-4">
            <div class="brand-logo-wrapper">
                <img src="{{ asset('img/pram.png') }}" alt="Logo" width="55" class="img-fluid">
            </div>
            <h3 class="brand-title mb-1">Marketing System</h3>
            <p class="brand-subtitle mb-0">Selamat datang kembali! Silakan masuk ke akun Anda.</p>
        </div>

        <span id="notifikasi-login" class="pb-0 mt-0"></span>

        <form id="loginForm">
            <div class="mb-3">
                <label for="username" class="form-label fw-semibold">Username</label>
                <div class="input-group-custom">
                    <i class="bi bi-person input-icon"></i>
                    <input type="text" id="username" class="form-control" placeholder="Masukkan username Anda" required autocomplete="username">
                </div>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label fw-semibold">Kata Sandi</label>
                <div class="input-group-custom">
                    <i class="bi bi-lock input-icon"></i>
                    <input type="password" id="password" class="form-control" placeholder="Masukkan kata sandi" required autocomplete="current-password">
                    <i class="bi bi-eye password-toggle" id="togglePassword"></i>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4 mt-2">
                <div class="form-check d-flex align-items-center gap-2">
                    <input type="checkbox" class="form-check-input mt-0" id="rememberMe">
                    <label for="rememberMe" class="form-check-label">Ingat saya</label>
                </div>
                <a href="#" class="forgot-link">Lupa Password?</a>
            </div>

            <button type="submit" class="btn btn-gradient w-100" id="button-login-system">
                <i class="bi bi-box-arrow-in-right me-2"></i>Masuk Sekarang
            </button>
        </form>

        <div class="footer-text">
            <strong>Copyright © 2026</strong> Marketing Platform. All rights reserved.
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Toggle visibility password
        const togglePassword = document.querySelector('#togglePassword');
        const passwordInput = document.querySelector('#password');

        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.classList.toggle('bi-eye');
            this.classList.toggle('bi-eye-slash');
        });

        // AJAX Form Submission
        const form = document.getElementById('loginForm');
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value.trim();
            const btn = document.getElementById('button-login-system');

            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Memeriksa...';
            btn.disabled = true;

            $.ajax({
                url: "{{ route('verifikasi_masrketing_login') }}",
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
                btn.innerHTML = '<i class="bi bi-box-arrow-in-right me-2"></i>Masuk Sekarang';
                btn.disabled = false;
            });
        });
    </script>
</body>

</html>
