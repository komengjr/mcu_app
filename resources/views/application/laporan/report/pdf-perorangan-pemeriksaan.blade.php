<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Hasil Pemeriksaan Medis</title>
    <style>
        /* Pengaturan Kertas A4 & Margin Kertas Pre-Printed (5 cm Top Margin) */
        @page {
            size: A4 portrait;
            margin-top: 5cm;
            margin-bottom: 2cm;
            margin-left: 1.8cm;
            margin-right: 1.8cm;
        }

        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #2b2b2b;
        }

        /* Judul Dokumen Hasil MCU */
        .doc-header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #2d3748;
            padding-bottom: 8px;
        }

        .doc-title {
            margin: 0;
            font-size: 16px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #1a202c;
        }

        .doc-subtitle {
            margin: 3px 0 0 0;
            font-size: 12px;
            font-weight: 600;
            color: #4a5568;
            text-transform: uppercase;
        }

        /* Title Section Laporan */
        .section-header {
            background-color: #edf2f7;
            padding: 5px 8px;
            font-size: 11px;
            font-weight: bold;
            color: #2d3748;
            border-left: 4px solid #3182ce;
            margin-top: 15px;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        /* Tabel Data Pasien */
        .table-info {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .table-info td {
            padding: 5px 6px;
            vertical-align: top;
            font-size: 11px;
        }

        .table-info .label {
            font-weight: 600;
            color: #4a5568;
        }

        /* Tabel Vital Signs Resmi */
        .table-vitals {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .table-vitals th {
            background-color: #2b6cb0;
            color: #ffffff;
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            padding: 7px 5px;
            border: 1px solid #2b6cb0;
            text-align: center;
        }

        .table-vitals td {
            border: 1px solid #cbd5e0;
            padding: 8px 5px;
            text-align: center;
            font-size: 11px;
            color: #2d3748;
        }

        .table-vitals tr:nth-child(even) {
            background-color: #f7fafc;
        }

        /* Highlight Kesimpulan Status Kesehatan */
        .status-box {
            display: inline-block;
            background-color: #ebf8ff;
            border: 1px solid #90cdf4;
            color: #2b6cb0;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
        }

        /* Box Catatan Dokter */
        .box-catatan {
            border: 1px solid #cbd5e0;
            border-radius: 4px;
            padding: 10px;
            background-color: #fafafa;
            min-height: 60px;
            font-size: 11px;
            color: #2d3748;
            margin-top: 5px;
        }

        /* Section Tanda Tangan */
        .footer-ttd {
            width: 100%;
            margin-top: 25px;
        }

        .ttd-box {
            float: right;
            width: 220px;
            text-align: center;
        }

        .ttd-date {
            font-size: 10px;
            color: #4a5568;
            margin-bottom: 5px;
        }

        .ttd-space {
            height: 65px;
        }

        .ttd-name {
            font-weight: bold;
            text-decoration: underline;
            color: #1a202c;
        }

        .clear {
            clear: both;
        }
    </style>
</head>

<body>

    <!-- JUDUL DOKUMEN RESMI -->
    <div class="doc-header">
        <h1 class="doc-title">Hasil Pemeriksaan Kesehatan</h1>
        <div class="doc-subtitle">{{ $detail->master_company_name }}</div>
    </div>

    <!-- I. BIODATA PESERTA -->
    <div class="section-header">I. BIODATA PESERTA MCU</div>
    <table class="table-info">
        <tr>
            <td width="16%" class="label">Nama Pasien</td>
            <td width="2%">:</td>
            <td width="32%"><strong>{{ $detail->mou_peserta_name }}</strong></td>
            <td width="16%" class="label">NIP / NIK</td>
            <td width="2%">:</td>
            <td width="32%">{{ $detail->mou_peserta_nip ?? '-' }} / {{ $detail->mou_peserta_nik ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Departemen</td>
            <td>:</td>
            <td>{{ $detail->mou_peserta_departemen ?? '-' }}</td>
            <td class="label">Jenis Kelamin</td>
            <td>:</td>
            <td>{{ $detail->mou_peserta_jk }}</td>
        </tr>
        <tr>
            <td class="label">Tgl / TTL</td>
            <td>:</td>
            <td>{{ $detail->mou_peserta_ttl }}</td>
            <td class="label">No. Telepon</td>
            <td>:</td>
            <td>{{ $detail->mou_peserta_no_hp ?? '-' }}</td>
        </tr>
    </table>

    <!-- II. TANDA-TANDA VITAL (VITAL SIGNS) -->
    <div class="section-header">II. TANDA-TANDA VITAL (VITAL SIGNS)</div>
    <table class="table-vitals">
        <thead>
            <tr>
                <th width="16%">Tekanan Darah</th>
                <th width="16%">Nadi (HR)</th>
                <th width="16%">Suhu Tubuh</th>
                <th width="16%">SpO2</th>
                <th width="20%">Berat / Tinggi</th>
                <th width="16%">RR (Nafas)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>{{ $detail->tensi ?? '-' }}</strong> <small>mmHg</small></td>
                <td><strong>{{ $detail->nadi_hr ?? '-' }}</strong> <small>bpm</small></td>
                <td><strong>{{ $detail->suhu ?? '-' }}</strong> <small>°C</small></td>
                <td><strong>{{ $detail->spo2 ?? '-' }}</strong> <small>%</small></td>
                <td><strong>{{ $detail->berat_badan ?? '-' }}</strong> <small>kg</small> / <strong>{{ $detail->tinggi_badan ?? '-' }}</strong> <small>cm</small></td>
                <td><strong>{{ $detail->rr_nafas ?? '-' }}</strong> <small>x/m</small></td>
            </tr>
        </tbody>
    </table>

    <!-- III. KESIMPULAN & CATATAN DOKTER -->
    <div class="section-header">III. KESIMPULAN & CATATAN DOKTER</div>

    <div style="margin-bottom: 12px; margin-top: 5px;">
        <span class="label" style="font-size: 11px;">Kesimpulan Akhir:</span>
        <div class="status-box">
            {{ $detail->kesimpulan ?? 'Belum ada kesimpulan' }}
        </div>
    </div>

    <div style="margin-bottom: 4px;" class="label">Catatan & Saran Medis:</div>
    <div class="box-catatan">
        {!! nl2br(e($detail->catatan_dokter ?? 'Tidak ada catatan khusus dari dokter.')) !!}
    </div>

    <!-- AREA TANDA TANGAN -->
    <div class="footer-ttd">
        <div class="ttd-box">
            <div class="ttd-date">
                <!-- Dicetak pada: {{ date('d F Y') }} -->
            </div>
            <div>Dokter Pemeriksa,</div>
            <div class="ttd-space"></div>
            <div class="ttd-name">
                ( {{ $detail->dokter_penginput ?? '..........................................' }} )
            </div>
        </div>
        <div class="clear"></div>
    </div>

</body>

</html>
