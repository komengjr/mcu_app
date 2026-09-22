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

        .form-check-input:checked {
            background-color: #E60026;
            border-color: #E60026;
        }

        .mcu-form-item {
            background-color: #f8fafc;
            border: 1px dashed #cbd5e1;
            border-radius: 10px;
            padding: 10px 14px;
            transition: all 0.2s ease-in-out;
        }

        .mcu-form-item:hover {
            background-color: #fff0f2;
            border-color: #ff3355;
        }

        .mcu-form-item.is-completed {
            background-color: #f0fdf4 !important;
            border: 1px solid #86efac !important;
        }

        /* Timeline Styles */
        .mcu-timeline-container {
            position: relative;
            padding-left: 1.75rem;
            margin: 0.5rem 0;
        }

        .mcu-timeline-container::before {
            content: '';
            position: absolute;
            left: 0.75rem;
            top: 0.5rem;
            bottom: 0.5rem;
            width: 3px;
            background: #E2E8F0;
            border-radius: 3px;
        }

        .mcu-timeline-item {
            position: relative;
            margin-bottom: 1rem;
            background: #ffffff;
            border: 1px solid #E2E8F0;
            border-radius: 14px;
            padding: 1rem;
            transition: all 0.3s ease;
        }

        .mcu-timeline-item:hover {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
            border-color: #cbd5e1;
        }

        .mcu-timeline-item.item-completed {
            background-color: #f0fdf4;
            border-color: #86efac;
        }

        .mcu-timeline-item.item-active {
            background-color: #fffbeb;
            border-color: #fde047;
            box-shadow: 0 0 0 3px rgba(234, 179, 8, 0.15);
        }

        .mcu-timeline-dot {
            position: absolute;
            left: -2.05rem;
            top: 1.15rem;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: #cbd5e1;
            border: 3px solid #ffffff;
            box-shadow: 0 0 0 2px #cbd5e1;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            color: #fff;
        }

        .mcu-timeline-item.item-completed .mcu-timeline-dot {
            background: #22c55e;
            box-shadow: 0 0 0 2px #22c55e;
        }

        .mcu-timeline-item.item-active .mcu-timeline-dot {
            background: #eab308;
            box-shadow: 0 0 0 2px #eab308;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(234, 179, 8, 0.4);
            }

            70% {
                box-shadow: 0 0 0 8px rgba(234, 179, 8, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(234, 179, 8, 0);
            }
        }

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

                                        <div class="text-white text-start mt-4">
                                            <div class="badge-accent">
                                                <span class="fas fa-heartbeat"></span> MCU Management System
                                            </div>

                                            <h2 class="gradient-heading mb-3">Selamat Datang!</h2>

                                            <p class="opacity-90 fs--1 lh-lg mb-3 text-white-50">
                                                Peserta Medical Check Up. Mohon periksa kelengkapan nama dan ikuti alur timeline pemeriksaan Anda.
                                            </p>

                                            <div class="glass-info-card">
                                                <div class="quote-border">
                                                    <p class="opacity-95 fs--1 lh-lg mb-0 text-white fw-light italic">
                                                        "Terima kasih atas kepercayaan yang telah diberikan kepada <strong class="fw-bold">Pramita</strong> untuk memenuhi kebutuhan pemeriksaan Medical Check Up (MCU). Kami berkomitmen memberikan pelayanan terbaik, menjaga kualitas pemeriksaan, serta pengalaman layanan yang optimal bagi seluruh peserta."
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="z-index-1 text-white-50 fs--2 text-white mt-4 pt-3 border-top border-white-10">
                                        &copy; {{ date('Y') }} MCU Management System. All rights reserved.
                                    </div>
                                </div>

                                <!-- Panel Kanan -->
                                <div class="col-md-7 right-panel-gradient-border">
                                    <div class="right-panel-content d-flex align-items-center p-4 p-md-5">
                                        <div class="w-100">
                                            <?php
                                            if (!isset($noAntrian)) {
                                                $getAntrian = Illuminate\Support\Facades\DB::table('log_antrian_peserta')
                                                    ->where('mou_peserta_code', $data->mou_peserta_code)
                                                    ->first();
                                                $noAntrian = $getAntrian->nomor_antrian ?? $getAntrian->log_antrian_peserta_nomor ?? $getAntrian->no_antrian ?? '-';
                                            }
                                            ?>

                                            <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3 mb-4 pb-3 border-bottom">
                                                <div>
                                                    <h4 class="fw-bold text-900 mb-1">Timeline & Status Peserta MCU</h4>
                                                    <p class="text-500 fs--1 mb-0">Ikuti tahapan pemeriksaan di bawah secara berurutan sesuai alur pos.</p>
                                                </div>

                                                <div class="d-flex align-items-center justify-content-between justify-content-md-end border border-danger border-dashed px-3 py-2 rounded-3 text-nowrap w-100 w-md-auto"
                                                    style="background-color: #FFFDF7; border-color: #FFB3C1 !important;">
                                                    <i class="fas fa-ticket-alt text-danger me-3" style="font-size: 1.5rem;"></i>
                                                    <div class="d-flex flex-column align-items-end">
                                                        <span class="fs--2 fw-bold text-muted text-uppercase tracking-wider mb-1" style="line-height: 1; font-size: 0.65rem;">
                                                            NO. ANTRIAN
                                                        </span>
                                                        <span class="text-danger fw-black text-nowrap" id="text-no-antrian" style="font-weight: 900 !important; font-size: 1.25rem; line-height: 1; letter-spacing: 1px;">
                                                            {{ $noAntrian }}
                                                        </span>
                                                    </div>
                                                </div>
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

                                                    <!-- DAFTAR FORM LAMPIRAN PEMERIKSAAN MCU -->
                                                    @if(isset($mcu_forms) && count($mcu_forms) > 0)
                                                    <div class="col-12 my-3">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-grow-1 border-bottom"></div>
                                                            <span class="px-3 text-400 fs--2 fw-bold tracking-wider text-uppercase">Lampiran Form Pemeriksaan</span>
                                                            <div class="flex-grow-1 border-bottom"></div>
                                                        </div>
                                                    </div>

                                                    <div class="col-12">
                                                        <div class="d-flex flex-column gap-2">
                                                            @foreach ($mcu_forms as $form)
                                                            <?php
                                                            $isAnswered = Illuminate\Support\Facades\DB::table('mcu_peserta_answers')
                                                                ->where('mou_peserta_code', $data->mou_peserta_code)
                                                                ->where('id_mcu_form', $form->id_mcu_form)
                                                                ->where('is_completed', true)
                                                                ->exists();
                                                            ?>
                                                            <div class="mcu-form-item d-flex align-items-center justify-content-between {{ $isAnswered ? 'is-completed' : '' }}" id="form-item-{{ $form->form_code }}">
                                                                <div class="d-flex align-items-center me-2">
                                                                    <i class="fas {{ $isAnswered ? 'fa-check-circle text-success' : 'fa-file-medical text-danger' }} fs-0 me-3 form-icon"></i>
                                                                    <div>
                                                                        <h6 class="mb-0 text-900 fw-bold fs--1">{{ $form->form_name }}</h6>
                                                                        <small class="text-500 fs--2 form-status-text">
                                                                            {{ $isAnswered ? 'Sudah Diisi' : ($form->description ?? 'Formulir Wajib Diisi') }}
                                                                        </small>
                                                                    </div>
                                                                </div>
                                                                <button type="button"
                                                                    class="btn btn-sm {{ $isAnswered ? 'btn-outline-success' : 'btn-outline-danger' }} px-3 rounded-pill fw-semibold fs--2 d-flex align-items-center gap-1 btn-open-form btn-form-action"
                                                                    data-form-code="{{ $form->form_code }}"
                                                                    data-form-name="{{ $form->form_name }}">
                                                                    <i class="fas {{ $isAnswered ? 'fa-check' : 'fa-edit' }} btn-icon"></i>
                                                                    <span class="btn-text">{{ $isAnswered ? 'Selesai' : 'Isi Form' }}</span>
                                                                </button>
                                                            </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    @endif

                                                    <!-- HEADER TIMELINE STATUS PEMERIKSAAN + BUTTON REFRESH AJAX -->
                                                    <div class="col-12 my-3">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-grow-1 border-bottom"></div>
                                                            <span class="px-2 text-400 fs--2 fw-bold tracking-wider text-uppercase">Timeline Alur Pemeriksaan MCU</span>

                                                            <!-- Button Refresh Status Antrian -->
                                                            <button type="button" id="btn-refresh-status" class="btn btn-sm btn-outline-danger rounded-pill py-0 px-2 ms-1 shadow-sm d-flex align-items-center gap-1">
                                                                <i class="fas fa-sync-alt icon-refresh"></i> <span style="font-size: 0.68rem;">Refresh Status</span>
                                                            </button>

                                                            <div class="flex-grow-1 border-bottom ms-2"></div>
                                                        </div>
                                                    </div>

                                                    <!-- TIMELINE PEMERIKSAAN MCU -->
                                                    <div class="col-12">
                                                        <div class="mcu-timeline-container">
                                                            <?php
                                                            $hitung = 0;
                                                            $allPemeriksaan = array_merge($pemeriksaan->all(), $pemeriksaan1->all());
                                                            ?>

                                                            @foreach ($allPemeriksaan as $pem)
                                                            <?php
                                                            $cleanCode = trim($pem->master_pemeriksaan_code);
                                                            $userCode  = $data->mou_peserta_code;
                                                            $isAdditional = in_array($pem, $pemeriksaan1->all());

                                                            $ket = Illuminate\Support\Facades\DB::table('log_pemeriksaan_pasien')
                                                                ->where('mou_peserta_code', $userCode)
                                                                ->where('master_pemeriksaan_code', $pem->master_pemeriksaan_code)
                                                                ->first();

                                                            $cek = Illuminate\Support\Facades\DB::table('log_pemeriksaan_pasien')
                                                                ->where('mou_peserta_code', $userCode)
                                                                ->where('master_pemeriksaan_code', $pem->master_pemeriksaan_code)
                                                                ->where('log_pemeriksaan_status', 1)
                                                                ->first();

                                                            $cek1 = Illuminate\Support\Facades\DB::table('log_pemeriksaan_pasien')
                                                                ->where('mou_peserta_code', $userCode)
                                                                ->where('master_pemeriksaan_code', $pem->master_pemeriksaan_code)
                                                                ->where('log_pemeriksaan_status', 0)
                                                                ->first();

                                                            if ($cek || $cek1) $hitung++;

                                                            $logPemanggilan = Illuminate\Support\Facades\DB::table('log_pemanggilan_pos')
                                                                ->where('mou_peserta_code', $userCode)
                                                                ->where('master_pemeriksaan_code', $pem->master_pemeriksaan_code)
                                                                ->first();

                                                            $statusPos = $logPemanggilan->status_antrian ?? ($pem->status_antrian ?? 'Menunggu');

                                                            // Jika sudah selesai di database log_pemeriksaan_pasien, paksa statusPos menjadi 'Selesai'
                                                            if ($cek) {
                                                                $statusPos = 'Selesai';
                                                            }

                                                            // Ambil waktu selesai dari created_at jika ada rekamannya
                                                            $waktuSelesai = $cek ? $cek->created_at : null;

                                                            // Tentukan class timeline item
                                                            $timelineClass = '';
                                                            $dotIcon = '<i class="fas fa-clock"></i>';
                                                            if ($statusPos == 'Selesai') {
                                                                $timelineClass = 'item-completed';
                                                                $dotIcon = '<i class="fas fa-check"></i>';
                                                            } elseif ($statusPos == 'Dipanggil' || $statusPos == 'Sedang Diperiksa') {
                                                                $timelineClass = 'item-active';
                                                                $dotIcon = '<i class="fas fa-spinner fa-spin"></i>';
                                                            }
                                                            ?>

                                                            <div class="mcu-timeline-item {{ $timelineClass }}" id="timeline-item-{{ $cleanCode }}">
                                                                <div class="mcu-timeline-dot">
                                                                    {!! $dotIcon !!}
                                                                </div>

                                                                <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between gap-2">
                                                                    <div>
                                                                        <h6 class="fw-bold text-800 mb-1">
                                                                            <span class="nama-pemeriksaan">{{ $pem->master_pemeriksaan_name }}</span>
                                                                            @if($isAdditional)
                                                                            <span class="badge bg-danger-subtle text-danger ms-1" style="font-size: 0.65rem;">Additional</span>
                                                                            @endif
                                                                        </h6>
                                                                        <small class="d-block text-muted" id="label_ket_{{ $cleanCode }}">
                                                                            {{ $cek1 && $ket ? 'Keterangan: ' . $ket->log_pemeriksaan_deskripsi : 'Tahapan pemeriksaan wajib diselesaikan.' }}
                                                                        </small>
                                                                    </div>

                                                                    <div class="d-flex align-items-center gap-2 flex-wrap mt-2 mt-sm-0">
                                                                        <!-- Status Pos Antrian Badge -->
                                                                        <div id="status_antrian_{{ $cleanCode }}">
                                                                            @switch($statusPos)
                                                                            @case('Dipanggil')
                                                                            <span class="badge bg-warning text-white px-2 py-1"><i class="fas fa-bullhorn me-1"></i> Dipanggil</span>
                                                                            @break
                                                                            @case('Sedang Diperiksa')
                                                                            <span class="badge bg-info text-white px-2 py-1"><i class="fas fa-user-md me-1"></i> Diperiksa</span>
                                                                            @break
                                                                            @case('Selesai')
                                                                            @php
                                                                            $formattedTime = $waktuSelesai ? date('H:i', strtotime($waktuSelesai)) : '';
                                                                            @endphp
                                                                            <span class="badge bg-success px-2 py-1">
                                                                                <i class="fas fa-check-circle me-1"></i> Selesai
                                                                                @if($formattedTime)
                                                                                <span class="fw-light ms-1">({{ $formattedTime }})</span>
                                                                                @endif
                                                                            </span>
                                                                            @break
                                                                            @case('Lewat/Skip')
                                                                            <div class="d-inline-flex align-items-center gap-1">
                                                                                <span class="badge bg-secondary px-2 py-1"><i class="fas fa-forward me-1"></i> Di-skip</span>
                                                                                <button type="button" class="btn btn-xs btn-outline-warning rounded-pill py-0 px-2" style="font-size: 0.65rem;" onclick="resetAntrianMenunggu('{{ $cleanCode }}', '{{ $userCode }}')">
                                                                                    <i class="fas fa-undo me-1"></i> Kembalikan
                                                                                </button>
                                                                            </div>
                                                                            @break
                                                                            @default
                                                                            <div class="d-inline-flex align-items-center gap-1">
                                                                                <span class="badge bg-light text-muted border px-2 py-1"><i class="fas fa-clock me-1"></i> Menunggu</span>
                                                                                <button type="button" class="btn btn-xs btn-outline-primary rounded-pill py-0 px-2" style="font-size: 0.65rem;" onclick="cekAntrianDipanggil('{{ $cleanCode }}', '{{ $userCode }}')">
                                                                                    <i class="fas fa-search me-1"></i> Cek
                                                                                </button>
                                                                            </div>
                                                                            @endswitch
                                                                        </div>

                                                                        <!-- Action Button -->
                                                                        <div id="cell_action_{{ $cleanCode }}">
                                                                            @if($cek)
                                                                            <button type="button" class="btn btn-sm btn-success px-2 py-1 fs--2 rounded-pill shadow-none" onclick="openActionSwal('{{ $cleanCode }}','{{ $userCode }}', '{{ $pem->master_pemeriksaan_name }}')">
                                                                                <i class="fas fa-check-circle me-1"></i> Sudah
                                                                            </button>
                                                                            @elseif($cek1)
                                                                            <button type="button" class="btn btn-sm btn-danger px-2 py-1 fs--2 rounded-pill shadow-none" onclick="openActionSwal('{{ $cleanCode }}','{{ $userCode }}', '{{ $pem->master_pemeriksaan_name }}')">
                                                                                <i class="fas fa-times-circle me-1"></i> Tidak
                                                                            </button>
                                                                            @else
                                                                            <button type="button" class="btn btn-sm btn-outline-danger px-2 py-1 fs--2 rounded-pill shadow-none" onclick="openActionSwal('{{ $cleanCode }}','{{ $userCode }}', '{{ $pem->master_pemeriksaan_name }}')">
                                                                                Pilih Status
                                                                            </button>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endforeach
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

    <!-- Modal Fullscreen Dynamic MCU Form -->
    <div class="modal fade" id="mcuFormModal" tabindex="-1" aria-labelledby="mcuFormModalLabel" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content border-0">
                <div class="modal-header bg-gradient-red-vibrant text-white py-3 px-4">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-file-medical fs-1"></i>
                        <h5 class="modal-title text-white fw-bold mb-0" id="mcuFormModalLabel">Formulir Pemeriksaan</h5>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-2 bg-light">
                    <div id="modalFormContainer">
                        <div class="d-flex justify-content-center align-items-center h-100">
                            <div class="spinner-border text-danger" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-white border-top px-4 py-3">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-vibrant-red btn-sm" id="btnSaveForm">Simpan Form</button>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScripts -->
    <script src="{{ asset('vendors/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendors/anchorjs/anchor.min.js') }}"></script>
    <script src="{{ asset('vendors/is/is.min.js') }}"></script>
    <script src="{{ asset('vendors/fontawesome/all.min.js') }}"></script>
    <script src="{{ asset('vendors/lodash/lodash.min.js') }}"></script>
    <script src="{{ asset('asset/js/theme.js') }}"></script>
    <script src="{{ asset('asset/notifications/js/notifications.min.js') }}"></script>

    <script>
        var calledItems = {};

        function playCallSound(noAntrian, outletName) {
            if (!('speechSynthesis' in window)) return;
            window.speechSynthesis.cancel();
            var textToSpeak = "Nomor antrian, " + noAntrian + ". Silakan menuju ke " + outletName + ".";
            var utterance = new SpeechSynthesisUtterance(textToSpeak);
            utterance.lang = 'id-ID';
            utterance.rate = 0.9;
            utterance.pitch = 1.0;
            var voices = window.speechSynthesis.getVoices();
            var idVoice = voices.find(function(voice) {
                return voice.lang.includes('id') || voice.lang.includes('ID');
            });
            if (idVoice) utterance.voice = idVoice;
            window.speechSynthesis.speak(utterance);
        }

        if ('speechSynthesis' in window) {
            window.speechSynthesis.onvoiceschanged = function() {
                window.speechSynthesis.getVoices();
            };
        }

        $(document).ready(function() {
            <?php
            $getAntrian = Illuminate\Support\Facades\DB::table('log_antrian_peserta')
                ->where('mou_peserta_code', $data->mou_peserta_code)
                ->first();

            $nomorAntrianFix = $noAntrian
                ?? $getAntrian->nomor_antrian
                ?? $getAntrian->log_antrian_peserta_nomor
                ?? $getAntrian->no_antrian
                ?? '-';
            ?>

            var noAntrian = "{{ $nomorAntrianFix }}";
            var tanggalAntrian = "{{ date('d-m-Y H:i') }}";

            Swal.fire({
                title: 'Panduan Alur MCU',
                html: `
                <div class="mb-3 p-3 text-center" style="background-color: #fdfbf7; border: 2px dashed #cbd5e1; border-radius: 12px; font-family: 'Courier New', Courier, monospace;">
                    <div class="fw-bold text-uppercase fs--2 text-muted tracking-wider mb-1">=== NO. ANTRIAN MCU ===</div>
                    <div class="text-danger" style="font-size: 2.8rem; font-weight: 900; line-height: 1; letter-spacing: 2px;">
                        ${noAntrian}
                    </div>
                    <div class="fs--2 text-secondary mt-2"><i class="far fa-clock me-1"></i>${tanggalAntrian} WIB</div>
                </div>
                <div class="text-start fs--1 lh-base">
                    <p class="mb-2 fw-semibold text-900">Petunjuk Pelaksanaan:</p>
                    <ol class="ps-3 mb-0">
                        <li class="mb-2"><strong>Ikuti Timeline:</strong> Selesaikan tahapan pemeriksaan secara berurutan pada timeline yang tersedia.</li>
                        <li class="mb-2"><strong>Isi Form Lampiran:</strong> Lengkapi form yang disediakan sebelum menyelesaikan seluruh tahap.</li>
                        <li class="mb-2"><strong>Pantau Status Pos:</strong> Pastikan Anda memperbarui status atau merespon panggilan pos pemeriksaan tepat waktu.</li>
                    </ol>
                </div>
            `,
                icon: 'info',
                confirmButtonText: 'Saya Mengerti',
                confirmButtonColor: '#E60026',
                allowOutsideClick: false
            });

            $('#btn-refresh-status').on('click', function(e) {
                if (e) e.preventDefault();
                var $btn = $(this);
                var $icon = $btn.find('.icon-refresh');
                var userCode = "{{ $data->mou_peserta_code }}";

                $icon.addClass('fa-spin');
                $btn.prop('disabled', true);

                $.ajax({
                    url: "{{ route('signaturepad.cek_status_antrian') }}",
                    type: "GET",
                    data: {
                        user_code: userCode
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.status === 'success') {
                            var total = $('#jumlah').val();

                            $.each(response.data, function(code, itemData) {
                                var cleanCode = $.trim(code);

                                // 1. Update Badge Status Antrian (Otomatis menampilkan "Selesai (HH:MM)")
                                var $cell = $('#status_antrian_' + cleanCode);
                                if ($cell.length) {
                                    $cell.html(itemData.badge);
                                }

                                // 2. Update Class & Border Timeline Item
                                var $timelineItem = $('#timeline-item-' + cleanCode);
                                if ($timelineItem.length) {
                                    $timelineItem.removeClass('item-completed item-active');
                                    if (itemData.timeline_class) {
                                        $timelineItem.addClass(itemData.timeline_class);
                                    }

                                    var $dot = $timelineItem.find('.mcu-timeline-dot');
                                    if ($dot.length) {
                                        $dot.html(itemData.dot_icon);
                                    }
                                }

                                // 3. Logika Otomatis Jika Selesai
                                if (itemData.is_completed) {
                                    var $actionCell = $('#cell_action_' + cleanCode);

                                    if ($actionCell.length && !$actionCell.find('.btn-success').length) {
                                        var namaPemeriksaan = $timelineItem.find('.nama-pemeriksaan').text().trim();

                                        $('#label_ket_' + cleanCode).text('');
                                        sendDataAjax(cleanCode, userCode, 'on', '', total);

                                        // Update tampilan cell aksi menjadi tombol "Sudah"
                                        $actionCell.html(`
                            <button type="button" class="btn btn-sm btn-success px-2 py-1 fs--2 rounded-pill shadow-none" onclick="openActionSwal('${cleanCode}','${userCode}', '${namaPemeriksaan}')">
                                <i class="fas fa-check-circle me-1"></i> Sudah
                            </button>
                        `);

                                        $timelineItem.addClass('item-completed').removeClass('item-active');
                                        $timelineItem.find('.mcu-timeline-dot').html('<i class="fas fa-check"></i>');
                                    }
                                }

                                // Trigger suara panggilan jika aktif
                                if (itemData.timeline_class === 'item-active') {
                                    var trackKey = userCode + '_' + cleanCode;
                                    var outletName = $timelineItem.find('.nama-pemeriksaan').text().trim();
                                    if (!calledItems[trackKey]) {
                                        calledItems[trackKey] = true;
                                        playCallSound(noAntrian, outletName);
                                    }
                                }
                            });
                        }
                    },
                    complete: function() {
                        $icon.removeClass('fa-spin');
                        $btn.prop('disabled', false);
                    }
                });
            });

            setInterval(function() {
                $('#btn-refresh-status').click();
            }, 15000);
        });

        function cekAntrianDipanggil(pemCode, userCode) {
            $.ajax({
                url: "{{ route('signaturepad.cek_panggilan_antrian') }}",
                type: "GET",
                data: {
                    pem_code: pemCode,
                    user_code: userCode
                },
                dataType: "json",
                success: function(response) {
                    if (response.status === 'success') {
                        let nextList = (response.daftar_antrian_next && response.daftar_antrian_next.length > 0) ? response.daftar_antrian_next.join(', ') : '-';
                        Swal.fire({
                            title: 'Status Antrian Pos',
                            html: `
                                <div class="my-2 p-3 text-center" style="background-color: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 12px;">
                                    <span class="fs--2 text-uppercase text-muted fw-bold">Sedang Dipanggil saat ini:</span>
                                    <div class="text-danger fw-black my-1" style="font-size: 2.2rem; font-weight: 900;">${response.no_antrian_dipanggil}</div>
                                    <span class="badge bg-warning text-dark mb-2">${response.status_pos}</span>
                                    <hr class="my-2" style="border-top: 1px dashed #cbd5e1;">
                                    <div class="row text-start mt-2">
                                        <div class="col-6 mb-2"><small class="text-muted d-block">Nomor Anda:</small><strong class="text-primary fs-0">${response.no_antrian_saya}</strong></div>
                                        <div class="col-6 mb-2"><small class="text-muted d-block">Sisa Antrian:</small><strong class="text-dark fs-0">${response.sisa_antrian} Orang</strong></div>
                                        <div class="col-12 mt-1"><small class="text-muted d-block">Selanjutnya:</small><span class="badge bg-light text-dark border px-2 py-1 mt-1">${nextList}</span></div>
                                    </div>
                                </div>
                            `,
                            confirmButtonText: 'Tutup',
                            confirmButtonColor: '#E60026'
                        });
                    } else {
                        Swal.fire({
                            title: 'Informasi Antrian',
                            text: response.message || 'Belum ada antrian dipanggil.',
                            icon: 'info',
                            confirmButtonColor: '#E60026'
                        });
                    }
                }
            });
        }

        function resetAntrianMenunggu(pemCode, userCode) {
            Swal.fire({
                title: 'Kembalikan Antrian?',
                text: 'Status antrian Anda akan dikembalikan ke Menunggu.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Kembalikan',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#ffc107'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('signaturepad.reset_antrian_dipanggil') }}",
                        type: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            pem_code: pemCode,
                            user_code: userCode
                        },
                        dataType: "json",
                        success: function(response) {
                            if (response.status === 'success') {
                                location.reload();
                            }
                        }
                    });
                }
            });
        }
    </script>

    <script>
        function openActionSwal(id, userCode, namaPemeriksaan) {
            var total = $('#jumlah').val();

            Swal.fire({
                title: 'Status Pemeriksaan',
                text: 'Pilih status untuk ' + namaPemeriksaan + ':',
                icon: 'question',
                showCancelButton: true,
                showDenyButton: true,
                confirmButtonText: 'Sudah Melakukan',
                denyButtonText: 'Tidak / Belum',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#198754',
                denyButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#label_ket_' + $.trim(id)).text('');
                    sendDataAjax(id, userCode, 'on', '', total);

                    $('#cell_action_' + $.trim(id)).html(`
                        <button type="button" class="btn btn-sm btn-success px-2 py-1 fs--2 rounded-pill shadow-none" onclick="openActionSwal('${id}','${userCode}', '${namaPemeriksaan}')">
                            <i class="fas fa-check-circle me-1"></i> Sudah
                        </button>
                    `);
                    $('#timeline-item-' + $.trim(id)).addClass('item-completed').removeClass('item-active');
                    $('#timeline-item-' + $.trim(id)).find('.mcu-timeline-dot').html('<i class="fas fa-check"></i>');
                } else if (result.isDenied) {
                    Swal.fire({
                        title: 'Alasan Tidak/Belum Diperiksa',
                        text: 'Tuliskan deskripsi/alasan tidak melakukan ' + namaPemeriksaan,
                        input: 'textarea',
                        inputPlaceholder: 'Tuliskan alasan di sini...',
                        showCancelButton: true,
                        confirmButtonText: 'Simpan',
                        confirmButtonColor: '#E60026',
                        inputValidator: (value) => {
                            if (!value || !value.trim()) {
                                return 'Anda harus mengisi deskripsi/alasan!';
                            }
                        }
                    }).then((resKet) => {
                        if (resKet.isConfirmed) {
                            var ket = resKet.value;
                            sendDataAjax(id, userCode, 'off', ket, total);
                            $('#label_ket_' + $.trim(id)).text('Keterangan: ' + ket);

                            $('#cell_action_' + $.trim(id)).html(`
                                <button type="button" class="btn btn-sm btn-danger px-2 py-1 fs--2 rounded-pill shadow-none" onclick="openActionSwal('${id}','${userCode}', '${namaPemeriksaan}')">
                                    <i class="fas fa-times-circle me-1"></i> Tidak
                                </button>
                            `);
                            $('#timeline-item-' + $.trim(id)).addClass('item-completed').removeClass('item-active');
                        }
                    });
                }
            });
        }

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
                    "ket": ket
                },
                dataType: 'html',
            }).done(function(data) {
                Lobibox.notify('success', {
                    pauseDelayOnHover: true,
                    position: 'top right',
                    icon: 'fas fa-check-circle',
                    msg: 'Status berhasil diperbarui'
                });
                if (parseInt(data) == parseInt(total)) {
                    $("#button-submit-selesai").fadeIn();
                } else {
                    $("#button-submit-selesai").fadeOut();
                }
            });
        }
    </script>

    <script>
        var currentActiveFormCode = null;

        $(document).ready(function() {
            $('.btn-open-form').on('click', function(e) {
                e.preventDefault();
                var formCode = $(this).data('form-code');
                var formName = $(this).data('form-name');
                var userCode = "{{ $data->mou_peserta_code }}";

                currentActiveFormCode = formCode;
                $('#mcuFormModalLabel').text('Formulir: ' + formName);
                $('#modalFormContainer').html('<div class="d-flex justify-content-center align-items-center h-100 my-5"><div class="spinner-border text-danger" role="status"></div></div>');

                var formModal = new bootstrap.Modal(document.getElementById('mcuFormModal'));
                formModal.show();

                $.ajax({
                    url: "{{ route('signaturepad.get_data_form_pemeriksaan') }}",
                    type: "GET",
                    data: {
                        "form_code": formCode,
                        "user_code": userCode
                    },
                    success: function(response) {
                        $('#modalFormContainer').html(response);
                    }
                });
            });

            $('#btnSaveForm').on('click', function() {
                var $form = $('#mcuDynamicFormContent');
                if (!$form[0].checkValidity()) {
                    $form[0].reportValidity();
                    return;
                }

                var formData = $form.serialize();
                $.ajax({
                    url: "{{ route('signaturepad.save_data_form_pemeriksaan') }}",
                    type: "POST",
                    data: formData,
                    dataType: "json",
                    success: function(response) {
                        if (response.status === 'success') {
                            if (currentActiveFormCode) {
                                var $itemWrapper = $('#form-item-' + currentActiveFormCode);
                                $itemWrapper.addClass('is-completed');
                                $itemWrapper.find('.form-icon').removeClass('fa-file-medical text-danger').addClass('fa-check-circle text-success');
                                $itemWrapper.find('.form-status-text').text('Sudah Diisi');
                                var $btn = $itemWrapper.find('.btn-form-action');
                                $btn.removeClass('btn-outline-danger').addClass('btn-outline-success');
                                $btn.find('.btn-text').text('Selesai');
                            }
                            var modalEl = document.getElementById('mcuFormModal');
                            var modal = bootstrap.Modal.getInstance(modalEl);
                            if (modal) modal.hide();
                            Lobibox.notify('success', {
                                pauseDelayOnHover: true,
                                position: 'top right',
                                icon: 'fas fa-check-circle',
                                msg: response.message
                            });
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>
