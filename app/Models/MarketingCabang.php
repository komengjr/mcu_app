<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketingCabang extends Model
{
    use HasFactory;

    protected $table = 'marketing_cabang';

    protected $fillable = [
        'kode_cabang',
        'nama_cabang',
        'entitas',
        'kota',
        'alamat',
        'no_telepon',
        'latitude',
        'longitude',
        'status',
    ];

    public function staff()
    {
        return $this->hasMany(MarketingStaff::class, 'kode_cabang', 'kode_cabang');
    }
}
