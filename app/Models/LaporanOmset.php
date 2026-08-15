<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanOmset extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model ini.
     *
     * @var string
     */
    protected $table = 'laporan_omsets';

    /**
     * Kolom yang tidak boleh diisi secara massal (Mass Assignment).
     * Mengosongkan guarded berarti semua kolom diizinkan untuk disimpan.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Konversi tipe data otomatis (Type Casting) saat mengambil dari database.
     *
     * @var array
     */
    protected $casts = [
        'tanggal'    => 'date',
        'dob'        => 'date',
        'bruto'      => 'float',
        'disc'       => 'float',
        'total'      => 'float',
        'pay'        => 'float',
        'jml_test'   => 'integer',
        'kedatangan' => 'integer',
        'cabang'     => 'string', // Updated to string
    ];
}
