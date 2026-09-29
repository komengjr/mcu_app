<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RekapPemeriksaanExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $mouCode;
    protected $dokterPenginput;

    public function __construct($mouCode, $dokterPenginput)
    {
        $this->mouCode = $mouCode;
        $this->dokterPenginput = $dokterPenginput;
    }

    public function collection()
    {
        // Gunakan DB::table dan join sesuai struktur relasi database Anda
        $query = DB::table('company_mou_pemeriksaan_doc as doc')
            ->join('company_mou_peserta as peserta', 'doc.mou_peserta_code', '=', 'peserta.mou_peserta_code')
            ->where('peserta.company_mou_code', $this->mouCode);

        // Jika dokter bukan 'all', filter berdasarkan dokter penginput
        if ($this->dokterPenginput !== 'all') {
            $query->where('doc.dokter_penginput', $this->dokterPenginput);
        }

        // Pilih kolom yang ingin ditampilkan
        $query->select(
            'peserta.mou_peserta_nip',
            'peserta.mou_peserta_nik',
            'peserta.mou_peserta_name',
            'doc.created_at',
            'doc.dokter_penginput',
            'doc.berat_badan',
            'doc.tinggi_badan',
            'doc.rr_nafas',
            'doc.suhu',
            'doc.tensi',
            'doc.nadi_hr',
            'doc.spo2',
            'doc.catatan_dokter',
            'doc.kesimpulan'
        );

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'NIP / NIK',
            'Nama Pasien',
            'Tanggal Periksa',
            'Dokter Penginput',
            'Berat Badan (kg)',
            'Tinggi Badan (cm)',
            'RR Nafas (x/m)',
            'Suhu (°C)',
            'Tensi (mmHg)',
            'Nadi / HR (x/m)',
            'SpO2 (%)',
            'Catatan Dokter',
            'Kesimpulan'
        ];
    }

    public function map($row): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            ($row->mou_peserta_nip ?? '-') . ' / ' . ($row->mou_peserta_nik ?? '-'),
            $row->mou_peserta_name ?? '-',
            $row->created_at ? date('Y-m-d H:i', strtotime($row->created_at)) : '-',
            $row->dokter_penginput ?? '-',
            $row->berat_badan ?? '-',
            $row->tinggi_badan ?? '-',
            $row->rr_nafas ?? '-',
            $row->suhu ?? '-',
            $row->tensi ?? '-',
            $row->nadi_hr ?? '-',
            $row->spo2 ?? '-',
            $row->catatan_dokter ?? '-',
            $row->kesimpulan ?? '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Styling header agar tebal dan memiliki background hijau muda
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'E2EFDA']
                ]
            ],
        ];
    }
}
