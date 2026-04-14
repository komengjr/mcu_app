<?php

namespace App\Imports;

use App\Models\DataPasien;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Auth;
class PasienImport implements ToModel, WithHeadingRow
{
    public function __construct(string $code)
    {
        $this->code = $code;
    }
    public function model(array $row)
    {
        $UNIX_DATE = ($row['tgl_lahir'] - 25569) * 86400;
        $UNIX_DATE1 = ($row['tgl_reg'] - 25569) * 86400;
        return new DataPasien([
            'monitoring_hasil_pasien_code' => str::uuid(),
            'monitoring_hasil_pasien_nama' => $row['nama_pasien'],
            'monitoring_hasil_pasien_nik' => $row['nik'],
            'monitoring_hasil_pasien_tgl_lahir' => date('Y-m-d', $UNIX_DATE),
            'monitoring_hasil_pasien_jk' => $row['jenis_kelamin'],
            'monitoring_hasil_pasien_reg' =>  $row['no_reg'],
            'monitoring_hasil_pasien_tgl_periksa' => date('Y-m-d', $UNIX_DATE1),
            'monitoring_hasil_pasien_tgl_selesai' => null,
            'monitoring_hasil_pasien_type' => "LAB",
            'monitoring_hasil_pasien_file' => "",
            'monitoring_hasil_pasien_cabang' => Auth::user()->access_cabang,
            'monitoring_hasil_pasien_user' => $this->code,
            'monitoring_hasil_pasien_status' => 2,
            'created_at' => date('Y-m-d', $UNIX_DATE1),
        ]);
    }
}
