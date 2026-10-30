<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan KPI - {{ $staff->nama_lengkap }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; margin: 20px; }
        .header { text-align: center; margin-bottom: 20px; }
        .info-table { width: 100%; margin-bottom: 15px; border: none; }
        .info-table td { border: none; padding: 3px 0; }
        table.data { width: 100%; border-collapse: collapse; }
        table.data, table.data th, table.data td { border: 1px solid #333; padding: 6px 8px; }
        th { background-color: #f2f2f2; }
        .text-center { text-align: center; }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body onload="window.print()">
    <div class="no-print" style="margin-bottom: 15px;">
        <button onclick="window.print()">Cetak Dokumen</button>
    </div>

    <div class="header">
        <h3 style="margin:0;">LEMBAR EVALUASI PENILAIAN KPI INDIVIDU</h3>
        <p style="margin: 5px 0 0 0;">Periode: {{ $bulan }}/{{ $tahun }}</p>
    </div>

    <table class="info-table">
        <tr>
            <td style="width: 15%;"><strong>Nama Staf</strong></td>
            <td style="width: 35%;">: {{ $staff->nama_lengkap }}</td>
            <td style="width: 15%;"><strong>Cabang</strong></td>
            <td>: {{ $staff->cabang ? $staff->cabang->nama_cabang : '-' }}</td>
        </tr>
        <tr>
            <td><strong>NIK</strong></td>
            <td>: {{ $staff->nik }}</td>
            <td><strong>Jabatan</strong></td>
            <td>: {{ $staff->jabatan }}</td>
        </tr>
    </table>

    <table class="data">
        <thead>
            <tr>
                <th style="width: 40px;">No</th>
                <th>Indikator KPI</th>
                <th class="text-center">Target</th>
                <th class="text-center">Realisasi</th>
                <th class="text-center">Satuan</th>
                <th class="text-center">Bobot</th>
                <th class="text-center">Capaian (%)</th>
                <th class="text-center">Skor Terbobot</th>
            </tr>
        </thead>
        <tbody>
            @if($penilaian && $penilaian->details->count() > 0)
                @foreach($penilaian->details as $idx => $d)
                <tr>
                    <td class="text-center">{{ $idx + 1 }}</td>
                    <td>{{ $d->nama_indikator }}</td>
                    <td class="text-center">{{ number_format($d->target_standar, 2) }}</td>
                    <td class="text-center">{{ number_format($d->pencapaian_real, 2) }}</td>
                    <td class="text-center">{{ $d->satuan }}</td>
                    <td class="text-center">{{ $d->bobot_persen }}%</td>
                    <td class="text-center">{{ number_format($d->persentase_capaian, 2) }}%</td>
                    <td class="text-center">{{ number_format($d->skor_terbobot, 2) }}%</td>
                </tr>
                @endforeach
                <tr style="font-weight: bold; background-color: #f9f9f9;">
                    <td colspan="7" style="text-align: right;">TOTAL SKOR AKHIR / PREDIKAT:</td>
                    <td class="text-center">{{ number_format($penilaian->total_skor_akhir, 2) }}% ({{ $penilaian->predikat }})</td>
                </tr>
            @else
                <tr>
                    <td colspan="8" class="text-center">Belum ada data penilaian pada periode ini.</td>
                </tr>
            @endif
        </tbody>
    </table>

    @if($penilaian && $penilaian->catatan_evaluasi)
    <div style="margin-top: 15px;">
        <strong>Catatan / Evaluasi Supervisor:</strong>
        <p style="border: 1px solid #ccc; padding: 8px; margin-top: 5px; background: #fafafa;">
            {{ $penilaian->catatan_evaluasi }}
        </p>
    </div>
    @endif
</body>
</html>
