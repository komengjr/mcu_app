<!DOCTYPE html>
<html>

<head>
    <title>Hasil Pemeriksaan Medis</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            line-height: 1.5;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .table-info,
        .table-vitals {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .table-info td {
            padding: 4px 8px;
            vertical-align: top;
        }

        .table-vitals th,
        .table-vitals td {
            border: 1px solid #333;
            padding: 8px;
            text-align: center;
        }

        .table-vitals th {
            background-color: #f2f2f2;
        }

        .box-catatan {
            border: 1px solid #ccc;
            padding: 10px;
            background-color: #fafafa;
            min-height: 80px;
        }

        .ttd-container {
            margin-top: 40px;
            float: right;
            width: 250px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2 style="margin:0;">HASIL PEMERIKSAAN KESEHATAN (MCU)</h2>
        <p style="margin:2px 0;">{{ $detail->master_company_name }}</p>
    </div>

    <h4>I. BIODATA PESERTA</h4>
    <table class="table-info">
        <tr>
            <td width="20%"><strong>Nama Pasien</strong></td>
            <td width="2%">:</td>
            <td width="28%">{{ $detail->mou_peserta_name }}</td>
            <td width="20%"><strong>NIP / NIK</strong></td>
            <td width="2%">:</td>
            <td width="28%">{{ $detail->mou_peserta_nip }} / {{ $detail->mou_peserta_nik }}</td>
        </tr>
        <tr>
            <td><strong>Departemen</strong></td>
            <td>:</td>
            <td>{{ $detail->mou_peserta_departemen }}</td>
            <td><strong>Jenis Kelamin</strong></td>
            <td>:</td>
            <td>{{ $detail->mou_peserta_jk }}</td>
        </tr>
        <tr>
            <td><strong>Tgl / TTL</strong></td>
            <td>:</td>
            <td>{{ $detail->mou_peserta_ttl }}</td>
            <td><strong>No HP</strong></td>
            <td>:</td>
            <td>{{ $detail->mou_peserta_no_hp ?? '-' }}</td>
        </tr>
    </table>

    <h4 style="margin-top:20px;">II. TANDA-TANDA VITAL (VITAL SIGNS)</h4>
    <table class="table-vitals">
        <thead>
            <tr>
                <th>Tekanan Darah</th>
                <th>Nadi (HR)</th>
                <th>Suhu</th>
                <th>SpO2</th>
                <th>Berat / Tinggi</th>
                <th>RR (Nafas)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $detail->tensi ?? '-' }} mmHg</td>
                <td>{{ $detail->nadi_hr ?? '-' }} bpm</td>
                <td>{{ $detail->suhu ?? '-' }} °C</td>
                <td>{{ $detail->spo2 ?? '-' }} %</td>
                <td>{{ $detail->berat_badan ?? '-' }} kg / {{ $detail->tinggi_badan ?? '-' }} cm</td>
                <td>{{ $detail->rr_nafas ?? '-' }} x/menit</td>
            </tr>
        </tbody>
    </table>

    <h4 style="margin-top:20px;">III. KESIMPULAN & CATATAN DOKTER</h4>
    <p><strong>Kesimpulan Status Kesehatan:</strong> <span style="font-size: 14px; font-weight: bold;">{{ $detail->kesimpulan ?? '-' }}</span></p>

    <p><strong>Catatan / Saran Dokter:</strong></p>
    <div class="box-catatan">
        {!! nl2br(e($detail->catatan_dokter ?? 'Tidak ada catatan khusus.')) !!}
    </div>

    <div class="ttd-container">
        <p>Dokter Pemeriksa / Penginput,</p>
        <br><br><br>
        <p><strong>( {{ $detail->dokter_penginput ?? '..........................................' }} )</strong></p>
    </div>
</body>

</html>
