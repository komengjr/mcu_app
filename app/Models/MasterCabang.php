<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterCabang extends Model
{
    use HasFactory;

    protected $table = 'master_cabang';
    protected $primaryKey = 'id_master_cabang';

    protected $fillable = [
        'master_cabang_code',
        'master_cabang_entitas',
        'master_cabang_name',
        'master_cabang_latitude',
        'master_cabang_longtitude',
        'master_cabang_city',
        'master_cabang_alamat',
        'master_cabang_phone',
        'master_cabang_status',
    ];

    // Relasi ke MarketingStaff
    public function marketingStaff()
    {
        return $this->hasMany(MarketingStaff::class, 'kode_cabang', 'master_cabang_code');
    }
}
