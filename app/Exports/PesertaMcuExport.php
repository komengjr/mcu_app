<?php

namespace App\Exports;

use App\Models\Peserta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


class PesertaMcuExport implements FromArray, WithHeadings, ShouldAutoSize
{
    protected $nama;
    public function __construct(string $keyword)
    {
        $this->nama = $keyword;
    }
    public function array(): array
    {
        $data = DB::table('company_mou_peserta')->where('company_mou_code',$this->nama)->get();
        $no = 1;
        foreach ($data as $value) {
            $lokasi = DB::table('log_lokasi_pasien')
                ->select('master_cabang.master_cabang_name', 'master_cabang.master_cabang_city', 'log_lokasi_pasien.*')
                ->join('master_cabang', 'master_cabang.master_cabang_code', '=', 'log_lokasi_pasien.lokasi_cabang')
                ->where('log_lokasi_pasien.mou_peserta_code', $value->mou_peserta_code)->first();
            if ($lokasi) {
                $loc = $lokasi->master_cabang_name;
                $waktu = $lokasi->created_at;
                $stat = 'Sudah MCU';
            } else {
                $loc = "";
                $waktu = "";
                $stat = 'Belum MC';
            }

            $data_arr[] = array(
                "id" => $no++,
                "nip" => $value->mou_peserta_nip,
                "nama_peserta" => $value->mou_peserta_name,
                "nik" => $value->mou_peserta_nik,
                "ttl" => $value->mou_peserta_ttl,
                "jk" => $value->mou_peserta_jk,
                "departemen" => $value->mou_peserta_departemen,
                "stat" => $stat,
                "status" => $loc,
                "waktu" => $waktu,
            );
        }
        $response = array(
            "aaData" => $data_arr
        );
        // dd($response);
        return $response;
        // return Peserta::query()->select(
        //     'id_mou_peserta',
        //     'mou_peserta_code',
        //     'company_mou_code',
        //     'mou_peserta_nik',
        //     'mou_peserta_nip',
        //     'mou_peserta_name',
        //     'mou_peserta_no_hp',
        //     'mou_peserta_email',
        //     'mou_peserta_ttl',
        //     'mou_peserta_jk',
        //     'mou_peserta_departemen',
        //     'mou_peserta_status',
        // )->join('')->where('company_mou_code', $this->nama)->orderBy('id_mou_peserta', 'DESC');
    }
    public function headings(): array
    {
        return [
            'ID',
            'NIP',
            'NAMA LENGKAP',
            'NIK',
            'TANGGAL LAHIR',
            'JENIS KELAMIN',
            'DEPARTEMEN',
            'STATUS MCU',
            'LOKASI MCU',
            'TANGGAL MCU',
        ];
    }
}
