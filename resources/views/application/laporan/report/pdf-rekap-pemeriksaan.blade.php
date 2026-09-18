<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Laporan Rekap Hasil Pemeriksaan Dokter</title>
    <style>
        /* Menggunakan A4 Landscape agar tabel muat dengan presisi */
        @page {
            size: A4 landscape;
            margin: 30px 35px 40px 35px;
        }

        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 9.5px;
            color: #2b2b2b;
            line-height: 1.4;
        }

        /* ================= 1. KOP HEADER RESMI ================= */
        .kop-container {
            width: 100%;
            margin-bottom: 20px;
        }

        .kop-header {
            width: 100%;
            border-collapse: collapse;
        }

        .kop-header td {
            vertical-align: middle;
        }

        .logo-container {
            width: 25%;
            text-align: left;
        }

        .logo-pramita {
            max-height: 55px;
            width: auto;
        }

        .company-container {
            width: 75%;
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
            font-size: 9px;
            color: #555;
            margin-top: 2px;
        }

        .divider-line {
            border-top: 2px solid #0b3c5d;
            border-bottom: 1px solid #3282b8;
            height: 2px;
            margin-top: 10px;
        }

        /* ================= 2. TITLE & FILTER INFO ================= */
        .title-wrapper {
            margin-bottom: 15px;
        }

        .report-title-box {
            background-color: #0b3c5d;
            color: #ffffff;
            text-align: center;
            padding: 6px 0;
            border-radius: 3px;
            margin-bottom: 12px;
        }

        .report-title {
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 0;
        }

        .filter-table {
            width: 100%;
            border-collapse: collapse;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 3px;
            margin-bottom: 15px;
        }

        .filter-table td {
            padding: 5px 10px;
            font-size: 9.5px;
        }

        .bg-label {
            background-color: #f1f5f9;
            font-weight: bold;
            color: #475569;
            width: 12%;
        }

        /* ================= 3. TABEL DATA REKAP ================= */
        .table-rekap {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }

        .table-rekap th {
            background-color: #1e3d59;
            color: #ffffff;
            font-weight: bold;
            font-size: 9px;
            text-transform: uppercase;
            padding: 7px 5px;
            border: 1px solid #1e3d59;
            text-align: center;
        }

        .table-rekap td {
            border: 1px solid #cbd5e1;
            padding: 6px 5px;
            font-size: 9px;
            vertical-align: middle;
        }

        .table-rekap tbody tr:nth-child(even) {
            background-color: #f8fafc;
        }

        .text-center {
            text-align: center;
        }

        .badge-kesimpulan {
            display: inline-block;
            padding: 2px 6px;
            background-color: #e0f2fe;
            color: #0369a1;
            font-weight: bold;
            border-radius: 2px;
            font-size: 8.5px;
        }

        /* ================= 4. FOOTER ================= */
        .doc-footer {
            position: fixed;
            bottom: -20px;
            left: 0;
            right: 0;
            border-top: 1px dashed #cbd5e1;
            padding-top: 5px;
            font-size: 8px;
            color: #94a3b8;
            text-align: center;
        }

        /* Dompdf Page Numbering */
        .page-number:before {
            content: "Halaman " counter(page);
        }
    </style>
</head>

<body>

    <!-- KOP HEADER RESMI -->
    <div class="kop-container">
        <table class="kop-header">
            <tr>
                <td class="logo-container">
                    <img src="{{ public_path('img/pram.png') }}" class="logo-pramita" alt="Logo Pramita">
                </td>
                <td class="company-container">
                    <div class="clinic-name">LABORATORIUM & KLINIK PRAMITA</div>
                    <div class="clinic-sub">Layanan Pemeriksaan Kesehatan & Medical Check Up Terpadu</div>
                    <div class="clinic-sub">Sistem Informasi Rekapitulasi Hasil Pemeriksaan Medis</div>
                </td>
            </tr>
        </table>
        <div class="divider-line"></div>
    </div>

    <!-- JUDUL DOKUMEN -->
    <div class="title-wrapper">
        <div class="report-title-box">
            <h2 class="report-title">LAPORAN REKAP HASIL PEMERIKSAAN DOKTER</h2>
        </div>

        <!-- FILTER METADATA -->
        <table class="filter-table">
            <tr>
                <td class="bg-label">Perusahaan</td>
                <td width="1%">:</td>
                <td width="37%"><strong>{{ $mouInfo->master_company_name ?? '-' }}</strong></td>
                <td class="bg-label">Filter Dokter</td>
                <td width="1%">:</td>
                <td width="49%"><strong>{{ ($dokterPenginput && $dokterPenginput !== 'all') ? $dokterPenginput : 'Semua Dokter' }}</strong></td>
            </tr>
            <tr>
                <td class="bg-label">Nama MoU</td>
                <td>:</td>
                <td>{{ $mouInfo->company_mou_name ?? '-' }}</td>
                <td class="bg-label">Tgl Cetak</td>
                <td>:</td>
                <td>{{ date('d-m-Y H:i') }} WIB</td>
            </tr>
        </table>
    </div>

    <!-- TABEL REKAPITULASI -->
    <table class="table-rekap">
        <thead>
            <tr>
                <th width="3%">No</th>
                <th width="12%">NIP / NIK</th>
                <th width="14%">Nama Peserta</th>
                <th width="10%">Departemen</th>
                <th width="8%">Tensi</th>
                <th width="7%">Nadi</th>
                <th width="6%">Suhu</th>
                <th width="6%">SpO2</th>
                <th width="10%">BB / TB</th>
                <th width="12%">Kesimpulan</th>
                <th width="12%">Dokter Penginput</th>
            </tr>
        </thead>
        <tbody>
            @forelse($listPemeriksaan as $index => $row)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $row->mou_peserta_nip ?? '-' }} / {{ $row->mou_peserta_nik ?? '-' }}</td>
                <td><strong>{{ $row->mou_peserta_name }}</strong></td>
                <td>{{ $row->mou_peserta_departemen ?? '-' }}</td>
                <td class="text-center">{{ $row->tensi ?? '-' }} <span style="font-size:7.5px; color:#666;">mmHg</span></td>
                <td class="text-center">{{ $row->nadi_hr ?? '-' }} <span style="font-size:7.5px; color:#666;">bpm</span></td>
                <td class="text-center">{{ $row->suhu ?? '-' }} <span style="font-size:7.5px; color:#666;">°C</span></td>
                <td class="text-center">{{ $row->spo2 ?? '-' }} <span style="font-size:7.5px; color:#666;">%</span></td>
                <td class="text-center">{{ $row->berat_badan ?? '-' }} kg / {{ $row->tinggi_badan ?? '-' }} cm</td>
                <td class="text-center">
                    <span class="badge-kesimpulan">{{ $row->kesimpulan ?? '-' }}</span>
                </td>
                <td>{{ $row->dokter_penginput ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="11" class="text-center" style="padding: 20px; color: #94a3b8;">
                    Data rekapitulasi hasil pemeriksaan tidak ditemukan.
                </td>
            </tr>

            @endforelse
        </tbody>
    </table>

    <!-- FOOTER HALAMAN -->
    <div class="doc-footer">
        Pramita Medical Report &copy; {{ date('Y') }} — Confidential Medical Record | <span class="page-number"></span>
    </div>

</body>

</html>
