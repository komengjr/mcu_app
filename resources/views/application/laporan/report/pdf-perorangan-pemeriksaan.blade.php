<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Laporan Hasil Pemeriksaan Kesehatan (MCU)</title>
    <style>
        /* Pengaturan Halaman A4 Presisi */
        @page {
            size: A4 portrait;
            margin: 35px 40px 40px 40px;
            /* Margin kertas luar */
        }

        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 11px;
            color: #2b2b2b;
            line-height: 1.5;
        }

        /* ================= 1. KOP HEADER RESMI ================= */
        .kop-container {
            width: 100%;
            margin-bottom: 25px;
            /* Jarak antara Kop Header ke Garis Pembatas/Title */
        }

        .kop-header {
            width: 100%;
            border-collapse: collapse;
        }

        .kop-header td {
            vertical-align: middle;
        }

        .logo-container {
            width: 35%;
            text-align: left;
        }

        .logo-pramita {
            max-height: 60px;
            width: auto;
        }

        .company-container {
            width: 65%;
            text-align: right;
        }

        .clinic-name {
            font-size: 15px;
            font-weight: bold;
            color: #0b3c5d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0;
        }

        .clinic-sub {
            font-size: 9.5px;
            color: #555;
            margin-top: 3px;
        }

        .divider-line {
            border-top: 2px solid #0b3c5d;
            border-bottom: 1px solid #3282b8;
            height: 2px;
            margin-top: 12px;
        }

        /* ================= 2. TITLE BOX (JUDUL DOKUMEN) ================= */
        .title-wrapper {
            margin-bottom: 25px;
            /* Jarak dari Judul Laporan ke Body Konten Utama */
        }

        .report-title-box {
            background-color: #0b3c5d;
            color: #ffffff;
            text-align: center;
            padding: 8px 0;
            border-radius: 3px;
        }

        .report-title {
            font-size: 13px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            margin: 0;
        }

        /* ================= 3. BODY KONTEN & SEKSI ================= */
        .section-block {
            margin-bottom: 20px;
            /* Jarak antar-seksi dalam body */
        }

        .section-header {
            background-color: #f0f4f8;
            border-left: 4px solid #0b3c5d;
            padding: 5px 10px;
            font-weight: bold;
            font-size: 11px;
            color: #0b3c5d;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        /* TABEL BIODATA */
        .table-info {
            width: 100%;
            border-collapse: collapse;
            background-color: #fcfcfc;
            border: 1px solid #e2e8f0;
            border-radius: 3px;
        }

        .table-info td {
            padding: 6px 10px;
            vertical-align: top;
            font-size: 10.5px;
        }

        .bg-label {
            background-color: #f8fafc;
            font-weight: bold;
            color: #475569;
            width: 18%;
        }

        /* TABEL VITAL SIGNS */
        .table-vitals {
            width: 100%;
            border-collapse: collapse;
        }

        .table-vitals th {
            background-color: #1e3d59;
            color: #ffffff;
            font-weight: bold;
            font-size: 10px;
            text-transform: uppercase;
            padding: 8px 5px;
            border: 1px solid #1e3d59;
            text-align: center;
        }

        .table-vitals td {
            border: 1px solid #cbd5e1;
            padding: 8px 5px;
            text-align: center;
            font-size: 10.5px;
        }

        /* CATATAN & KESIMPULAN */
        .badge-kesimpulan {
            display: inline-block;
            padding: 4px 12px;
            background-color: #e0f2fe;
            color: #0369a1;
            border: 1px solid #bae6fd;
            font-weight: bold;
            font-size: 11px;
            border-radius: 3px;
        }

        .box-catatan {
            border: 1px solid #cbd5e1;
            border-radius: 3px;
            padding: 10px 12px;
            background-color: #fafafa;
            min-height: 70px;
            font-size: 10.5px;
            color: #334155;
            line-height: 1.5;
        }

        /* ================= 4. TANDA TANGAN & FOOTER ================= */
        .footer-section {
            margin-top: 30px;
        }

        .ttd-box {
            text-align: center;
            width: 230px;
            float: right;
        }

        .ttd-title {
            font-size: 10.5px;
            color: #475569;
            margin-bottom: 55px;
            /* Ruang untuk tanda tangan fisik/stempel */
        }

        .ttd-name {
            font-size: 11px;
            font-weight: bold;
            color: #0f172a;
            border-bottom: 1px solid #0f172a;
            padding-bottom: 2px;
        }

        .doc-footer {
            margin-top: 45px;
            border-top: 1px dashed #cbd5e1;
            padding-top: 8px;
            font-size: 8.5px;
            color: #94a3b8;
            text-align: center;
        }

        .clear {
            clear: both;
        }
    </style>
</head>

<body>

    <!-- KOP HEADER -->
    <div class="kop-container">
        <table class="kop-header">
            <tr>
                <td class="logo-container">
                    <img src="{{ public_path('img/pram.png') }}" class="logo-pramita" alt="Logo Pramita">
                </td>
                <td class="company-container">
                    <div class="clinic-name">LABORATORIUM & KLINIK PRAMITA</div>
                    <div class="clinic-sub">Layanan Pemeriksaan Kesehatan & Medical Check Up</div>
                    <div class="clinic-sub">Perusahaan / Instansi: <strong>{{ $detail->master_company_name }}</strong></div>
                </td>
            </tr>
        </table>
        <div class="divider-line"></div>
    </div>

    <!-- JUDUL DOKUMEN (Dengan Jarak Atas & Bawah) -->
    <div class="title-wrapper">
        <div class="report-title-box">
            <h2 class="report-title">LAPORAN HASIL PEMERIKSAAN KESEHATAN (MCU)</h2>
        </div>
    </div>

    <!-- BODY KONTEN UTAMA -->

    <!-- I. BIODATA PESERTA -->
    <div class="section-block">
        <div class="section-header">I. BIODATA PESERTA</div>
        <table class="table-info">
            <tr>
                <td class="bg-label">Nama Pasien</td>
                <td width="1%">:</td>
                <td width="31%"><strong>{{ $detail->mou_peserta_name }}</strong></td>
                <td class="bg-label">NIP / NIK</td>
                <td width="1%">:</td>
                <td width="31%">{{ $detail->mou_peserta_nip ?? '-' }} / {{ $detail->mou_peserta_nik ?? '-' }}</td>
            </tr>
            <tr>
                <td class="bg-label">Departemen</td>
                <td>:</td>
                <td>{{ $detail->mou_peserta_departemen ?? '-' }}</td>
                <!-- <td class="bg-label">Jenis Kelamin</td>
                <td>:</td>
                <td>{{ $detail->mou_peserta_jk ?? '-' }}</td> -->
            </tr>
            <tr>
                <!-- <td class="bg-label">Tgl / Tempat Lahir</td>
                <td>:</td>
                <td>{{ $detail->mou_peserta_ttl ?? '-' }}</td> -->
                <td class="bg-label">No. Telepon / HP</td>
                <td>:</td>
                <td>{{ $detail->mou_peserta_no_hp ?? '-' }}</td>
            </tr>
        </table>
    </div>

    <!-- II. TANDA-TANDA VITAL (VITAL SIGNS) -->
    <div class="section-block">
        <div class="section-header">II. TANDA-TANDA VITAL (VITAL SIGNS)</div>
        <table class="table-vitals">
            <thead>
                <tr>
                    <th width="17%">Tekanan Darah</th>
                    <th width="16%">Nadi (HR)</th>
                    <th width="15%">Suhu Body</th>
                    <th width="15%">SpO2</th>
                    <th width="22%">Berat / Tinggi Badan</th>
                    <th width="15%">Laju Nafas (RR)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>{{ $detail->tensi ?? '-' }}</strong> mmHg</td>
                    <td><strong>{{ $detail->nadi_hr ?? '-' }}</strong> bpm</td>
                    <td><strong>{{ $detail->suhu ?? '-' }}</strong> °C</td>
                    <td><strong>{{ $detail->spo2 ?? '-' }}</strong> %</td>
                    <td><strong>{{ $detail->berat_badan ?? '-' }}</strong> kg / <strong>{{ $detail->tinggi_badan ?? '-' }}</strong> cm</td>
                    <td><strong>{{ $detail->rr_nafas ?? '-' }}</strong> x/m</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- III. KESIMPULAN & CATATAN DOKTER -->
    <div class="section-block">
        <div class="section-header">III. KESIMPULAN & CATATAN DOKTER</div>
        <table style="width: 100%; margin-bottom: 10px;">
            <tr>
                <td width="22%" style="font-size: 10.5px; font-weight: bold; color: #1e293b;">Kesimpulan Status:</td>
                <td width="78%">
                    <span class="badge-kesimpulan">{{ $detail->kesimpulan ?? 'DALAM BATAS NORMAL' }}</span>
                </td>
            </tr>
        </table>

        <div style="font-size: 10.5px; font-weight: bold; color: #1e293b; margin-bottom: 6px;">Catatan & Rekomendasi Dokter:</div>
        <div class="box-catatan">
            {!! nl2br(e($detail->catatan_dokter ?? 'Tidak ada catatan khusus.')) !!}
        </div>
    </div>

    <!-- TANDA TANGAN & FOOTER -->
    <div class="footer-section">
        <div class="ttd-box">
            <div class="ttd-title">Dokter Pemeriksa / Evaluator,</div>
            <div class="ttd-name">{{ $detail->dokter_penginput ?? '..........................................' }}</div>
            <!-- <div style="font-size: 8.5px; color: #64748b; margin-top: 2px;">SIP / NIK Dokter</div> -->
        </div>

        <div class="clear"></div>

        <div class="doc-footer">
            Dokumen ini diterbitkan secara elektronik dan merupakan hasil rekam medis resmi MCU. <br>
            <i>Pramita Medical Report &copy; {{ date('Y') }}</i>
        </div>
    </div>

</body>

</html>
