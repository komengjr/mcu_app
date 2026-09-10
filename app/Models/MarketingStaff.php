<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketingStaff extends Model
{
    use HasFactory;

    protected $table = 'marketing_staff';

    protected $fillable = [
        'kode_cabang',
        'nik',
        'nama_lengkap',
        'email',
        'no_telepon',
        'jabatan',
        'tanggal_masuk',
        'nama_bank',
        'nomor_rekening',
        'nama_pemilik_rekening',
        'status_aktif'
    ];

    // Relasi ke MarketingCabang
    public function cabang()
    {
        return $this->belongsTo(MarketingCabang::class, 'kode_cabang', 'kode_cabang');
    }

    public function targets()
    {
        return $this->hasMany(MarketingTarget::class, 'marketing_staff_id');
    }
}
