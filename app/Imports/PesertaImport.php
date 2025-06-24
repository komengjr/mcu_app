<?php

namespace App\Imports;
use App\Models\Peserta;
use DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PesertaImport implements ToModel , WithHeadingRow
{
    public function __construct(string $keyword)
    {
        $this->nama = $keyword;
    }
    public function model(array $row)
    {

        // $request = request()->all();
        // $data = DB::table('company_mou_peserta')->where('company_mou_code', $request->code)->first();
        return new Peserta([
            // 'id_inventaris' => $request['kdcabang'] . "" . mt_rand(1000, 9999),
            'mou_peserta_code' => $this->nama.mt_rand(1000, 9999),
            'company_mou_code' => $this->nama,
            'mou_peserta_nik' => $row['nik'],
            'mou_peserta_nip' => $row['nip'],
            'mou_peserta_name' => $row['name'],
            'mou_peserta_no_hp' => $row['no_hp'],
            'mou_peserta_email' => $row['email'],
            'mou_peserta_ttl' => $row['ttl'],
            'mou_peserta_jk' => $row['jk'],
            'mou_peserta_departemen' => $row['departemen'],
            'created_at' => now(),
        ]);
    }
}
