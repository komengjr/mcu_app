<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Medical Check Up | Management System</title>

    <!-- Favicons & Stylesheets -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/dashboard.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/dashboard.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/dashboard.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/dashboard.png') }}">
    <link rel="manifest" href="{{ asset('asset/img/favicons/manifest.json') }}">
    <meta name="msapplication-TileImage" content="{{ asset('img/dashboard.png') }}">
    <meta name="theme-color" content="#ffffff">
    <script src="{{ asset('asset/js/config.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('asset/notifications/css/lobibox.min.css') }}" />

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
    <link href="{{ asset('vendors/overlayscrollbars/OverlayScrollbars.min.css') }}" rel="stylesheet">
    <link href="{{ asset('asset/css/theme-rtl.min.css') }}" rel="stylesheet" id="style-rtl">
    <link href="{{ asset('asset/css/theme.min.css') }}" rel="stylesheet" id="style-default">
    <link href="{{ asset('asset/css/user-rtl.min.css') }}" rel="stylesheet" id="user-style-rtl">
    <link href="{{ asset('asset/css/user.min.css') }}" rel="stylesheet" id="user-style-default">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

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

        @keyframes bounceFloat {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-12px);
            }
        }

        .bg-auth-circle-shape {
            animation: bounceFloat 6s ease-in-out infinite;
        }

        .bg-auth-circle-shape-2 {
            animation: bounceFloat 8s ease-in-out infinite reverse;
        }

        .bg-gradient-red-vibrant {
            background: linear-gradient(155deg, #FF3355 0%, #C80022 55%, #7A0010 100%) !important;
            position: relative;
            overflow: hidden;
        }

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

        .logo-box {
            background: rgba(255, 255, 255, 0.95);
            padding: 8px 18px;
            border-radius: 14px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-box img {
            max-height: 38px;
            width: auto;
            object-fit: contain;
        }

        .glass-info-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 18px;
            padding: 1.25rem;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        }

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

        .gradient-heading {
            background: linear-gradient(180deg, #FFFFFF 0%, #FFE0E6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        .right-panel-gradient-border {
            position: relative;
            background: #ffffff;
            border-radius: 0 24px 24px 0;
            padding: 2px;
            background-image: linear-gradient(135deg, #FF3355 0%, #E60026 50%, rgba(200, 0, 34, 0.2) 100%);
        }

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

        .card {
            border-radius: 24px !important;
            border: none !important;
            box-shadow: 0 20px 45px -15px rgba(230, 0, 38, 0.12) !important;
        }

        .form-control {
            border-radius: 10px !important;
            padding: 0.55rem 0.85rem !important;
            border: 1px solid #E2E8F0 !important;
            background-color: #F8FAFC !important;
            color: #334155 !important;
            font-weight: 500;
            font-size: 0.85rem;
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

        .table-custom-mcu {
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #E2E8F0;
        }

        .table-custom-mcu thead {
            background-color: #FFF0F2 !important;
            color: #900018 !important;
            font-weight: 700;
        }

        .table-custom-mcu th,
        .table-custom-mcu td {
            vertical-align: middle;
            padding: 0.75rem;
        }

        .form-check-input:checked {
            background-color: #E60026;
            border-color: #E60026;
        }

        /* Styling Custom Swal */
        .swal2-styled.swal2-confirm {
            background-color: #E60026 !important;
            border-radius: 8px !important;
        }
    </style>
</head>

<body>
    <main class="main" id="top">
        <div class="container-fluid">
            <div class="row min-vh-100 flex-center g-0">
                <div class="col-lg-10 col-xxl-8 py-4 position-relative">

                    <img class="bg-auth-circle-shape" src="../../../asset/img/icons/spot-illustrations/bg-shape.png" alt="" width="250">
                    <img class="bg-auth-circle-shape-2" src="../../../asset/img/icons/spot-illustrations/shape-1.png" alt="" width="150">

                    <div class="card overflow-hidden z-index-1">
                        <div class="card-body p-0">
                            <div class="row g-0 h-100">

                                <!-- Panel Kiri -->
                                <div class="col-md-5 text-center bg-gradient-red-vibrant d-flex flex-column justify-content-between p-4 p-md-5">
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

                                <!-- Panel Kanan -->
                                <div class="col-md-7 right-panel-gradient-border">
                                    <div class="right-panel-content d-flex align-items-center p-4 p-md-5">
                                        <div class="w-100">
                                            <div class="mb-3">
                                                <h4 class="fw-bold text-900 mb-1">Status Pemeriksaan</h4>
                                                <p class="text-500 fs--1">Periksa identitas dan perbarui status tindakan pemeriksaan Anda.</p>
                                            </div>

                                            <form method="POST" action="{{ route('signaturepad.update_pemeriksaan_save') }}">
                                                @csrf
                                                <input type="text" name="token" value="{{ $data->log_kehadiran_pasien_token }}" hidden>
                                                <input type="text" name="jumlah" id="jumlah" value="{{ $jumlah }}" hidden>

                                                <div class="row g-2">
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-semibold text-700 fs--1 mb-1" for="card-name">Nama Lengkap</label>
                                                        <input class="form-control" type="text" id="card-name" value="{{ $data->mou_peserta_name }}" disabled />
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-semibold text-700 fs--1 mb-1" for="card-email">Nomor Induk Pegawai</label>
                                                        <input class="form-control" type="text" id="card-email" value="{{ $data->mou_peserta_nip }}" disabled />
                                                    </div>
                                                    <!-- <div class="col-md-6">
                                                        <label class="form-label fw-semibold text-700 fs--1 mb-1">Nomor Whatsapp</label>
                                                        <input class="form-control" type="text" value="{{ $data->mou_peserta_no_hp }}" disabled />
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-semibold text-700 fs--1 mb-1">Email</label>
                                                        <input class="form-control" type="text" value="{{ $data->mou_peserta_email }}" disabled />
                                                    </div> -->

                                                    <div class="col-12 my-3">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-grow-1 border-bottom"></div>
                                                            <span class="px-3 text-400 fs--2 fw-bold tracking-wider text-uppercase">Daftar Status Pemeriksaan</span>
                                                            <div class="flex-grow-1 border-bottom"></div>
                                                        </div>
                                                    </div>

                                                    <!-- Tabel Pemeriksaan -->
                                                    <div class="col-12">
                                                        <div class="table-responsive scrollbar table-custom-mcu">
                                                            <table class="table table-bordered table-striped fs--1 mb-0">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Nama Pemeriksaan</th>
                                                                        <th class="text-center" width="60">Yes</th>
                                                                        <th class="text-center" width="60">No</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php $hitung = 0; ?>
                                                                    @foreach ($pemeriksaan as $pem)
                                                                    <?php
                                                                    $ket = Illuminate\Support\Facades\DB::table('log_pemeriksaan_pasien')
                                                                        ->where('mou_peserta_code', $data->mou_peserta_code)
                                                                        ->where('master_pemeriksaan_code', $pem->master_pemeriksaan_code)
                                                                        ->first();

                                                                    $cek = Illuminate\Support\Facades\DB::table('log_pemeriksaan_pasien')
                                                                        ->where('mou_peserta_code', $data->mou_peserta_code)
                                                                        ->where('master_pemeriksaan_code', $pem->master_pemeriksaan_code)
                                                                        ->where('log_pemeriksaan_status', 1)
                                                                        ->first();

                                                                    $cek1 = Illuminate\Support\Facades\DB::table('log_pemeriksaan_pasien')
                                                                        ->where('mou_peserta_code', $data->mou_peserta_code)
                                                                        ->where('master_pemeriksaan_code', $pem->master_pemeriksaan_code)
                                                                        ->where('log_pemeriksaan_status', 0)
                                                                        ->first();
                                                                    ?>
                                                                    <tr>
                                                                        <td class="fw-semibold text-800">
                                                                            {{ $pem->master_pemeriksaan_name }}
                                                                            <small class="d-block text-muted fw-normal" id="label_ket_{{ $pem->master_pemeriksaan_code }}">
                                                                                {{ $cek1 && $ket ? 'Keterangan: ' . $ket->log_pemeriksaan_deskripsi : '' }}
                                                                            </small>
                                                                        </td>
                                                                        <td class="text-center align-middle">
                                                                            <div class="form-check d-flex justify-content-center m-0">
                                                                                <input class="form-check-input" id="pem_yes_{{ $pem->master_pemeriksaan_code }}" type="radio" name="pem{{ $pem->master_pemeriksaan_code }}" onclick="MyFunction('{{ $pem->master_pemeriksaan_code }}','{{ $data->mou_peserta_code }}', 'on', '{{ $pem->master_pemeriksaan_name }}')" {{ $cek ? 'checked' : '' }} />
                                                                            </div>
                                                                            <?php if ($cek) $hitung++; ?>
                                                                        </td>
                                                                        <td class="text-center align-middle">
                                                                            <div class="form-check d-flex justify-content-center m-0">
                                                                                <input class="form-check-input" id="pem_no_{{ $pem->master_pemeriksaan_code }}" type="radio" name="pem{{ $pem->master_pemeriksaan_code }}" onclick="MyFunction('{{ $pem->master_pemeriksaan_code }}','{{ $data->mou_peserta_code }}', 'off', '{{ $pem->master_pemeriksaan_name }}')" {{ $cek1 ? 'checked' : '' }} />
                                                                            </div>
                                                                            <?php if ($cek1) $hitung++; ?>
                                                                        </td>
                                                                    </tr>
                                                                    @endforeach

                                                                    <!-- PEMERIKSAAN ADDITIONAL -->
                                                                    @foreach ($pemeriksaan1 as $pem)
                                                                    <?php
                                                                    $ket = Illuminate\Support\Facades\DB::table('log_pemeriksaan_pasien')
                                                                        ->where('mou_peserta_code', $data->mou_peserta_code)
                                                                        ->where('master_pemeriksaan_code', $pem->master_pemeriksaan_code)
                                                                        ->first();

                                                                    $cek = Illuminate\Support\Facades\DB::table('log_pemeriksaan_pasien')
                                                                        ->where('mou_peserta_code', $data->mou_peserta_code)
                                                                        ->where('master_pemeriksaan_code', $pem->master_pemeriksaan_code)
                                                                        ->where('log_pemeriksaan_status', 1)
                                                                        ->first();

                                                                    $cek1 = Illuminate\Support\Facades\DB::table('log_pemeriksaan_pasien')
                                                                        ->where('mou_peserta_code', $data->mou_peserta_code)
                                                                        ->where('master_pemeriksaan_code', $pem->master_pemeriksaan_code)
                                                                        ->where('log_pemeriksaan_status', 0)
                                                                        ->first();
                                                                    ?>
                                                                    <tr>
                                                                        <td class="fw-semibold text-danger">
                                                                            {{ $pem->master_pemeriksaan_name }} <span class="badge bg-danger-subtle text-danger ms-1">Additional</span>
                                                                            <small class="d-block text-muted fw-normal" id="label_ket_{{ $pem->master_pemeriksaan_code }}">
                                                                                {{ $cek1 && $ket ? 'Keterangan: ' . $ket->log_pemeriksaan_deskripsi : '' }}
                                                                            </small>
                                                                        </td>
                                                                        <td class="text-center align-middle">
                                                                            <div class="form-check d-flex justify-content-center m-0">
                                                                                <input class="form-check-input" id="pem_yes_{{ $pem->master_pemeriksaan_code }}" type="radio" name="pem{{ $pem->master_pemeriksaan_code }}" onclick="MyFunction('{{ $pem->master_pemeriksaan_code }}','{{ $data->mou_peserta_code }}', 'on', '{{ $pem->master_pemeriksaan_name }}')" {{ $cek ? 'checked' : '' }} />
                                                                            </div>
                                                                            <?php if ($cek) $hitung++; ?>
                                                                        </td>
                                                                        <td class="text-center align-middle">
                                                                            <div class="form-check d-flex justify-content-center m-0">
                                                                                <input class="form-check-input" id="pem_no_{{ $pem->master_pemeriksaan_code }}" type="radio" name="pem{{ $pem->master_pemeriksaan_code }}" onclick="MyFunction('{{ $pem->master_pemeriksaan_code }}','{{ $data->mou_peserta_code }}', 'off', '{{ $pem->master_pemeriksaan_name }}')" {{ $cek1 ? 'checked' : '' }} />
                                                                            </div>
                                                                            <?php if ($cek1) $hitung++; ?>
                                                                        </td>
                                                                    </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>

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

                                                    <div class="col-md-12 mt-3">
                                                        <button class="btn btn-vibrant-red w-100" id="button-submit-selesai" type="submit" name="submit" style="{{ $hitung == $jumlah ? '' : 'display: none;' }}">
                                                            <span class="fas fa-save me-2"></span> Simpan Data
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

    <!-- JavaScripts -->
    <script src="{{ asset('vendors/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendors/anchorjs/anchor.min.js') }}"></script>
    <script src="{{ asset('vendors/is/is.min.js') }}"></script>
    <script src="{{ asset('vendors/fontawesome/all.min.js') }}"></script>
    <script src="{{ asset('vendors/lodash/lodash.min.js') }}"></script>
    <script src="{{ asset('asset/js/theme.js') }}"></script>
    <script src="{{ asset('asset/notifications/js/notifications.min.js') }}"></script>

    <script>
        function MyFunction(id, userCode, pilihan, namaPemeriksaan) {
            var total = $('#jumlah').val();

            if (pilihan === 'off') {
                // Munculkan Pop-up SweetAlert2 Input Deskripsi saat Klik "No"
                Swal.fire({
                    title: 'Alasan Tidak Diperiksa',
                    text: 'Tuliskan deskripsi/alasan tidak melakukan ' + namaPemeriksaan,
                    input: 'textarea',
                    inputPlaceholder: 'Tuliskan alasan di sini...',
                    inputAttributes: {
                        'aria-label': 'Tuliskan alasan di sini'
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Simpan',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#E60026',
                    cancelButtonColor: '#6c757d',
                    inputValidator: (value) => {
                        if (!value || !value.trim()) {
                            return 'Anda harus mengisi deskripsi/alasan!';
                        }
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        var ket = result.value;
                        sendDataAjax(id, userCode, pilihan, ket, total);
                        $('#label_ket_' + id).text('Keterangan: ' + ket);
                    } else {
                        // Jika batal, uncheck radio button No / Reset Pilihan
                        $('#pem_no_' + id).prop('checked', false);
                    }
                });
            } else {
                // Jika pilih "Yes"
                $('#label_ket_' + id).text('');
                sendDataAjax(id, userCode, pilihan, '', total);
            }
        }

        // Helper AJAX Request
        function sendDataAjax(id, userCode, pilihan, ket, total) {
            $.ajax({
                url: "{{ route('signaturepad.update_pemeriksaan') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": id,
                    "user": userCode,
                    "option": pilihan,
                    "ket": ket,
                },
                dataType: 'html',
            }).done(function(data) {
                Lobibox.notify('success', {
                    pauseDelayOnHover: true,
                    continueDelayOnInactiveTab: true,
                    position: 'top right',
                    icon: 'fas fa-check-circle',
                    msg: 'Status berhasil diperbarui'
                });

                if (parseInt(data) == parseInt(total)) {
                    $("#button-submit-selesai").fadeIn();
                } else {
                    $("#button-submit-selesai").fadeOut();
                }
            }).fail(function() {
                Lobibox.notify('error', {
                    pauseDelayOnHover: true,
                    continueDelayOnInactiveTab: true,
                    position: 'top right',
                    icon: 'fas fa-times-circle',
                    msg: 'Gagal memperbarui data'
                });
            });
        }
    </script>
</body>

</html>
