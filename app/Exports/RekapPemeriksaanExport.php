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
            'Nilai BMI',
            'Status BMI (WHO Asia Pasifik)',
            'RR Nafas (x/m)',
            'Suhu (°C)',
            'Tensi (mmHg)',
            'Klasifikasi Tensi (JNC 7)',
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

        // Hitung BMI & Status BMI (Standar WHO Asia Pasifik)
        $berat = floatval($row->berat_badan ?? 0);
        $tinggiCm = floatval($row->tinggi_badan ?? 0);
        $bmiStr = '-';
        $statusBmi = '-';

        if ($berat > 0 && $tinggiCm > 0) {
            $tinggiM = $tinggiCm / 100;
            $bmi = $berat / ($tinggiM * $tinggiM);
            $bmiStr = number_format($bmi, 2, '.', '');

            // Kategori WHO Asia Pasifik
            if ($bmi < 18.5) {
                $statusBmi = 'Underweight (Kurus)';
            } elseif ($bmi >= 18.5 && $bmi <= 22.9) {
                $statusBmi = 'Normal';
            } elseif ($bmi >= 23.0 && $bmi <= 24.9) {
                $statusBmi = 'Overweight (Berisiko)';
            } elseif ($bmi >= 25.0 && $bmi <= 29.9) {
                $statusBmi = 'Obese I (Obesitas I)';
            } else {
                $statusBmi = 'Obese II (Obesitas II)';
            }
        }

        // Klasifikasi Tekanan Darah JNC 7
        $klasifikasiTensi = '-';
        if (!empty($row->tensi)) {
            // Asumsi format tensi umum: "120/80" atau menggunakan pemisah spasi/strip
            $tensiClean = trim($row->tensi);
            if (preg_match('/(\d+)\D+(\d+)/', $tensiClean, $matches)) {
                $sys = intval($matches[1]);
                $dia = intval($matches[2]);

                if ($sys < 120 && $dia < 80) {
                    $klasifikasiTensi = 'Normal';
                } elseif (($sys >= 120 && $sys <= 139) || ($dia >= 80 && $dia <= 89)) {
                    $klasifikasiTensi = 'Prehipertensi';
                } elseif (($sys >= 140 && $sys <= 159) || ($dia >= 90 && $dia <= 99)) {
                    $klasifikasiTensi = 'Hipertensi Stage 1';
                } elseif ($sys >= 160 || $dia >= 100) {
                    $klasifikasiTensi = 'Hipertensi Stage 2';
                } else {
                    $klasifikasiTensi = 'Periksa Kembali';
                }
            } else {
                $klasifikasiTensi = $row->tensi; // Jika format teks bebas
            }
        }

        return [
            $no,
            ($row->mou_peserta_nip ?? '-') . ' / ' . ($row->mou_peserta_nik ?? '-'),
            $row->mou_peserta_name ?? '-',
            $row->created_at ? date('Y-m-d H:i', strtotime($row->created_at)) : '-',
            $row->dokter_penginput ?? '-',
            $row->berat_badan ?? '-',
            $row->tinggi_badan ?? '-',
            $bmiStr,
            $statusBmi,
            $row->rr_nafas ?? '-',
            $row->suhu ?? '-',
            $row->tensi ?? '-',
            $klasifikasiTensi,
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
