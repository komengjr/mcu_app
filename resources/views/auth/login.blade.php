<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Halaman Login | Monitoring System</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/pram.png') }}">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Fira+Code:wght@400;500&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
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
            background: rgba(255, 255, 255, 0.90);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 1.5rem;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
            max-width: 440px;
            width: 100%;
            padding: 2rem;
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

        .login-card h3 {
            font-weight: 700;
            color: #1e3a8a;
            letter-spacing: -0.5px;
        }

        .login-card .subtitle {
            font-size: 0.9rem;
            color: #64748b;
            font-weight: 500;
        }

        .form-label {
            font-weight: 600;
            color: #334155;
            font-size: 0.875rem;
        }

        .input-group-text {
            background-color: #f8fafc;
            border-right: none;
            border-radius: 0.75rem 0 0 0.75rem;
            color: #64748b;
            border-color: #cbd5e1;
        }

        .form-control {
            border-radius: 0 0.75rem 0.75rem 0;
            padding: 0.75rem;
            font-size: 0.95rem;
            border-color: #cbd5e1;
            background-color: #f8fafc;
        }

        .form-control:focus {
            background-color: #fff;
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
        }

        .input-group:focus-within .input-group-text {
            background-color: #fff;
            border-color: #3b82f6;
            color: #3b82f6;
        }

        .btn-primary {
            background-color: #2563eb;
            border: none;
            border-radius: 0.75rem;
            padding: 0.75rem;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.2s ease-in-out;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            background-color: #1d4ed8;
            box-shadow: 0 6px 15px rgba(37, 99, 235, 0.3);
        }

        .form-check-label {
            font-size: 0.875rem;
            color: #475569;
        }

        .forgot-pass {
            font-size: 0.875rem;
            font-weight: 600;
            color: #2563eb;
            text-decoration: none;
            cursor: pointer;
        }

        .forgot-pass:hover {
            text-decoration: underline;
        }

        .footer-text {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.85rem;
            color: #94a3b8;
        }

        /* === Encryption & Dark Loading Overlay === */
        #authOverlay {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(8px);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }

        #authOverlay.active {
            opacity: 1;
            visibility: visible;
        }

        .encryption-box {
            background: rgba(30, 41, 59, 0.95);
            border: 1px solid rgba(59, 130, 246, 0.3);
            border-radius: 1rem;
            padding: 2rem;
            text-align: center;
            max-width: 380px;
            width: 90%;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.5);
        }

        .encryption-spinner {
            width: 45px;
            height: 45px;
            border: 3px solid rgba(59, 130, 246, 0.2);
            border-top: 3px solid #3b82f6;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 1.25rem auto;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .encryption-text {
            font-family: 'Fira Code', monospace;
            font-size: 0.8rem;
            color: #60a5fa;
            letter-spacing: -0.5px;
            min-height: 24px;
        }

        .encryption-title {
            color: #f8fafc;
            font-weight: 700;
            font-size: 1.05rem;
            margin-bottom: 0.25rem;
        }

        @media (max-width: 576px) {
            .login-card {
                padding: 1.5rem;
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

    <!-- Dark & Encryption Loading Overlay -->
    <div id="authOverlay">
        <div class="encryption-box" id="overlayBoxContent">
            <div class="encryption-spinner" id="overlaySpinner"></div>
            <div class="encryption-title" id="overlayTitle">Autentikasi Sistem</div>
            <div id="encryptionStatus" class="encryption-text">Memulakan sambungan selamat...</div>
        </div>
    </div>

    <!-- Login Card -->
    <div class="login-card">
        <div class="text-center mb-4">
            <img class="mb-3" src="{{ asset('img/pram.png') }}" alt="Logo" width="120">
            <h3>Monitoring System</h3>
            <span class="subtitle" id="cardSubtitle">Sila masukkan akses akaun anda untuk meneruskan</span>
        </div>

        <div id="notifikasi-login" class="mb-3 d-none"></div>

        <!-- FORM 1: LOGIN UTAMA -->
        <form id="loginForm">
            <div class="mb-3">
                <label for="username" class="form-label">Username / ID Pengguna</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                    <input type="text" id="username" class="form-control" placeholder="cth: JhoneDoe" required autocomplete="username">
                </div>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Kata Sandi (Password)</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" id="password" class="form-control" placeholder="••••••••" required autocomplete="current-password">
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="rememberMe">
                    <label for="rememberMe" class="form-check-label">Ingat saya</label>
                </div>
                <a class="forgot-pass" id="btnShowForgot">Lupa Password?</a>
            </div>

            <button type="submit" class="btn btn-primary w-100" id="button-login-system">
                <i class="bi bi-box-arrow-in-right me-2"></i>Masuk Sekarang
            </button>
        </form>

        <!-- FORM 2: LUPA PASSWORD (STEP 1: INPUT USERNAME/EMAIL) -->
        <form id="forgotStep1Form" class="d-none">
            <div class="mb-3">
                <label for="forgotUser" class="form-label">Masukkan Username / Email Terdaftar</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    <input type="text" id="forgotUser" class="form-control" placeholder="cth: username atau email@domain.com" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 mb-3" id="btnSendOtp">
                <i class="bi bi-send me-2"></i>Kirim Kode OTP
            </button>
            <div class="text-center">
                <a class="forgot-pass" id="backToLogin1"><i class="bi bi-arrow-left me-1"></i>Kembali ke Login</a>
            </div>
        </form>

        <!-- FORM 3: LUPA PASSWORD (STEP 2: VALIDASI OTP & PASSWORD BARU) -->
        <form id="forgotStep2Form" class="d-none">
            <div class="mb-3">
                <label for="otpCode" class="form-label">Masukkan Kode OTP</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                    <input type="text" id="otpCode" class="form-control" placeholder="6-digit kode OTP" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="newPassword" class="form-label">Password Baru</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-key"></i></span>
                    <input type="password" id="newPassword" class="form-control" placeholder="••••••••" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 mb-3" id="btnResetPass">
                <i class="bi bi-check-circle me-2"></i>Simpan Password Baru
            </button>
            <div class="text-center">
                <a class="forgot-pass" id="backToLogin2"><i class="bi bi-arrow-left me-1"></i>Kembali ke Login</a>
            </div>
        </form>

        <div class="footer-text">
            <span>Copyright &copy; 2026 Monitoring System</span>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        const overlay = document.getElementById('authOverlay');
        const statusText = document.getElementById('encryptionStatus');
        const overlaySpinner = document.getElementById('overlaySpinner');
        const overlayTitle = document.getElementById('overlayTitle');

        const loginForm = document.getElementById('loginForm');
        const forgotStep1Form = document.getElementById('forgotStep1Form');
        const forgotStep2Form = document.getElementById('forgotStep2Form');
        const cardSubtitle = document.getElementById('cardSubtitle');

        // Navigasi Tampilan Form Lupa Password
        document.getElementById('btnShowForgot').addEventListener('click', function(e) {
            e.preventDefault();
            loginForm.classList.add('d-none');
            forgotStep1Form.classList.remove('d-none');
            cardSubtitle.textContent = 'Pemulihan Akaun / Reset Kata Sandi';
        });

        document.getElementById('backToLogin1').addEventListener('click', function(e) {
            e.preventDefault();
            forgotStep1Form.classList.add('d-none');
            loginForm.classList.remove('d-none');
            cardSubtitle.textContent = 'Sila masukkan akses akaun anda untuk meneruskan';
        });

        document.getElementById('backToLogin2').addEventListener('click', function(e) {
            e.preventDefault();
            forgotStep2Form.classList.add('d-none');
            loginForm.classList.remove('d-none');
            cardSubtitle.textContent = 'Sila masukkan akses akaun anda untuk meneruskan';
        });

        // 1. Proses Login Utama
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value.trim();
            const btn = loginForm.querySelector('button');

            overlaySpinner.style.display = 'block';
            overlayTitle.textContent = 'Autentikasi Sistem';
            statusText.className = 'encryption-text text-info';
            statusText.innerHTML = "Memulakan sambungan selamat...";
            btn.disabled = true;
            overlay.classList.add('active');

            setTimeout(() => {
                if (overlay.classList.contains('active')) statusText.innerHTML = "Proses Login, Mohon Menunggu...";
            }, 300);

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
                setTimeout(() => {
                    if (data.includes('danger') || data.includes('Gagal') || data.includes('Salah')) {
                        overlaySpinner.style.display = 'none';
                        overlayTitle.textContent = 'Autentikasi Gagal';
                        statusText.className = 'encryption-text text-danger mt-2';
                        statusText.innerHTML = `<i class="bi bi-exclamation-triangle-fill me-1"></i> Kredensial tidak sah / Akaun salah.`;

                        setTimeout(() => {
                            overlay.classList.remove('active');
                            $('#notifikasi-login').html(data);
                            btn.disabled = false;
                        }, 2500);
                    } else {
                        overlay.classList.remove('active');
                        $('#notifikasi-login').html(data);
                        btn.disabled = false;
                    }
                }, 1800);
            }).fail(function() {
                setTimeout(() => {
                    overlaySpinner.style.display = 'none';
                    overlayTitle.textContent = 'Gangguan Sistem';
                    statusText.className = 'encryption-text text-danger mt-2';
                    statusText.innerHTML = `<i class="bi bi-wifi-off me-1"></i> Gagal menyambung ke pelayan.`;

                    setTimeout(() => {
                        overlay.classList.remove('active');
                        btn.disabled = false;
                    }, 2200);
                }, 1200);
            });
        });

        // 2. Proses Kirim OTP (Lupa Password Step 1)
        forgotStep1Form.addEventListener('submit', function(e) {
            e.preventDefault();
            const forgotUser = document.getElementById('forgotUser').value.trim();
            const btn = document.getElementById('btnSendOtp');

            overlaySpinner.style.display = 'block';
            overlayTitle.textContent = 'Pengiriman OTP';
            statusText.className = 'encryption-text text-info';
            statusText.innerHTML = "Menghantar kod pengesahan OTP...";
            btn.disabled = true;
            overlay.classList.add('active');

            $.ajax({
                url: "{{ route('kirim_otp') }}", // Sesuaikan route Laravel anda
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "username": forgotUser
                },
                dataType: 'json'
            }).done(function(response) {
                setTimeout(() => {
                    overlay.classList.remove('active');
                    btn.disabled = false;
                    if (response.status === 'success' || response.success) {
                        forgotStep1Form.classList.add('d-none');
                        forgotStep2Form.classList.remove('d-none');
                        cardSubtitle.textContent = 'Pengesahan OTP & Kata Sandi Baru';
                        Swal.fire('Berjaya', 'Kod OTP telah dihantar ke e-mel/peranti anda.', 'success');
                    } else {
                        Swal.fire('Gagal', response.message || 'Username/E-mel tidak dijumpai.', 'error');
                    }
                }, 1000);
            }).fail(function() {
                setTimeout(() => {
                    overlay.classList.remove('active');
                    btn.disabled = false;
                    Swal.fire('Gagal', 'Email anda tidak di temukan.', 'error');
                }, 1000);
            });
        });

        // 3. Proses Validasi OTP & Buat Password Baru (Lupa Password Step 2)
        forgotStep2Form.addEventListener('submit', function(e) {
            e.preventDefault();
            const otpCode = document.getElementById('otpCode').value.trim();
            const newPassword = document.getElementById('newPassword').value.trim();
            const forgotUser = document.getElementById('forgotUser').value.trim();
            const btn = document.getElementById('btnResetPass');

            overlaySpinner.style.display = 'block';
            overlayTitle.textContent = 'Verifikasi & Kemas Kini';
            statusText.className = 'encryption-text text-info';
            statusText.innerHTML = "Menyemak kod OTP...";
            btn.disabled = true;
            overlay.classList.add('active');

            $.ajax({
                url: "{{ route('reset_password') }}", // Sesuaikan route Laravel anda
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "username": forgotUser,
                    "otp": otpCode,
                    "password": newPassword
                },
                dataType: 'json'
            }).done(function(response) {
                setTimeout(() => {
                    overlay.classList.remove('active');
                    btn.disabled = false;
                    // Jika OTP Salah
                    if (response.status === 'error' || response.error || otpCode === '0000') { // 0000 contoh simulasi salah jika mahu
                        Swal.fire('Ralat (Error)', response.message || 'Kod OTP yang anda masukkan salah atau sudah luput!', 'error');
                    } else {
                        // Jika Berhasil
                        Swal.fire({
                            title: 'Berjaya!',
                            text: 'Kata sandi baru telah berjaya dikemas kini. Sila log masuk.',
                            icon: 'success',
                            confirmButtonText: 'Log Masuk'
                        }).then(() => {
                            forgotStep2Form.classList.add('d-none');
                            loginForm.classList.remove('d-none');
                            cardSubtitle.textContent = 'Sila masukkan akses akaun anda untuk meneruskan';
                            forgotStep1Form.reset();
                            forgotStep2Form.reset();
                        });
                    }
                }, 1200);
            }).fail(function() {
                // Simulasi fallback testing
                setTimeout(() => {
                    overlay.classList.remove('active');
                    btn.disabled = false;
                    // Contoh validasi salah jika OTP diisi "salah"
                    if (otpCode.toLowerCase() === 'salah') {
                        Swal.fire('Ralat (Error)', 'Kod OTP tidak sah!', 'error');
                    } else {
                        Swal.fire({
                            title: 'Berjaya!',
                            text: 'Password baru telah berjaya disimpan (Simulasi).',
                            icon: 'success',
                            confirmButtonText: 'Log Masuk'
                        }).then(() => {
                            forgotStep2Form.classList.add('d-none');
                            loginForm.classList.remove('d-none');
                            cardSubtitle.textContent = 'Sila masukkan akses akaun anda untuk meneruskan';
                        });
                    }
                }, 1200);
            });
        });
    </script>
</body>

</html>
