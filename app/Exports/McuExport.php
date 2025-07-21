<?php

namespace App\Exports;

use App\Models\Peserta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromArray;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class McuExport implements FromArray, WithHeadings, ShouldAutoSize
{
    protected $data;
    public function __construct(string $keyword)
    {
        $this->data = $keyword;
    }
    public function array(): array
    {
        $no = 1;
        $data = DB::table('company_mou_peserta')->select('company_mou_peserta.*')->where('company_mou_code', $this->data)->get();
        foreach ($data as $value) {
            $lokasi = DB::table('log_lokasi_pasien')
                ->join('master_cabang', 'master_cabang.master_cabang_code', '=', 'log_lokasi_pasien.lokasi_cabang')
                ->join('group_cabang_detail', 'group_cabang_detail.master_cabang_code', '=', 'log_lokasi_pasien.lokasi_cabang')
                ->join('group_cabang', 'group_cabang.group_cabang_code', '=', 'group_cabang_detail.group_cabang_code')
                ->where('log_lokasi_pasien.mou_peserta_code', $value->mou_peserta_code)->first();
            if ($lokasi) {
                $wilayah = $lokasi->group_cabang_name;
                $cabang = $lokasi->master_cabang_name;
            } else {
                $wilayah = '-';
                $cabang = '-';
            }
            $pemeriksaan = DB::table('company_mou_agreement_sub')
                ->join('master_pemeriksaan', 'master_pemeriksaan.master_pemeriksaan_code', '=', 'company_mou_agreement_sub.master_pemeriksaan_code')
                ->join('company_mou_agreement', 'company_mou_agreement.mou_agreement_code', '=', 'company_mou_agreement_sub.mou_agreement_code')
                ->where('company_mou_agreement.company_mou_code', $this->data)->get();
            $text = '';
            foreach ($pemeriksaan as $item) {
                $log = DB::table('log_pemeriksaan_pasien')
                    ->join('master_pemeriksaan', 'master_pemeriksaan.master_pemeriksaan_code', '=', 'log_pemeriksaan_pasien.master_pemeriksaan_code')
                    ->where('mou_peserta_code', $value->mou_peserta_code)->where('log_pemeriksaan_pasien.master_pemeriksaan_code', $item->master_pemeriksaan_code)->first();
                if ($log) {
                    $text =  $text . ' ' . $log->master_pemeriksaan_name . ': Selesai' . "\n";
                } else {
                    $text =  $text . ' ' . $item->master_pemeriksaan_name . ': Belum Selesai' . "\n";
                    # code...
                }
            }
            $pengiriman = DB::table('log_pengiriman_pasien')
                ->where('mou_peserta_code', $value->mou_peserta_code)
                ->first();
                if ($pengiriman) {
                    $hasil = 'Selesai';
                } else {
                    $hasil = 'Belum Selesai';
                }


            $data_arr[] = array(
                "No" => $no++,
                "mou_peserta_nip" => "'" . $value->mou_peserta_nip,
                "mou_peserta_name" => $value->mou_peserta_code,
                "mou_peserta_jk" => $value->mou_peserta_jk,
                "mou_peserta_departemen" => $value->mou_peserta_departemen,
                "wilayah" => $wilayah,
                "lokasi" => $cabang,
                "status_pemeriksaan" =>  $text,
                "pengiriman_hasil" => $hasil,
            );
        }
        $response = array(
            "aaData" => $data_arr
        );
        // dd($response);
        return  $response;
    }
    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT,
            'B' => NumberFormat::FORMAT_TEXT,
            'C' => NumberFormat::FORMAT_TEXT,
            'D' => NumberFormat::FORMAT_TEXT,
        ];
    }
    public function headings(): array
    {
        $data = DB::table('company_mou')->where('company_mou_code', $this->data)->first();
        return [
            [
                '#',
                'Nama Perusahaan',
                $data->company_mou_name,
            ],
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
