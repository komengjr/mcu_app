<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Monitoring MCU Peserta</title>
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/dashboard.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/dashboard.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/dashboard.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/dashboard.png') }}">
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f1f5f9;
            color: #334155;
            font-size: 0.78rem;
        }

        /* Header Styling */
        .header-card {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: #ffffff;
            border-radius: 12px;
            padding: 12px 20px;
            border-left: 5px solid #0284c7;
        }

        .company-logo {
            width: 45px;
            height: 45px;
            object-fit: contain;
            background: #ffffff;
            border-radius: 8px;
            padding: 4px;
        }

        .pulse-indicator {
            width: 8px;
            height: 8px;
            background-color: #10b981;
            border-radius: 50%;
            display: inline-block;
            box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
            animation: pulse-green 1.8s infinite;
        }

        @keyframes pulse-green {
            0% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
            }

            70% {
                transform: scale(1);
                box-shadow: 0 0 0 6px rgba(16, 185, 129, 0);
            }

            100% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0);
            }
        }

        /* Colorful Micro Card Styling */
        .card-peserta-micro {
            border-radius: 10px;
            background: #ffffff;
            transition: all 0.2s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.04);
            height: 100%;
            border: 1px solid #e2e8f0;
            border-top: 4px solid #cbd5e1;
            /* Default Gray */
        }

        .card-peserta-micro:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.08);
        }

        /* Varian Warna Card Berdasarkan Status */
        .card-status-belum {
            border-top-color: #94a3b8 !important;
            /* Slate / Abu-abu */
            background: linear-gradient(180deg, #f8fafc 0%, #ffffff 40%);
        }

        .card-status-proses {
            border-top-color: #f59e0b !important;
            /* Amber / Kuning Orang tua */
            background: linear-gradient(180deg, #fffbeb 0%, #ffffff 40%);
        }

        .card-status-selesai {
            border-top-color: #10b981 !important;
            /* Emerald / Hijau */
            background: linear-gradient(180deg, #ecfdf5 0%, #ffffff 40%);
        }

        .progress-xs {
            height: 5px;
            border-radius: 10px;
            background-color: #e2e8f0;
        }

        /* Pill Pemeriksaan */
        .pemeriksaan-pill-xs {
            font-size: 0.62rem;
            padding: 2px 6px;
            border-radius: 4px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 3px;
        }

        /* Status Selesai MCU -> bg-primary */
        .status-done {
            background-color: #0d6efd !important;
            color: #ffffff !important;
            border: 1px solid #0d6efd;
        }

        /* Status Belum MCU -> Light */
        .status-pending {
            background-color: #f8fafc !important;
            color: #64748b !important;
            border: 1px solid #cbd5e1;
        }

        .search-box {
            border-radius: 8px;
            padding: 5px 12px;
            font-size: 0.78rem;
            border: 1px solid #cbd5e1;
        }

        .btn-filter {
            border-radius: 8px;
            font-size: 0.725rem;
            font-weight: 600;
            padding: 5px 10px;
            transition: all 0.2s ease;
        }
    </style>
</head>

<body class="py-2">

    <div class="container-fluid px-3">

        <!-- Header Perusahaan & MOU -->
        <div class="header-card mb-3">
            <div class="row align-items-center g-2">
                <div class="col-md-8">
                    <div class="d-flex align-items-center gap-3">
                        <!-- Logo Perusahaan / Fallback Icon -->
                        @if(!empty($company->master_company_logo))
                        <img src="{{ asset('uploads/company_logo/' . $company->master_company_logo) }}" alt="Logo" class="company-logo shadow-sm">
                        @else
                        <div class="company-logo d-flex align-items-center justify-content-center shadow-sm">
                            <i class="fa-solid fa-building text-secondary fs-4"></i>
                        </div>
                        @endif

                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="pulse-indicator"></span>
                                <span class="badge bg-success-subtle text-success fw-semibold px-2 py-0-5 rounded-pill" style="font-size: 0.6rem;">LIVE MONITORING</span>
                            </div>
                            <h5 class="fw-bold mb-0 text-white">
                                {{ $company->company_mou_name ?? 'Nama Perusahaan Tidak Ditemukan' }}
                            </h5>
                            <small class="text-info fw-semibold" style="font-size: 0.75rem;">
                                <i class="fa-solid fa-file-contract me-1"></i>MOU: {{ $company->company_mou_title ?? $company->company_mou_code ?? '-' }}
                            </small>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 d-flex justify-content-md-end gap-3 text-white">
                    <div class="text-center">
                        <small class="text-white-50 d-block" style="font-size: 0.65rem;">Total Peserta</small>
                        <span id="totalPeserta" class="fw-bold fs-6">0</span>
                    </div>
                    <div class="border-end border-secondary my-1"></div>
                    <div class="text-center">
                        <small class="text-white-50 d-block" style="font-size: 0.65rem;">Pembaruan</small>
                        <span id="lastUpdated" class="fw-bold" style="font-size: 0.78rem;">--:--:--</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Tabs & Search Bar -->
        <div class="row mb-3 align-items-center g-2">
            <div class="col-lg-8 d-flex flex-wrap gap-1">
                <button type="button" class="btn btn-dark btn-filter filter-btn active" data-filter="all">
                    Semua <span id="countAll" class="badge bg-light text-dark ms-1">0</span>
                </button>
                <button type="button" class="btn btn-outline-secondary btn-filter filter-btn" data-filter="belum">
                    <i class="fa-regular fa-circle-xmark me-1"></i>Belum Check-In <span id="countBelum" class="badge bg-secondary ms-1">0</span>
                </button>
                <button type="button" class="btn btn-outline-warning btn-filter filter-btn" data-filter="proses">
                    <i class="fa-solid fa-spinner me-1"></i>Sedang Proses <span id="countProses" class="badge bg-warning text-dark ms-1">0</span>
                </button>
                <button type="button" class="btn btn-outline-success btn-filter filter-btn" data-filter="selesai">
                    <i class="fa-solid fa-circle-check me-1"></i>Selesai MCU <span id="countSelesai" class="badge bg-success ms-1">0</span>
                </button>
            </div>

            <div class="col-lg-4 d-flex gap-2">
                <div class="position-relative flex-grow-1">
                    <i class="fa-solid fa-magnifying-glass position-absolute top-50 start-0 translate-middle-y ms-3 text-muted" style="font-size: 0.725rem;"></i>
                    <input type="text" id="searchInput" class="form-control search-box ps-5" placeholder="Cari nama atau NIK...">
                </div>
                <button onclick="fetchLiveData()" class="btn btn-white border rounded-2 px-2 shadow-sm text-secondary" title="Refresh Manual">
                    <i class="fa-solid fa-rotate"></i>
                </button>
            </div>
        </div>

        <!-- Grid Container Card (Menggunakan col-12 col-sm-4 col-md-3 col-xl-2) -->
        <div id="liveDataContainer" class="row g-2">
            <!-- Card Peserta akan di-render di sini -->
        </div>

    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const routeUrl = "{{ route('monitoring_mcu_live_mcu_peserta_company', ['code' => $code]) }}";
        let rawPesertaData = [];
        let currentFilter = 'all';

        function fetchLiveData() {
            $.ajax({
                url: routeUrl,
                type: 'GET',
                data: {
                    type: 'data'
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        rawPesertaData = response.data;
                        $('#totalPeserta').text(response.total_sedang_mcu);

                        const now = new Date();
                        $('#lastUpdated').text(now.toLocaleTimeString('id-ID'));

                        updateFilterCounts();
                        applyFilterAndSearch();
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching live data:', error);
                }
            });
        }

        function updateFilterCounts() {
            let countBelum = 0;
            let countProses = 0;
            let countSelesai = 0;

            rawPesertaData.forEach(p => {
                if (!p.is_checkin) {
                    countBelum++;
                } else if (p.progress_percent === 100) {
                    countSelesai++;
                } else {
                    countProses++;
                }
            });

            $('#countAll').text(rawPesertaData.length);
            $('#countBelum').text(countBelum);
            $('#countProses').text(countProses);
            $('#countSelesai').text(countSelesai);
        }

        function applyFilterAndSearch() {
            const query = $('#searchInput').val().toLowerCase();

            const filtered = rawPesertaData.filter(item => {
                let matchFilter = false;

                if (currentFilter === 'all') {
                    matchFilter = true;
                } else if (currentFilter === 'belum' && !item.is_checkin) {
                    matchFilter = true;
                } else if (currentFilter === 'proses' && item.is_checkin && item.progress_percent < 100) {
                    matchFilter = true;
                } else if (currentFilter === 'selesai' && item.is_checkin && item.progress_percent === 100) {
                    matchFilter = true;
                }

                const matchSearch = item.name.toLowerCase().includes(query) || item.nik.toLowerCase().includes(query);

                return matchFilter && matchSearch;
            });

            renderData(filtered);
        }

        function renderData(dataList) {
            const container = $('#liveDataContainer');
            container.empty();

            if (dataList.length === 0) {
                container.html(`
                    <div class="col-12 text-center py-4">
                        <div class="card card-peserta-micro py-4">
                            <i class="fa-solid fa-user-slash fs-4 text-muted mb-2"></i>
                            <span class="text-muted">Tidak ada data peserta pada kategori ini.</span>
                        </div>
                    </div>
                `);
                return;
            }

            dataList.forEach(peserta => {
                let pemeriksaanHtml = '';

                if (!peserta.is_checkin) {
                    pemeriksaanHtml = `<span class="text-muted fst-italic" style="font-size:0.63rem;">Belum Check-In</span>`;
                } else {
                    peserta.list_pemeriksaan.forEach(item => {
                        // Menggunakan operator '==' agar kompatibel jika tipe berupa string "1"
                        if (item.status == 1) {
                            pemeriksaanHtml += `
                                <span class="pemeriksaan-pill-xs status-done shadow-sm" title="Selesai ${item.waktu_selesai}">
                                    <i class="fa-solid fa-check"></i> ${item.nama}
                                </span>
                            `;
                        } else {
                            pemeriksaanHtml += `
                                <span class="pemeriksaan-pill-xs status-pending">
                                    <i class="fa-regular fa-circle"></i> ${item.nama}
                                </span>
                            `;
                        }
                    });
                }

                // Badge Status & Styling Border Card
                let statusBadge = '';
                let cardColorClass = '';

                if (!peserta.is_checkin) {
                    statusBadge = '<span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle" style="font-size:0.58rem;">Belum</span>';
                    cardColorClass = 'card-status-belum';
                } else if (peserta.progress_percent === 100) {
                    statusBadge = '<span class="badge bg-success-subtle text-success border border-success-subtle" style="font-size:0.58rem;">Selesai</span>';
                    cardColorClass = 'card-status-selesai';
                } else {
                    statusBadge = '<span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle" style="font-size:0.58rem;">Proses</span>';
                    cardColorClass = 'card-status-proses';
                }

                const genderIcon = peserta.jk === 'L' ? '<i class="fa-solid fa-mars text-info me-1"></i>' : '<i class="fa-solid fa-venus text-danger me-1"></i>';

                // Grid Card col-12 col-sm-4 col-md-3 col-xl-2 (Layout col-md-2 / 6 card per baris)
                const card = `
                    <div class="col-12 col-sm-4 col-md-3 col-xl-2">
                        <div class="card card-peserta-micro ${cardColorClass} p-2">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <div class="text-truncate me-1">
                                    <h6 class="fw-bold mb-0 text-dark text-truncate" style="font-size: 0.78rem;" title="${peserta.name}">
                                        ${genderIcon}${peserta.name}
                                    </h6>
                                    <div class="text-muted text-truncate" style="font-size: 0.65rem;">
                                        ${peserta.nik}
                                    </div>
                                </div>
                                <div class="text-end flex-shrink-0">
                                    ${statusBadge}
                                </div>
                            </div>

                            <div class="d-flex align-items-center gap-2 my-1">
                                <div class="progress progress-xs flex-grow-1">
                                    <div class="progress-bar ${peserta.progress_percent === 100 ? 'bg-success' : 'bg-warning'}" role="progressbar" style="width: ${peserta.progress_percent}%"></div>
                                </div>
                                <span class="fw-bold text-dark" style="font-size: 0.65rem;">${peserta.selesai_pemeriksaan}/${peserta.total_pemeriksaan}</span>
                            </div>

                            <div class="d-flex flex-wrap gap-1 my-1" style="min-height: 26px;">
                                ${pemeriksaanHtml}
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-1 pt-1 border-top text-muted" style="font-size: 0.62rem;">
                                <span class="text-truncate" title="Cabang: ${peserta.cabang}"><i class="fa-solid fa-location-dot me-1"></i>${peserta.cabang}</span>
                                <span><i class="fa-regular fa-clock me-1"></i>${peserta.waktu_checkin}</span>
                            </div>
                        </div>
                    </div>
                `;
                container.append(card);
            });
        }

        // Logic Filter Tab (Sudah Diperbaiki agar Button Aktif Berwarna & Kembali Normal Jika Diklik Lain)
        $('.filter-btn').on('click', function() {
            // 1. Reset SEMUA tombol ke gaya outline awal
            $('[data-filter="all"]').attr('class', 'btn btn-outline-dark btn-filter filter-btn');
            $('[data-filter="belum"]').attr('class', 'btn btn-outline-secondary btn-filter filter-btn');
            $('[data-filter="proses"]').attr('class', 'btn btn-outline-warning btn-filter filter-btn');
            $('[data-filter="selesai"]').attr('class', 'btn btn-outline-success btn-filter filter-btn');

            // 2. Terapkan warna solid penuh pada tombol yang sedang aktif diklik
            const target = $(this).data('filter');
            if (target === 'all') {
                $(this).attr('class', 'btn btn-dark btn-filter filter-btn active');
            } else if (target === 'belum') {
                $(this).attr('class', 'btn btn-secondary text-white btn-filter filter-btn active');
            } else if (target === 'proses') {
                $(this).attr('class', 'btn btn-warning text-dark btn-filter filter-btn active');
            } else if (target === 'selesai') {
                $(this).attr('class', 'btn btn-success text-white btn-filter filter-btn active');
            }

            currentFilter = target;
            applyFilterAndSearch();
        });

        $('#searchInput').on('keyup', function() {
            applyFilterAndSearch();
        });

        $(document).ready(function() {
            fetchLiveData();
            setInterval(fetchLiveData, 10000);
        });
    </script>
</body>

</html>
