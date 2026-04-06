<?php

namespace App\Imports;

use App\Models\Test;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TestImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {

        return new Test([
            'master_test_code' => str::uuid(),
            'master_test_name' => $row['nama_test'],
            'master_test_type' => 'lab',
            'created_at' => now(),
        ]);
    }
}
