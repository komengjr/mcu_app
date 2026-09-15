<!DOCTYPE html>
<html>

<head>
    <title>Laporan Rekap Hasil Pemeriksaan Dokter</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 11px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .table th,
        .table td {
            border: 1px solid #333;
            padding: 6px;
            text-align: left;
        }

        .table th {
            background-color: #f2f2f2;
        }

        .text-center {
            text-align: center;
        }

        .header {
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2 style="margin:0;">REKAP HASIL PEMERIKSAAN DOKTER</h2>
        <p style="margin:3px 0;"><strong>Perusahaan:</strong> {{ $mouInfo->master_company_name ?? '-' }} | <strong>MoU:</strong> {{ $mouInfo->company_mou_name ?? '-' }}</p>
        <p style="margin:3px 0;"><strong>Filter Dokter:</strong> {{ ($dokterPenginput && $dokterPenginput !== 'all') ? $dokterPenginput : 'Semua Dokter' }}</p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th width="4%">No</th>
                <th>NIP / NIK</th>
                <th>Nama Peserta</th>
                <th>Departemen</th>
                <th>Tensi</th>
                <th>Nadi</th>
                <th>Suhu</th>
                <th>SpO2</th>
                <th>BB / TB</th>
                <th>Kesimpulan</th>
                <th>Dokter Penginput</th>
            </tr>
        </thead>
        <tbody>
            @forelse($listPemeriksaan as $index => $row)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $row->mou_peserta_nip ?? '-' }} / {{ $row->mou_peserta_nik ?? '-' }}</td>
                <td>{{ $row->mou_peserta_name }}</td>
                <td>{{ $row->mou_peserta_departemen }}</td>
                <td>{{ $row->tensi ?? '-' }}</td>
                <td>{{ $row->nadi_hr ?? '-' }} bpm</td>
                <td>{{ $row->suhu ?? '-' }} °C</td>
                <td>{{ $row->spo2 ?? '-' }} %</td>
                <td>{{ $row->berat_badan ?? '-' }} kg / {{ $row->tinggi_badan ?? '-' }} cm</td>
                <td><strong>{{ $row->kesimpulan ?? '-' }}</strong></td>
                <td>{{ $row->dokter_penginput ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="11" class="text-center">Data tidak ditemukan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
