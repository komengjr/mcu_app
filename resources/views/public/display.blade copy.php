<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Antrian MCU - {{ $mou->company_mou_name }}</title>

    <!-- Bootstrap 5 CSS & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@600;800;900&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-glow: #00f2fe;
            --secondary-glow: #4facfe;
            --accent-gold: #ffb703;
            --accent-pink: #f72585;
            --border-cyan: #00f2fe;
            --border-gold: #ffb703;
            --border-emerald: #10b981;
            --card-bg: rgba(13, 22, 45, 0.88);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html,
        body {
            width: 100vw;
            height: 100vh;
            overflow: hidden;
            background: radial-gradient(circle at 50% 20%, #1e293b 0%, #0f172a 60%, #020617 100%);
            color: #ffffff;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* Banner Autoplay Overlay */
        #audio-banner {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(2, 6, 23, 0.95);
            backdrop-filter: blur(20px);
            z-index: 99999;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            cursor: pointer;
        }

        #audio-banner .pulse-btn {
            background: linear-gradient(135deg, #00f2fe 0%, #ffb703 100%);
            color: #000;
            font-weight: 800;
            padding: 22px 45px;
            border-radius: 50px;
            font-size: 1.6rem;
            box-shadow: 0 0 40px rgba(0, 242, 254, 0.6);
            animation: pulse-button 1.5s infinite;
        }

        @keyframes pulse-button {

            0%,
            100% {
                transform: scale(0.98);
                box-shadow: 0 0 25px rgba(0, 242, 254, 0.5);
            }

            50% {
                transform: scale(1.04);
                box-shadow: 0 0 55px rgba(255, 183, 3, 0.8);
            }
        }

        /* Viewport Container Layout */
        .app-viewport {
            display: flex;
            flex-direction: column;
            height: 100vh;
            padding: 0.85rem;
            gap: 0.75rem;
        }

        /* Header Panel */
        .header-panel {
            background: var(--card-bg);
            border: 2px solid var(--border-cyan);
            border-radius: 18px;
            padding: 0.6rem 1.5rem;
            box-shadow: 0 0 25px rgba(0, 242, 254, 0.3);
            backdrop-filter: blur(15px);
            flex-shrink: 0;
        }

        .company-logo-img {
            max-height: 55px;
            max-width: 180px;
            object-fit: contain;
            filter: drop-shadow(0 0 8px rgba(255, 255, 255, 0.6));
        }

        .main-content {
            flex: 1;
            min-height: 0;
        }

        /* Generic Glowing Card */
        .card-custom {
            background: var(--card-bg);
            border-radius: 20px;
            backdrop-filter: blur(15px);
            height: 100%;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        /* Card Panggilan Aktif (Kiri) */
        .active-call-card {
            background: linear-gradient(160deg, rgba(14, 165, 233, 0.25) 0%, rgba(13, 22, 45, 0.9) 100%);
            border: 3px solid var(--border-cyan);
            box-shadow: 0 0 35px rgba(0, 242, 254, 0.4), inset 0 0 20px rgba(0, 242, 254, 0.2);
            position: relative;
        }

        .pos-badge {
            background: linear-gradient(90deg, #ffb703 0%, #fb8500 100%);
            color: #000;
            font-weight: 800;
            font-size: clamp(1.3rem, 2vw, 2rem);
            padding: 10px 35px;
            border-radius: 50px;
            letter-spacing: 1px;
            box-shadow: 0 0 30px rgba(255, 183, 3, 0.6);
            display: inline-block;
        }

        .queue-number-huge {
            font-family: 'Orbitron', sans-serif;
            font-size: clamp(4.5rem, 12vh, 8.5rem);
            font-weight: 900;
            background: linear-gradient(180deg, #ffffff 20%, #00f2fe 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            filter: drop-shadow(0 0 25px rgba(0, 242, 254, 0.6));
            line-height: 1;
        }

        .patient-name-text {
            font-size: clamp(1.6rem, 3.8vh, 2.6rem);
            font-weight: 800;
            color: #ffffff;
            text-shadow: 0 0 15px rgba(255, 255, 255, 0.8);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Videotron Card (Kanan Atas) */
        .videotron-card {
            border: 2px solid var(--border-gold);
            box-shadow: 0 0 25px rgba(255, 183, 3, 0.3);
            height: 48%;
            position: relative;
            background: #000;
        }

        .videotron-video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Recent Calls Card (Kanan Bawah) */
        .history-card {
            border: 2px solid var(--border-emerald);
            box-shadow: 0 0 25px rgba(16, 185, 129, 0.3);
            height: 50%;
        }

        .clock-digit {
            font-family: 'Orbitron', sans-serif;
            color: var(--primary-glow);
            font-size: clamp(1.5rem, 2.2vw, 2.2rem);
            font-weight: 800;
            text-shadow: 0 0 20px rgba(0, 242, 254, 0.8);
        }

        /* Table Styling */
        .table-custom {
            color: #f8fafc;
            margin-bottom: 0;
        }

        .table-custom th {
            color: #00f2fe;
            border-bottom: 2px solid rgba(0, 242, 254, 0.4);
            text-transform: uppercase;
            font-size: 0.85rem;
            font-weight: 700;
            padding: 8px 10px;
        }

        .table-custom td {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 8px 10px;
            font-size: 1rem;
        }

        .table-scroll-container {
            flex: 1;
            overflow-y: auto;
            min-height: 0;
        }

        /* Footer Running Text */
        .footer-panel {
            background: var(--card-bg);
            border: 2px solid var(--border-gold);
            border-radius: 14px;
            padding: 8px 20px;
            box-shadow: 0 0 20px rgba(255, 183, 3, 0.3);
            flex-shrink: 0;
        }
    </style>
</head>

<body>

    <!-- Overlay Izin Audio Autoplay -->
    <div id="audio-banner">
        <div class="pulse-btn mb-3">
            <i class="fas fa-play-circle me-3"></i> KLIK UNTUK MENGAKTIFKAN SUARA DISPLAY
        </div>
        <p class="text-info fs-5 mb-0">
            <i class="fas fa-info-circle me-1"></i> Klik area mana saja untuk mengaktifkan panggilan suara & audio videotron.
        </p>
    </div>

    <div class="app-viewport">

        <!-- Header Panel dengan Path Logo public/uploads/company_logo/ -->
        <header class="header-panel d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-3">
                <!-- Logo Perusahaan -->
                @if(!empty($mou->master_company_logo))
                <img src="{{ asset('uploads/company_logo/' . $mou->master_company_logo) }}"
                    alt="Logo Company"
                    class="company-logo-img">
                @else
                <div class="bg-primary bg-opacity-30 p-2 rounded-circle border border-info">
                    <i class="fas fa-hospital-user text-info fa-2x"></i>
                </div>
                @endif

                <div>
                    <h2 class="fw-extrabold mb-0 text-white tracking-wide fs-3 text-uppercase" style="text-shadow: 0 0 10px rgba(255,255,255,0.5);">
                        {{ $mou->company_mou_name }}
                    </h2>
                    <span class="text-info fs-6 fw-bold">
                        <i class="fas fa-building me-1"></i>{{ $mou->master_company_name ?? 'Medical Check Up Center' }}
                    </span>
                </div>
            </div>

            <div class="text-end">
                <div class="clock-digit" id="live-clock">00:00:00</div>
                <div class="text-light fw-bold fs-7" id="live-date">-</div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="main-content row g-3 align-items-stretch">

            <!-- Panel Kiri: Panggilan Utama (Dipanggil Sekarang) -->
            <section class="col-lg-7 h-100">
                <div class="card-custom active-call-card p-4 text-center justify-content-between">
                    <div>
                        <span class="badge bg-danger text-white fs-6 px-4 py-2 rounded-pill fw-bold tracking-wider shadow-lg border border-warning">
                            <i class="fas fa-bullhorn me-2 animate__animated animate__infinite animate__heartBeat"></i> DIPANGGIL SEKARANG
                        </span>
                    </div>

                    <div class="my-auto py-2">
                        <div id="display-pos-name" class="pos-badge mb-3">
                            MENUNGGU PANGGILAN...
                        </div>

                        <div id="display-queue-number" class="queue-number-huge my-1">
                            ---
                        </div>
                    </div>

                    <div class="pt-3 border-top border-info border-opacity-50">
                        <div id="display-patient-name" class="patient-name-text mb-1">-</div>
                        <div id="display-patient-nip" class="fs-4 text-info fw-bold">NIP / NIK: -</div>
                    </div>
                </div>
            </section>

            <!-- Panel Kanan: Videotron & History -->
            <section class="col-lg-5 h-100 d-flex flex-column gap-3">

                <!-- Videotron Player -->
                <div class="card-custom videotron-card">
                    <video class="videotron-video" autoplay loop muted playsinline id="videotron-player">
                        <source src="{{ asset('video/company_profile.mp4') }}" type="video/mp4">
                        Browser Anda tidak mendukung tag video.
                    </video>
                </div>

                <!-- History Panggilan -->
                <div class="card-custom history-card p-3 justify-content-between">
                    <div class="d-flex flex-column h-100 overflow-hidden">
                        <h5 class="fw-bold text-emerald mb-2 d-flex align-items-center text-success">
                            <i class="fas fa-history me-2"></i> Panggilan Terakhir
                        </h5>

                        <div class="table-scroll-container">
                            <table class="table table-custom align-middle">
                                <thead>
                                    <tr>
                                        <th width="20%">No</th>
                                        <th>Nama Peserta</th>
                                        <th>Pos / Poli</th>
                                        <th width="25%">Status</th>
                                    </tr>
                                </thead>
                                <tbody id="recent-calls-tbody">
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">Belum ada panggilan antrian.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Rekap Pos / Poli -->
                        <div class="pt-2 border-top border-secondary border-opacity-50 mt-auto">
                            <h6 class="text-uppercase text-warning fw-bold fs-7 mb-1">Rekap Pemeriksaan Hari Ini</h6>
                            <div id="pos-stats-container" class="d-flex flex-wrap gap-1">
                                <span class="badge bg-dark border border-info text-info p-1 fs-7">Memuat data...</span>
                            </div>
                        </div>
                    </div>
                </div>

            </section>

        </main>

        <!-- Running Text Footer -->
        <footer class="footer-panel d-flex align-items-center">
            <marquee class="fs-5 text-warning fw-bold" behavior="scroll" direction="left" scrollamount="7">
                <i class="fas fa-star text-info me-2"></i> Selamat datang di Pelayanan Medical Check Up (MCU). Mohon perhatikan nomor antrian dan nama Anda pada layar monitor. Harap membawa dokumen kelengkapan MCU saat memasuki ruangan pemeriksaan.
            </marquee>
        </footer>

    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const mouCode = "{{ $code }}";
        const cabangCode = "{{ $cabang }}";
        let lastQueueKey = "";
        let audioAllowed = false;

        $('#audio-banner').on('click', function() {
            audioAllowed = true;
            $(this).fadeOut(300);

            // Unmute Videotron Video jika diizinkan
            const videoElem = document.getElementById('videotron-player');
            if (videoElem) {
                videoElem.muted = false;
            }

            let testAudio = new Audio("{{ asset('sound/sound.mp3') }}");
            testAudio.play().then(() => {
                testAudio.pause();
                testAudio.currentTime = 0;
            }).catch(e => console.log("Init audio unlocking:", e));
        });

        function updateClock() {
            const now = new Date();
            $('#live-clock').text(now.toLocaleTimeString('id-ID', {
                hour12: false
            }));
            $('#live-date').text(now.toLocaleDateString('id-ID', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            }));
        }
        setInterval(updateClock, 1000);
        updateClock();

        let systemVoices = [];

        function loadVoices() {
            if ('speechSynthesis' in window) {
                systemVoices = window.speechSynthesis.getVoices();
            }
        }
        loadVoices();
        if ('speechSynthesis' in window) {
            window.speechSynthesis.onvoiceschanged = loadVoices;
        }

        function playCallVoice(nomorAntrian, posName) {
            if (!audioAllowed) {
                $('#audio-banner').fadeIn(200);
                return;
            }

            let bell = new Audio("{{ asset('sound/sound.mp3') }}");
            bell.currentTime = 0;
            let playPromise = bell.play();

            if (playPromise !== undefined) {
                playPromise.then(() => {
                    setTimeout(() => {
                        if ('speechSynthesis' in window) {
                            window.speechSynthesis.cancel();
                            let textPanggil = `Nomor Antrian, ${nomorAntrian}. Harap menuju ke, ${posName}`;
                            let speech = new SpeechSynthesisUtterance(textPanggil);

                            speech.lang = 'id-ID';
                            speech.rate = 0.85;
                            speech.pitch = 1.2;

                            let selectedVoice = systemVoices.find(v =>
                                v.lang.includes('id') && (
                                    v.name.toLowerCase().includes('female') ||
                                    v.name.toLowerCase().includes('gadis') ||
                                    v.name.toLowerCase().includes('indonesia')
                                )
                            );

                            if (!selectedVoice) {
                                selectedVoice = systemVoices.find(v => v.lang.includes('id') || v.lang.includes('id-ID'));
                            }

                            if (selectedVoice) {
                                speech.voice = selectedVoice;
                            }

                            window.speechSynthesis.speak(speech);
                        }
                    }, 1200);
                }).catch(err => {
                    console.warn("Autoplay terhalang sistem:", err);
                    $('#audio-banner').fadeIn(200);
                });
            }
        }

        function fetchAntrianData() {
            $.ajax({
                url: `/v3/display-data/${cabangCode}/${mouCode}`,
                type: 'GET',
                dataType: 'json',
                success: function(res) {
                    if (res.status === 'success') {
                        if (res.current) {
                            $('#display-pos-name').text(res.current.pos);
                            $('#display-queue-number').text(res.current.nomor_antrian);
                            $('#display-patient-name').text(res.current.nama_peserta);
                            $('#display-patient-nip').text('NIP / NIK: ' + res.current.nip);

                            let currentQueueKey = `${res.current.nomor_antrian}_${res.current.pos}_${res.current.panggilan_ke}`;

                            if (lastQueueKey !== currentQueueKey) {
                                lastQueueKey = currentQueueKey;
                                playCallVoice(res.current.nomor_antrian, res.current.pos);
                            }
                        } else {
                            $('#display-pos-name').text('MENUNGGU PANGGILAN...');
                            $('#display-queue-number').text('---');
                            $('#display-patient-name').text('-');
                            $('#display-patient-nip').text('NIP / NIK: -');
                        }

                        let htmlRecent = '';
                        if (res.recent && res.recent.length > 0) {
                            $.each(res.recent, function(i, item) {
                                let badgeStatus = 'bg-secondary';
                                if (item.status_antrian === 'Dipanggil') badgeStatus = 'bg-primary';
                                if (item.status_antrian === 'Sedang Diperiksa') badgeStatus = 'bg-warning text-dark';
                                if (item.status_antrian === 'Selesai') badgeStatus = 'bg-success';

                                htmlRecent += `
                                    <tr>
                                        <td class="fw-bold text-warning fs-6">${item.nomor_antrian}</td>
                                        <td class="text-truncate fw-semibold" style="max-width: 140px;">${item.mou_peserta_name ? item.mou_peserta_name : '-'}</td>
                                        <td><span class="badge bg-dark border border-info text-info px-2 py-1 fs-7">${item.nama_pos_pemeriksaan}</span></td>
                                        <td><span class="badge ${badgeStatus} fs-7">${item.status_antrian}</span></td>
                                    </tr>
                                `;
                            });
                        } else {
                            htmlRecent = '<tr><td colspan="4" class="text-center text-muted py-4">Belum ada aktivitas panggilan.</td></tr>';
                        }
                        $('#recent-calls-tbody').html(htmlRecent);

                        let htmlStats = '';
                        if (res.stats && res.stats.length > 0) {
                            $.each(res.stats, function(i, stat) {
                                htmlStats += `
                                    <span class="badge bg-dark border border-info text-info p-1 fs-7">
                                        ${stat.nama_pos_pemeriksaan}: <strong class="text-white">${stat.total}</strong>
                                    </span>
                                `;
                            });
                        } else {
                            htmlStats = '<span class="text-muted fs-7">Belum ada transaksi hari ini</span>';
                        }
                        $('#pos-stats-container').html(htmlStats);
                    }
                }
            });
        }

        setInterval(fetchAntrianData, 2500);
        fetchAntrianData();
    </script>
</body>

</html>
