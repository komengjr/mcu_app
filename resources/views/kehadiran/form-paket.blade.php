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
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-12px); }
        }

        .bg-auth-circle-shape { animation: bounceFloat 6s ease-in-out infinite; }
        .bg-auth-circle-shape-2 { animation: bounceFloat 8s ease-in-out infinite reverse; }

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

        .glow-orb-1 { top: -50px; right: -50px; }
        .glow-orb-2 { bottom: -70px; left: -50px; background: rgba(0, 0, 0, 0.25); }

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
            padding: 8px 18px;
            box-shadow: 0 6px 18px -4px rgba(230, 0, 38, 0.4);
            transition: all 0.3s ease;
        }

        .btn-vibrant-red:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 22px -4px rgba(230, 0, 38, 0.5);
            color: #fff;
        }

        /* Custom Accordion Styling */
        .accordion-item {
            border: 1px solid #E2E8F0 !important;
            border-radius: 12px !important;
            overflow: hidden;
            margin-bottom: 10px;
            background-color: #ffffff;
        }

        .accordion-button {
            font-size: 0.875rem;
            font-weight: 700;
            color: #1e293b;
            background-color: #f8fafc;
            padding: 0.85rem 1.15rem;
            box-shadow: none !important;
        }

        .accordion-button:not(.collapsed) {
            color: #c80022;
            background-color: #fff0f2;
        }

        .accordion-button::after {
            background-size: 1rem;
        }

        .accordion-body {
            padding: 1rem 1.25rem;
            background-color: #ffffff;
        }

        .paket-list-item {
            font-size: 0.85rem;
            color: #475569;
            padding: 4px 0;
            display: flex;
            align-items: center;
        }

        .paket-list-item i {
            color: #e60026;
            margin-right: 8px;
            font-size: 0.75rem;
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
                                                Selamat datang Peserta di Monitoring Medical Check Up System Management. Pastikan sebelum memilih paket, lakukan pengecekan identitas Anda.
                                            </p>

                                            <div class="glass-info-card">
                                                <div class="quote-border">
                                                    <p class="opacity-95 fs--1 lh-lg mb-0 text-white fw-light italic">
                                                        "Terima kasih atas kepercayaan yang telah diberikan kepada <strong class="fw-bold">Pramita</strong> untuk memenuhi kebutuhan pemeriksaan Medical Check Up (MCU). Kami berkomitmen memberikan pelayanan terbaik."
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
                                            <div class="mb-4">
                                                <h4 class="fw-bold text-900 mb-1">Data Peserta MCU</h4>
                                                <p class="text-500 fs--1">Periksa informasi diri Anda dan pilih paket pemeriksaan yang sesuai.</p>
                                            </div>

                                            <form method="POST" action="{{ route('signaturepad.update_pemeriksaan_save') }}">
                                                @csrf
                                                <input type="text" name="token" value="{{ $data->log_kehadiran_pasien_token }}" hidden>

                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-semibold text-700 fs--1 mb-1" for="card-name">Nama Lengkap</label>
                                                        <input class="form-control" type="text" id="card-name" value="{{ $data->mou_peserta_name }}" disabled />
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-semibold text-700 fs--1 mb-1" for="card-nip">Nomor Induk Pegawai</label>
                                                        <input class="form-control" type="text" id="card-nip" value="{{ $data->mou_peserta_nip }}" disabled />
                                                    </div>
                                                    <!-- <div class="col-md-6">
                                                        <label class="form-label fw-semibold text-700 fs--1 mb-1" for="card-hp">Nomor Whatsapp</label>
                                                        <input class="form-control" type="text" id="card-hp" value="{{ $data->mou_peserta_no_hp }}" disabled />
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-semibold text-700 fs--1 mb-1" for="card-email">Email</label>
                                                        <input class="form-control" type="text" id="card-email" value="{{ $data->mou_peserta_email }}" disabled />
                                                    </div> -->

                                                    <div class="col-12 my-3">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-grow-1 border-bottom"></div>
                                                            <span class="px-3 text-400 fs--2 fw-bold tracking-wider text-uppercase">Pilih Paket Pemeriksaan</span>
                                                            <div class="flex-grow-1 border-bottom"></div>
                                                        </div>
                                                    </div>

                                                    <!-- Accordion Paket Pemeriksaan -->
                                                    <div class="col-12">
                                                        <div class="accordion" id="accordionExample">
                                                            @foreach ($paket as $pakets)
                                                            <div class="accordion-item shadow-none">
                                                                <h2 class="accordion-header" id="heading{{$pakets->id_mou_agreement}}">
                                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#colspan{{$pakets->id_mou_agreement}}" aria-expanded="false" aria-controls="colspan{{$pakets->id_mou_agreement}}">
                                                                        <i class="fas fa-box-open text-danger me-2"></i> {{ $pakets->mou_agreement_name }}
                                                                    </button>
                                                                </h2>
                                                                <div class="accordion-collapse collapse" id="colspan{{$pakets->id_mou_agreement}}" aria-labelledby="heading{{$pakets->id_mou_agreement}}" data-bs-parent="#accordionExample">
                                                                    <div class="accordion-body">
                                                                        <?php
                                                                        $pemeriksaan = DB::table('company_mou_agreement_sub')
                                                                            ->join('master_pemeriksaan', 'master_pemeriksaan.master_pemeriksaan_code', '=', 'company_mou_agreement_sub.master_pemeriksaan_code')
                                                                            ->where('company_mou_agreement_sub.mou_agreement_code', $pakets->mou_agreement_code)->get();
                                                                        ?>
                                                                        <ul class="list-unstyled mb-3">
                                                                            @foreach ($pemeriksaan as $pem)
                                                                            <li class="paket-list-item">
                                                                                <i class="fas fa-check-circle"></i> {{ $pem->master_pemeriksaan_name }}
                                                                            </li>
                                                                            @endforeach
                                                                        </ul>

                                                                        <div class="d-flex justify-content-end pt-2 border-top">
                                                                            <button type="button" class="btn btn-vibrant-red btn-sm btn-pilih-paket" id="button-pilih-paket-pemeriksaan" data-id="{{ $data->mou_peserta_code }}" data-code="{{$pakets->mou_agreement_code}}" data-name="{{$pakets->mou_agreement_name}}">
                                                                                <i class="fas fa-check me-1"></i> Pilih Paket Ini
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endforeach
                                                        </div>
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
        $(document).on("click", "#button-pilih-paket-pemeriksaan", function(e) {
            e.preventDefault();
            var id = $(this).data("id");
            var code = $(this).data("code");
            var name = $(this).data("name");

            Swal.fire({
                title: "Konfirmasi Pilihan",
                text: "Apakah Anda yakin ingin memilih paket " + name + " ?",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Ya, Pilih Paket",
                cancelButtonText: "Batal",
                confirmButtonColor: "#E60026",
                cancelButtonColor: "#6c757d",
                customClass: {
                    confirmButton: 'rounded-pill px-4',
                    cancelButton: 'rounded-pill px-4'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Memproses...",
                        text: "Sedang menyimpan pilihan paket Anda.",
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

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
                        Swal.fire({
                            title: "Berhasil!",
                            text: "Paket pemeriksaan berhasil dipilih.",
                            icon: "success",
                            confirmButtonColor: "#E60026"
                        }).then(() => {
                            location.reload();
                        });
                    }).fail(function() {
                        Swal.fire({
                            title: "Gagal!",
                            text: "Terjadi kesalahan saat menyimpan paket. Halaman akan diperbarui.",
                            icon: "error",
                            confirmButtonColor: "#E60026"
                        }).then(() => {
                            location.reload();
                        });
                    });
                }
            });
        });
    </script>
</body>

</html>
