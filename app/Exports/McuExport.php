<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class McuExport implements FromArray, WithHeadings, ShouldAutoSize
{
    protected $dataCode;
    protected $companyName;

    public function __construct(string $keyword)
    {
        $this->dataCode = $keyword;

        // Ambil nama perusahaan sekali saja di konstruktor
        $companyMou = DB::table('company_mou')
            ->where('company_mou_code', $this->dataCode)
            ->first();

        $this->companyName = $companyMou ? $companyMou->company_mou_name : '-';
    }

    public function array(): array
    {
        // 1. Ambil seluruh peserta sekaligus
        $pesertaList = DB::table('company_mou_peserta')
            ->where('company_mou_code', $this->dataCode)
            ->get();

        if ($pesertaList->isEmpty()) {
            return [];
        }

        $pesertaCodes = $pesertaList->pluck('mou_peserta_code')->toArray();

        // 2. BULK QUERY: Ambil data lokasi/cabang sekali jalan untuk semua peserta
        $lokasiMap = DB::table('log_lokasi_pasien')
            ->join('master_cabang', 'master_cabang.master_cabang_code', '=', 'log_lokasi_pasien.lokasi_cabang')
            ->join('group_cabang_detail', 'group_cabang_detail.master_cabang_code', '=', 'log_lokasi_pasien.lokasi_cabang')
            ->join('group_cabang', 'group_cabang.group_cabang_code', '=', 'group_cabang_detail.group_cabang_code')
            ->whereIn('log_lokasi_pasien.mou_peserta_code', $pesertaCodes)
            ->select('log_lokasi_pasien.mou_peserta_code', 'group_cabang.group_cabang_name', 'master_cabang.master_cabang_name')
            ->get()
            ->keyBy('mou_peserta_code');

        // 3. BULK QUERY: Ambil master pemeriksaan & master agreement sub untuk proyek ini
        $agreementPemeriksaan = DB::table('company_mou_agreement_sub')
            ->join('master_pemeriksaan', 'master_pemeriksaan.master_pemeriksaan_code', '=', 'company_mou_agreement_sub.master_pemeriksaan_code')
            ->join('company_mou_agreement', 'company_mou_agreement.mou_agreement_code', '=', 'company_mou_agreement_sub.mou_agreement_code')
            ->where('company_mou_agreement.company_mou_code', $this->dataCode)
            ->select('company_mou_agreement_sub.master_pemeriksaan_code', 'master_pemeriksaan.master_pemeriksaan_name')
            ->get();

        // 4. BULK QUERY: Ambil seluruh log pemeriksaan pasien sekaligus
        $logPemeriksaanMap = DB::table('log_pemeriksaan_pasien')
            ->whereIn('mou_peserta_code', $pesertaCodes)
            ->get()
            ->groupBy('mou_peserta_code');

        // 5. BULK QUERY: Ambil data pengiriman hasil sekaligus
        $pengirimanMap = DB::table('log_pengiriman_pasien')
            ->whereIn('mou_peserta_code', $pesertaCodes)
            ->pluck('mou_peserta_code')
            ->flip()
            ->toArray();

        // 6. Mapping data ke array final secara in-memory (sangat cepat tanpa query berulang)
        $data_arr = [];
        $no = 1;

        foreach ($pesertaList as $value) {
            $pCode = $value->mou_peserta_code;

            // Mapping Wilayah & Lokasi Cabang
            $wilayah = isset($lokasiMap[$pCode]) ? $lokasiMap[$pCode]->group_cabang_name : '-';
            $cabang  = isset($lokasiMap[$pCode]) ? $lokasiMap[$pCode]->master_cabang_name : '-';

            // Mapping Status Pemeriksaan per item
            $text = '';
            foreach ($agreementPemeriksaan as $item) {
                $isCompleted = false;
                if (isset($logPemeriksaanMap[$pCode])) {
                    // Cek apakah peserta ini sudah melewati pemeriksaan tersebut
                    $isCompleted = $logPemeriksaanMap[$pCode]->contains('master_pemeriksaan_code', $item->master_pemeriksaan_code);
                }

                $statusText = $isCompleted ? 'Selesai' : 'Belum Selesai';
                $text .= trim($item->master_pemeriksaan_name) . ': ' . $statusText . "\n";
            }
            $text = trim($text); // Bersihkan newline di ujung

            // Mapping Pengiriman Hasil
            $hasil = isset($pengirimanMap[$pCode]) ? 'Selesai' : 'Belum Selesai';

            $data_arr[] = [
                "No"                      => $no++,
                "mou_peserta_nip"         => "'" . $value->mou_peserta_nip,
                "mou_peserta_name"        => $value->mou_peserta_name,
                "mou_peserta_jk"          => $value->mou_peserta_jk,
                "mou_peserta_departemen"  => $value->mou_peserta_departemen,
                "wilayah"                 => $wilayah,
                "lokasi"                  => $cabang,
                "status_pemeriksaan"      => $text,
                "pengiriman_hasil"        => $hasil,
            ];
        }

        return $data_arr;
    }

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_TEXT, // Kolom NIP agar tidak terpotong nol di depannya
        ];
    }

    public function headings(): array
    {
        return [
            ['Nama Perusahaan:', $this->companyName], // Baris Info Perusahaan
            [], // Baris kosong untukspasi yang rapi
            [
                'No',
                'NIP',
                'NAMA PESERTA',
                'JENIS KELAMIN',
                'DEPARTEMEN',
                'WILAYAH',
                'LOKASI MCU',
                'STATUS PEMERIKSAAN',
                'STATUS PENGIRIMAN HASIL',
            ],
        ];
    }
}
