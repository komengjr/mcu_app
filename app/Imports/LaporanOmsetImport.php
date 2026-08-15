<?php

namespace App\Imports;

use App\Models\LaporanOmset;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Carbon\Carbon;

class LaporanOmsetImport implements ToModel, WithStartRow
{
    // Memulai import dari baris ke-7 (melewati header & judul cabang)
    public function startRow(): int
    {
        return 7;
    }

    public function model(array $row)
    {
        // Abaikan jika kolom NOREG (index ke-2) kosong
        if (empty($row[2])) {
            return null;
        }

        return new LaporanOmset([
            'tanggal'       => isset($row[1]) ? Carbon::parse($row[1])->format('Y-m-d') : null,
            'noreg'         => $row[2] ?? null,
            'pasien'        => $row[3] ?? null,
            'hp'            => $row[4] ?? null,
            'alamat'        => $row[5] ?? null,
            'tipe_omset'    => $row[6] ?? null,
            'dob'           => isset($row[7]) ? Carbon::parse($row[7])->format('Y-m-d') : null,
            'kel_pelanggan' => $row[8] ?? null,
            'mou'           => $row[9] ?? null,
            'marketing'     => $row[10] ?? null,
            'bruto'         => (float) ($row[11] ?? 0),
            'disc'          => (float) ($row[12] ?? 0),
            'total'         => (float) ($row[13] ?? 0),
            'pay'           => (float) ($row[14] ?? 0),
            'jml_test'      => (int) ($row[15] ?? 0),
            'pemeriksaan'   => $row[16] ?? null,
            'nik'           => $row[17] ?? null,
            'jabatan'       => $row[18] ?? null,
            'location'      => $row[19] ?? null,
            'job'           => $row[20] ?? null,
            'kedatangan'    => (int) ($row[21] ?? 0),
        ]);
    }
}
