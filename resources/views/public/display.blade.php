<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Antrian MCU - {{ $mou->company_mou_name }}</title>

    <!-- Bootstrap 5 CSS & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@600;800;900&family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-glow: #00f2fe;
            --accent-color: #4facfe;
            --bg-dark: #070b19;
            --card-bg: rgba(15, 23, 42, 0.75);
            --border-glow: rgba(56, 189, 248, 0.25);
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
            background: radial-gradient(circle at 50% 10%, #0f172a 0%, #070b19 100%);
            color: #f8fafc;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* Banner Autoplay Activation */
        #audio-banner {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(7, 11, 25, 0.95);
            backdrop-filter: blur(15px);
            z-index: 99999;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        #audio-banner .pulse-btn {
            background: linear-gradient(135deg, #00f2fe 0%, #4facfe 100%);
            color: #000;
            font-weight: 800;
            padding: 20px 40px;
            border-radius: 50px;
            font-size: 1.5rem;
            box-shadow: 0 0 30px rgba(0, 242, 254, 0.5);
            animation: pulse-button 1.5s infinite;
        }

        @keyframes pulse-button {
            0% {
                transform: scale(0.98);
                box-shadow: 0 0 20px rgba(0, 242, 254, 0.4);
            }

            50% {
                transform: scale(1.03);
                box-shadow: 0 0 50px rgba(0, 242, 254, 0.8);
            }

            100% {
                transform: scale(0.98);
                box-shadow: 0 0 20px rgba(0, 242, 254, 0.4);
            }
        }

        /* Main Container Full Screen Grid */
        .app-viewport {
            display: grid;
            grid-template-rows: auto 1fr auto;
            height: 100vh;
            padding: 1.5rem;
            gap: 1.25rem;
        }

        /* Header Style */
        .header-panel {
            background: var(--card-bg);
            border: 1px solid var(--border-glow);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 1rem 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }

        /* Card Container Styles */
        .card-custom {
            background: var(--card-bg);
            border: 1px solid var(--border-glow);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.6);
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        /* Panggilan Aktif Panel */
        .active-call-card {
            background: linear-gradient(145deg, rgba(14, 165, 233, 0.15) 0%, rgba(3, 105, 161, 0.05) 100%);
            border: 2px solid var(--primary-glow);
            box-shadow: inset 0 0 30px rgba(0, 242, 254, 0.1), 0 0 40px rgba(0, 242, 254, 0.25);
            position: relative;
            overflow: hidden;
        }

        .active-call-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(0, 242, 254, 0.08) 0%, transparent 60%);
            pointer-events: none;
        }

        .pos-badge {
            background: linear-gradient(90deg, #f59e0b 0%, #d97706 100%);
            color: #000;
            font-weight: 800;
            font-size: 2rem;
            padding: 10px 45px;
            border-radius: 50px;
            letter-spacing: 1px;
            box-shadow: 0 0 25px rgba(245, 158, 11, 0.4);
            display: inline-block;
        }

        .queue-number-huge {
            font-family: 'Orbitron', sans-serif;
            font-size: 8.5rem;
            font-weight: 900;
            background: linear-gradient(180deg, #ffffff 30%, #38bdf8 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            filter: drop-shadow(0 10px 20px rgba(0, 242, 254, 0.3));
            line-height: 1;
        }

        .patient-name-text {
            font-size: 2.8rem;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: 0.5px;
            text-shadow: 0 4px 15px rgba(0, 0, 0, 0.6);
        }

        /* Clock & Stats */
        .clock-digit {
            font-family: 'Orbitron', sans-serif;
            color: var(--primary-glow);
            font-size: 2.2rem;
            font-weight: 800;
            text-shadow: 0 0 15px rgba(0, 242, 254, 0.5);
        }

        /* Table Styling */
        .table-custom {
            color: #e2e8f0;
            margin-bottom: 0;
        }

        .table-custom th {
            color: #38bdf8;
            border-bottom: 2px solid rgba(56, 189, 248, 0.2);
            text-transform: uppercase;
            font-size: 0.9rem;
            letter-spacing: 1.5px;
            padding: 14px 10px;
        }

        .table-custom td {
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            padding: 16px 10px;
            font-size: 1.1rem;
        }

        /* Marquee Footer */
        .footer-panel {
            background: var(--card-bg);
            border: 1px solid var(--border-glow);
            border-radius: 15px;
            padding: 8px 20px;
            backdrop-filter: blur(10px);
        }
    </style>
</head>

<body>

    <!-- Overlay Pemacu Izin Audio Browser (Wajib Klik Pertama Kali) -->
    <div id="audio-banner">
        <div class="pulse-btn mb-3">
            <i class="fas fa-power-off me-3"></i> KLIK UNTUK MENGAKTIFKAN SUARA LAYAR DISPLAY
        </div>
        <p class="text-info fs-5 mb-0"><i class="fas fa-info-circle me-1"></i> Browser memerlukan izin klik untuk memutar audio sistem otomatis.</p>
    </div>

    <!-- Layout Utama Full Screen -->
    <div class="app-viewport">

        <!-- Top Header Navigation -->
        <header class="header-panel d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <div class="bg-primary bg-opacity-20 p-3 rounded-circle me-3 border border-info">
                    <i class="fas fa-hospital-user text-info fa-2x"></i>
                </div>
                <div>
                    <h2 class="fw-bold mb-0 text-white tracking-wide">{{ $mou->company_mou_name }}</h2>
                    <span class="text-info fs-6"><i class="fas fa-building me-2"></i>{{ $mou->master_company_name ?? 'MCU Project' }}</span>
                </div>
            </div>
            <div class="text-end">
                <div class="clock-digit" id="live-clock">00:00:00</div>
                <div class="text-secondary fw-semibold fs-6" id="live-date">-</div>
            </div>
        </header>

        <!-- Central Content Grid -->
        <main class="row g-4 h-100 align-items-stretch">

            <!-- Panel Kiri: Display Panggilan Utama (65% Width) -->
            <section class="col-lg-7 h-100">
                <div class="card-custom active-call-card p-4 text-center justify-content-between">
                    <div>
                        <span class="badge bg-danger text-white fs-6 px-4 py-2 rounded-pill fw-bold tracking-wider shadow">
                            <i class="fas fa-bullhorn me-2 animate__animated animate__infinite animate__heartBeat"></i> DIPANGGIL SEKARANG
                        </span>
                    </div>

                    <div class="my-auto py-2">
                        <div id="display-pos-name" class="pos-badge mb-4">
                            MENUNGGU PANGGILAN...
                        </div>

                        <div id="display-queue-number" class="queue-number-huge my-1">
                            ---
                        </div>
                    </div>

                    <div class="pt-3 border-top border-info border-opacity-25">
                        <div id="display-patient-name" class="patient-name-text mb-1">-</div>
                        <div id="display-patient-nip" class="fs-4 text-info opacity-75">NIP / NIK: -</div>
                    </div>
                </div>
            </section>

            <!-- Panel Kanan: Riwayat & Rekap (35% Width) -->
            <section class="col-lg-5 h-100">
                <div class="card-custom p-4 justify-content-between">
                    <div class="flex-grow-1">
                        <h4 class="fw-bold text-info mb-3 d-flex align-items-center">
                            <i class="fas fa-history me-2"></i> Panggilan Terakhir
                        </h4>

                        <div class="table-responsive">
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
                                        <td colspan="4" class="text-center text-muted py-5">Belum ada panggilan antrian.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Rekap Pos/Poli -->
                    <div class="pt-3 border-top border-secondary border-opacity-50 mt-3">
                        <h6 class="text-uppercase text-secondary fw-bold fs-7 mb-2">Total Pemeriksaan Hari Ini</h6>
                        <div id="pos-stats-container" class="d-flex flex-wrap gap-2">
                            <span class="badge bg-dark border border-secondary text-light p-2">Memuat rekap...</span>
                        </div>
                    </div>
                </div>
            </section>

        </main>

        <!-- Running Text Footer -->
        <footer class="footer-panel d-flex align-items-center">
            <marquee class="fs-5 text-warning fw-semibold" behavior="scroll" direction="left" scrollamount="6">
                <i class="fas fa-info-circle me-2"></i> Selamat datang di Pelayanan Medical Check Up (MCU). Mohon perhatikan nomor antrian dan nama Anda pada layar monitor. Harap membawa dokumen kelengkapan MCU saat memasuki ruangan pemeriksaan.
            </marquee>
        </footer>

    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const mouCode = "{{ $code }}";
        let lastQueueKey = "";
        let audioAllowed = false;

        // Pemacu Izin Audio Browser
        $('#audio-banner').on('click', function() {
            audioAllowed = true;
            $(this).fadeOut(300);

            // Play & Pause Suara Percobaan untuk Membuka Kunci Browser Audio Context
            let testAudio = new Audio("{{ asset('sound/sound.mp3') }}");
            testAudio.play().then(() => {
                testAudio.pause();
                testAudio.currentTime = 0;
            }).catch(e => console.log("Init audio unlocking:", e));
        });

        // Jam Realtime
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

        // Pemuatan Suara TTS Browser (Edge/Chrome/Safari)
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

        // Fungsi Pemanggilan Suara Bell + Text to Speech
        function playCallVoice(nomorAntrian, posName) {
            if (!audioAllowed) {
                $('#audio-banner').fadeIn(200);
                return;
            }

            // Inisialisasi Audio Bell Bel
            let bell = new Audio("{{ asset('sound/sound.mp3') }}");
            bell.currentTime = 0;

            let playPromise = bell.play();

            if (playPromise !== undefined) {
                playPromise.then(() => {
                    // Setelah Bell selesai/berjalan, panggil TTS setelah jeda 1.2 detik
                    setTimeout(() => {
                        if ('speechSynthesis' in window) {
                            window.speechSynthesis.cancel(); // Hentikan ucapan sebelumnya jika ada

                            let textPanggil = `Nomor Antrian, ${nomorAntrian}. Harap menuju ke, ${posName}`;
                            let speech = new SpeechSynthesisUtterance(textPanggil);

                            speech.lang = 'id-ID';
                            speech.rate = 0.85;
                            speech.pitch = 1.2;

                            // Pencarian Suara Perempuan Indonesia
                            let selectedVoice = systemVoices.find(v =>
                                v.lang.includes('id') && (
                                    v.name.toLowerCase().includes('female') ||
                                    v.name.toLowerCase().includes('gadis') ||
                                    v.name.toLowerCase().includes('wanita') ||
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

        // Fetch Data Antrian Real-time
        function fetchAntrianData() {
            $.ajax({
                url: `/v3/display-data/${mouCode}`,
                type: 'GET',
                dataType: 'json',
                success: function(res) {
                    if (res.status === 'success') {

                        // 1. Update Display Panggilan Aktif
                        if (res.current) {
                            $('#display-pos-name').text(res.current.pos);
                            $('#display-queue-number').text(res.current.nomor_antrian);
                            $('#display-patient-name').text(res.current.nama_peserta);
                            $('#display-patient-nip').text('NIP / NIK: ' + res.current.nip);

                            let currentQueueKey = `${res.current.nomor_antrian}_${res.current.pos}_${res.current.panggilan_ke}`;

                            // Jalankan Suara jika ada pemicu panggilan baru / dipanggil ulang
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

                        // 2. Update Tabel Riwayat Panggilan
                        let htmlRecent = '';
                        if (res.recent && res.recent.length > 0) {
                            $.each(res.recent, function(i, item) {
                                let badgeStatus = 'bg-secondary';
                                if (item.status_antrian === 'Dipanggil') badgeStatus = 'bg-primary';
                                if (item.status_antrian === 'Sedang Diperiksa') badgeStatus = 'bg-warning text-dark';
                                if (item.status_antrian === 'Selesai') badgeStatus = 'bg-success';

                                htmlRecent += `
                                    <tr>
                                        <td class="fw-bold text-warning fs-5">${item.nomor_antrian}</td>
                                        <td class="text-truncate fw-semibold" style="max-width: 180px;">${item.mou_peserta_name ? item.mou_peserta_name : '-'}</td>
                                        <td><span class="badge bg-dark border border-info text-info px-2 py-1">${item.nama_pos_pemeriksaan}</span></td>
                                        <td><span class="badge ${badgeStatus}">${item.status_antrian}</span></td>
                                    </tr>
                                `;
                            });
                        } else {
                            htmlRecent = '<tr><td colspan="4" class="text-center text-muted py-5">Belum ada aktivitas panggilan.</td></tr>';
                        }
                        $('#recent-calls-tbody').html(htmlRecent);

                        // 3. Update Status Rekap Pos
                        let htmlStats = '';
                        if (res.stats && res.stats.length > 0) {
                            $.each(res.stats, function(i, stat) {
                                htmlStats += `
                                    <span class="badge bg-dark border border-info text-info p-2 fs-7">
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

        // Jalankan Fetch Polling 2.5 Detik
        setInterval(fetchAntrianData, 2500);
        fetchAntrianData();
    </script>
</body>

</html>
