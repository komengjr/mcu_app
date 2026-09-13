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
            --beach-bg: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 50%, #7dd3fc 100%);
            --card-glass: rgba(255, 255, 255, 0.90);
            --border-cyan: #0284c7;
            --border-amber: #f59e0b;
            --border-rose: #f43f5e;
            --border-emerald: #10b981;
            --border-indigo: #6366f1;
            --text-dark: #0f172a;
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
            background: var(--beach-bg);
            color: var(--text-dark);
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .app-viewport {
            display: flex;
            flex-direction: column;
            height: 100vh;
            width: 100vw;
            padding: 1rem;
            gap: 0.85rem;
            box-sizing: border-box;
        }

        .header-panel {
            background: var(--card-glass);
            border: 2px solid var(--border-cyan);
            border-radius: 16px;
            padding: 0.5rem 1.25rem;
            box-shadow: 0 6px 18px rgba(2, 132, 199, 0.12);
            backdrop-filter: blur(10px);
            flex-shrink: 0;
        }

        .company-logo-img {
            max-height: 48px;
            max-width: 170px;
            object-fit: contain;
        }

        .main-content {
            flex: 1;
            min-height: 0;
            display: flex;
            gap: 0.85rem;
            width: 100%;
            margin: 0;
        }

        .col-info-absensi {
            flex: 0 0 calc(28% - 0.425rem);
            max-width: calc(28% - 0.425rem);
            height: 100%;
        }

        .col-queue-system {
            flex: 0 0 calc(72% - 0.425rem);
            max-width: calc(72% - 0.425rem);
            height: 100%;
            display: flex;
            flex-direction: column;
            gap: 0.85rem;
        }

        .card-custom {
            background: var(--card-glass);
            border-radius: 18px;
            backdrop-filter: blur(12px);
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.06);
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .info-card {
            border: 3px solid var(--border-cyan);
            height: 100%;
            background: #ffffff;
            padding: 1rem;
            overflow-y: auto;
        }

        .qr-container {
            background: #ffffff;
            border: 2px dashed var(--border-cyan);
            border-radius: 14px;
            padding: 0.75rem;
            text-align: center;
        }

        .qr-image {
            width: 130px;
            height: 130px;
            object-fit: contain;
        }

        .step-list {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .step-item {
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
            background: rgba(224, 242, 254, 0.4);
            border-left: 3px solid var(--border-cyan);
            padding: 6px 10px;
            border-radius: 0 8px 8px 0;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .step-number {
            background: var(--border-cyan);
            color: #ffffff;
            font-weight: 800;
            border-radius: 50%;
            min-width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.68rem;
            margin-top: 1px;
        }

        /* Container 2 Outlet Pendaftaran */
        .outlets-container {
            display: flex;
            gap: 0.85rem;
            flex: 1.15;
            min-height: 0;
        }

        .active-call-card {
            background: linear-gradient(135deg, #ffffff 0%, #f0f9ff 100%);
            border: 3px solid var(--border-rose);
            box-shadow: 0 8px 25px rgba(244, 63, 94, 0.12);
            flex: 1;
            min-height: 0;
        }

        .pos-badge {
            background: linear-gradient(90deg, #0284c7 0%, #0369a1 100%);
            color: #ffffff;
            font-weight: 800;
            font-size: clamp(0.9rem, 1.1vw, 1.2rem);
            padding: 5px 18px;
            border-radius: 50px;
            box-shadow: 0 4px 12px rgba(2, 132, 199, 0.3);
            display: inline-block;
        }

        .queue-number-huge {
            font-family: 'Orbitron', sans-serif;
            font-size: clamp(2.5rem, 5.5vh, 4.5rem);
            font-weight: 900;
            color: #0284c7;
            text-shadow: 2px 2px 0px #bae6fd;
            line-height: 1;
        }

        .patient-name-text {
            font-size: clamp(1rem, 1.8vh, 1.4rem);
            font-weight: 800;
            color: #0f172a;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .tables-split-container {
            flex: 1;
            min-height: 0;
            display: flex;
            gap: 0.85rem;
        }

        .history-card {
            border: 3px solid var(--border-emerald);
            flex: 1;
            min-height: 0;
        }

        .waiting-card {
            border: 3px solid var(--border-indigo);
            flex: 1;
            min-height: 0;
        }

        .clock-digit {
            font-family: 'Orbitron', sans-serif;
            color: #0284c7;
            font-size: clamp(1.4rem, 1.8vw, 2rem);
            font-weight: 800;
        }

        .table-custom {
            color: #0f172a;
            margin-bottom: 0;
        }

        .table-custom th {
            color: #0284c7;
            background-color: rgba(186, 230, 253, 0.5);
            border-bottom: 2px solid #0284c7;
            text-transform: uppercase;
            font-size: 0.75rem;
            font-weight: 800;
            padding: 6px 10px;
        }

        .table-custom td {
            border-bottom: 1px solid #e2e8f0;
            padding: 6px 10px;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .table-scroll-container {
            flex: 1;
            overflow-y: auto;
            min-height: 0;
        }

        .footer-panel {
            background: var(--card-glass);
            border: 2px solid var(--border-amber);
            border-radius: 12px;
            padding: 6px 16px;
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.12);
            flex-shrink: 0;
        }

        #audio-banner {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(12px);
            z-index: 99999;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            cursor: pointer;
        }

        #audio-banner .pulse-btn {
            background: linear-gradient(135deg, #38bdf8 0%, #f59e0b 100%);
            color: #ffffff;
            font-weight: 800;
            padding: 18px 36px;
            border-radius: 50px;
            font-size: 1.4rem;
            box-shadow: 0 10px 25px rgba(56, 189, 248, 0.4);
            animation: pulse-button 1.5s infinite;
        }

        @keyframes pulse-button {

            0%,
            100% {
                transform: scale(0.98);
            }

            50% {
                transform: scale(1.03);
            }
        }
    </style>
</head>

<body>

    <!-- Audio Autoplay Banner -->
    <div id="audio-banner">
        <div class="pulse-btn mb-3">
            <i class="fas fa-play-circle me-2"></i> KLIK UNTUK MENGAKTIFKAN DISPLAY
        </div>
        <p class="text-white fs-5 mb-0">
            <i class="fas fa-info-circle me-1"></i> Klik area layar untuk mengaktifkan suara pemanggilan.
        </p>
    </div>

    <div class="app-viewport">

        <!-- Header Panel -->
        <header class="header-panel d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-3">
                @if(!empty($mou->master_company_logo))
                <img src="{{ asset('uploads/company_logo/' . $mou->master_company_logo) }}" alt="Logo Company" class="company-logo-img">
                @else
                <div class="bg-primary bg-opacity-10 p-2 rounded-circle border border-info">
                    <i class="fas fa-hospital-user text-primary fa-2x"></i>
                </div>
                @endif

                <div>
                    <h2 class="fw-extrabold mb-0 text-dark tracking-wide fs-4 text-uppercase">
                        {{ $mou->company_mou_name }}
                    </h2>
                    <span class="text-primary fs-6 fw-bold">
                        <i class="fas fa-building me-1"></i>{{ $mou->master_company_name ?? 'Medical Check Up Center' }}
                    </span>
                </div>
            </div>

            <div class="text-end">
                <div class="clock-digit" id="live-clock">00:00:00</div>
                <div class="text-secondary fw-bold fs-7" id="live-date">-</div>
            </div>
        </header>

        <!-- Main Body Grid -->
        <main class="main-content">

            <!-- BAGIAN KIRI: QR CODE & PANDUAN PENGGUNAAN -->
            <section class="col-info-absensi">
                <div class="card-custom info-card">
                    <div class="qr-container mb-2">
                        <span class="badge bg-primary px-3 py-1 mb-2 fw-bold text-uppercase">
                            <i class="fas fa-qrcode me-1"></i> Scan Absensi MCU
                        </span>
                        <div class="d-flex justify-content-center my-1">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode(url('absensi/data-kehadiran-mcu/perusahaan/' . $tokenCode)) }}"
                                alt="QR Absensi MCU"
                                class="qr-image shadow-sm border rounded">
                        </div>
                        <small class="text-muted d-block fw-bold mt-1" style="font-size: 0.7rem;">
                            Scan QR di atas untuk absensi mandiri
                        </small>
                    </div>

                    <div class="mt-1">
                        <h6 class="fw-bold text-primary mb-2 text-uppercase d-flex align-items-center" style="font-size: 0.8rem;">
                            <i class="fas fa-list-ol me-2"></i> Panduan Alur Peserta:
                        </h6>

                        <div class="step-list">
                            <div class="step-item">
                                <span class="step-number">1</span>
                                <div>Scan QR Code absensi menggunakan HP Anda.</div>
                            </div>
                            <div class="step-item">
                                <span class="step-number">2</span>
                                <div>Halaman project perusahaan akan muncul di layar HP.</div>
                            </div>
                            <div class="step-item">
                                <span class="step-number">3</span>
                                <div>Pilih dan masukkan <strong>Cabang Tujuan</strong> lokasi MCU.</div>
                            </div>
                            <div class="step-item">
                                <span class="step-number">4</span>
                                <div>Masukkan <strong>NIP Pegawai</strong> yang telah terdaftar.</div>
                            </div>
                            <div class="step-item">
                                <span class="step-number">5</span>
                                <div>Lakukan pengecekan data diri, jika benar klik lanjutkan.</div>
                            </div>
                            <div class="step-item">
                                <span class="step-number">6</span>
                                <div>Lakukan <strong>Tanda Tangan Online</strong> untuk konfirmasi kehadiran.</div>
                            </div>
                            <div class="step-item">
                                <span class="step-number">7</span>
                                <div>Setelah di-submit, Anda akan mendapatkan <strong>Nomor Antrian</strong>.</div>
                            </div>
                            <div class="step-item">
                                <span class="step-number">8</span>
                                <div>Tunggu petugas memanggil nomor antrian Anda di layar display.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- BAGIAN KANAN: DISPLAY ANTRIAN (2 OUTLET) & LIST -->
            <section class="col-queue-system">

                <!-- DUA KOTAK OUTLET PENDAFTARAN -->
                <div class="outlets-container">

                    <!-- OUTLET 1: PENDAFTARAN 1 -->
                    <div class="card-custom active-call-card p-3 text-center justify-content-between">
                        <div>
                            <span class="badge bg-danger text-white fs-7 px-3 py-1 rounded-pill fw-bold shadow-sm">
                                <i class="fas fa-bullhorn me-1"></i> DIPANGGIL SEKARANG
                            </span>
                        </div>

                        <div class="my-auto py-1">
                            <div class="pos-badge mb-2">
                                PENDAFTARAN 1
                            </div>

                            <div id="pos1-queue-number" class="queue-number-huge my-1">
                                ---
                            </div>
                        </div>

                        <div class="pt-2 border-top border-secondary border-opacity-25">
                            <div id="pos1-patient-name" class="patient-name-text mb-1">-</div>
                            <div id="pos1-patient-nip" class="fs-7 text-primary fw-bold">NIP / NIK: -</div>
                        </div>
                    </div>

                    <!-- OUTLET 2: PENDAFTARAN 2 -->
                    <div class="card-custom active-call-card p-3 text-center justify-content-between">
                        <div>
                            <span class="badge bg-danger text-white fs-7 px-3 py-1 rounded-pill fw-bold shadow-sm">
                                <i class="fas fa-bullhorn me-1"></i> DIPANGGIL SEKARANG
                            </span>
                        </div>

                        <div class="my-auto py-1">
                            <div class="pos-badge mb-2">
                                PENDAFTARAN 2
                            </div>

                            <div id="pos2-queue-number" class="queue-number-huge my-1">
                                ---
                            </div>
                        </div>

                        <div class="pt-2 border-top border-secondary border-opacity-25">
                            <div id="pos2-patient-name" class="patient-name-text mb-1">-</div>
                            <div id="pos2-patient-nip" class="fs-7 text-primary fw-bold">NIP / NIK: -</div>
                        </div>
                    </div>

                </div>

                <!-- TABEL SPLIT: PANGGILAN TERAKHIR & MENUNGGU -->
                <div class="tables-split-container">

                    <!-- Table Riwayat Dipanggil (Kiri) -->
                    <div class="card-custom history-card p-3">
                        <h6 class="fw-bold text-success mb-2 d-flex align-items-center">
                            <i class="fas fa-check-circle me-2"></i> Panggilan Terakhir
                        </h6>
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
                                        <td colspan="4" class="text-center text-muted py-3">Belum ada pemanggilan.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Table Antrian Menunggu (Kanan) -->
                    <div class="card-custom waiting-card p-3">
                        <h6 class="fw-bold text-indigo mb-2 d-flex align-items-center" style="color: #6366f1;">
                            <i class="fas fa-user-clock me-2"></i> Antrian Menunggu
                        </h6>
                        <div class="table-scroll-container">
                            <table class="table table-custom align-middle">
                                <thead>
                                    <tr>
                                        <th width="25%">No</th>
                                        <th>Nama Peserta</th>
                                        <th>Departemen</th>
                                    </tr>
                                </thead>
                                <tbody id="waiting-calls-tbody">
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-3">Tidak ada antrian menunggu.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

            </section>

        </main>

        <!-- Footer Running Text -->
        <footer class="footer-panel d-flex align-items-center">
            <marquee class="fs-6 text-dark fw-bold" behavior="scroll" direction="left" scrollamount="6">
                <i class="fas fa-info-circle text-primary me-2"></i> Selamat datang di Pelayanan Medical Check Up (MCU). Silakan melakukan scan QR Code di sebelah kiri untuk pendaftaran absensi mandiri, pengisian tanda tangan, dan pengambilan nomor antrian. Harap perhatikan panggilan nomor antrian Anda di layar display.
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

        // Unlocking Audio User Interaction
        $('#audio-banner').on('click', function() {
            audioAllowed = true;
            $(this).fadeOut(300);

            let testAudio = new Audio("{{ asset('sound/sound.mp3') }}");
            testAudio.play().then(() => {
                testAudio.pause();
                testAudio.currentTime = 0;
            }).catch(e => console.log("Init audio unlocking:", e));
        });

        // Live Clock Function
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

        // System TTS Voice Init
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

        // Panggilan Suara
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

        // Fetch Data Antrian Realtime via AJAX
        function fetchAntrianData() {
            $.ajax({
                url: `/v3/display-data/${cabangCode}/${mouCode}`,
                type: 'GET',
                dataType: 'json',
                success: function(res) {
                    if (res.status === 'success') {

                        // Update Pendaftaran 1 (Poli/Pos 1)
                        if (res.pos1) {
                            $('#pos1-queue-number').text(res.pos1.nomor_antrian);
                            $('#pos1-patient-name').text(res.pos1.nama_peserta);
                            $('#pos1-patient-nip').text('NIP / NIK: ' + res.pos1.nip);
                        } else {
                            $('#pos1-queue-number').text('---');
                            $('#pos1-patient-name').text('-');
                            $('#pos1-patient-nip').text('NIP / NIK: -');
                        }

                        // Update Pendaftaran 2 (Poli/Pos 2)
                        if (res.pos2) {
                            $('#pos2-queue-number').text(res.pos2.nomor_antrian);
                            $('#pos2-patient-name').text(res.pos2.nama_peserta);
                            $('#pos2-patient-nip').text('NIP / NIK: ' + res.pos2.nip);
                        } else {
                            $('#pos2-queue-number').text('---');
                            $('#pos2-patient-name').text('-');
                            $('#pos2-patient-nip').text('NIP / NIK: -');
                        }

                        // Trigger Suara jika ada Panggilan Terbaru dari salah satu pos
                        if (res.current) {
                            let currentQueueKey = `${res.current.nomor_antrian}_${res.current.pos}_${res.current.panggilan_ke}`;
                            if (lastQueueKey !== currentQueueKey) {
                                lastQueueKey = currentQueueKey;
                                playCallVoice(res.current.nomor_antrian, res.current.pos);
                            }
                        }

                        // List Panggilan Terakhir
                        let htmlRecent = '';
                        if (res.recent && res.recent.length > 0) {
                            $.each(res.recent, function(i, item) {
                                let badgeStatus = 'bg-secondary';
                                if (item.status_antrian === 'Dipanggil') badgeStatus = 'bg-primary';
                                if (item.status_antrian === 'Sedang Diperiksa') badgeStatus = 'bg-warning text-dark';
                                if (item.status_antrian === 'Selesai') badgeStatus = 'bg-success';

                                htmlRecent += `
                                    <tr>
                                        <td class="fw-bold text-primary">${item.nomor_antrian}</td>
                                        <td class="text-truncate fw-semibold" style="max-width: 120px;">${item.mou_peserta_name ? item.mou_peserta_name : '-'}</td>
                                        <td><span class="badge bg-light text-dark border border-info px-2 py-1 fs-7">${item.nama_pos_pemeriksaan}</span></td>
                                        <td><span class="badge ${badgeStatus} fs-7">${item.status_antrian}</span></td>
                                    </tr>
                                `;
                            });
                        } else {
                            htmlRecent = '<tr><td colspan="4" class="text-center text-muted py-3">Belum ada pemanggilan.</td></tr>';
                        }
                        $('#recent-calls-tbody').html(htmlRecent);

                        // List Antrian Menunggu
                        let htmlWaiting = '';
                        if (res.waiting && res.waiting.length > 0) {
                            $.each(res.waiting, function(i, item) {
                                htmlWaiting += `
                                    <tr>
                                        <td class="fw-bold text-indigo" style="color: #6366f1;">${item.nomor_antrian}</td>
                                        <td class="text-truncate fw-semibold" style="max-width: 130px;">${item.mou_peserta_name ? item.mou_peserta_name : '-'}</td>
                                        <td class="text-truncate" style="max-width: 100px;">${item.mou_peserta_departemen ? item.mou_peserta_departemen : '-'}</td>
                                    </tr>
                                `;
                            });
                        } else {
                            htmlWaiting = '<tr><td colspan="3" class="text-center text-muted py-3">Tidak ada antrian menunggu.</td></tr>';
                        }
                        $('#waiting-calls-tbody').html(htmlWaiting);
                    }
                }
            });
        }

        setInterval(fetchAntrianData, 2500);
        fetchAntrianData();
    </script>
</body>

</html>
