<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekap KPI Staf - {{ $bulan }}/{{ $tahun }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; margin: 20px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h3 { margin: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table, th, td { border: 1px solid #333; padding: 6px 8px; }
        th { background-color: #f2f2f2; text-align: center; }
        .text-center { text-align: center; }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="no-print" style="margin-bottom: 15px;">
        <button onclick="window.print()">Cetak Dokumen</button>
    </div>

    <div class="header">
        <h3>REKAPITULASI EVALUASI KPI STAF MARKETING</h3>
        <p style="margin: 5px 0 0 0;">Periode: {{ $bulan }}/{{ $tahun }} | Cabang: {{ $namaCabang }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 40px;">No</th>
                <th>NIK</th>
                <th>Nama Staf</th>
                <th>Jabatan</th>
                <th>Cabang</th>
                <th>Skor Akhir KPI</th>
                <th>Predikat</th>
            </tr>
        </thead>
        <tbody>
            @forelse($staffs as $index => $s)
            @php $p = $s->penilaians->first(); @endphp
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $s->nik }}</td>
                <td><strong>{{ $s->nama_lengkap }}</strong></td>
                <td>{{ $s->jabatan }}</td>
                <td>{{ $s->cabang ? $s->cabang->nama_cabang : '-' }}</td>
                <td class="text-center">{{ $p ? number_format($p->total_skor_akhir, 2) . '%' : '-' }}</td>
                <td class="text-center">{{ $p ? $p->predikat : 'Belum Dinilai' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">Tidak ada data staf.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
