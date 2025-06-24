<?php

namespace App\Imports;
use App\Models\Peserta;
use DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PesertaImport implements ToModel , WithHeadingRow
{
    public function __construct(string $code,$ids)
    {
        $this->ids = $ids;
        $this->code = $code;
    }
    public function model(array $row)
    {

        // $request = request()->all();
        // $data = DB::table('company_mou_peserta')->where('company_mou_code', $request->code)->first();
        return new Peserta([
            'mou_peserta_code' => $this->code.mt_rand(1000, 9999),
            'company_mou_code' => $this->code,
            'mou_peserta_nik' => $row['nik'],
            'mou_peserta_nip' => $row['nip'],
            'mou_peserta_name' => $row['name'],
            'mou_peserta_no_hp' => $row['no_hp'],
            'mou_peserta_email' => $row['email'],
            'mou_peserta_ttl' => $row['ttl'],
            'mou_peserta_jk' => $row['jk'],
            'mou_peserta_departemen' => $row['departemen'],
            'mou_agreement_code' => $this->ids,
            'created_at' => now(),
        ]);
    }
}
