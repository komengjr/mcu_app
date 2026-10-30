<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketingAksesCabang extends Model
{
    use HasFactory;

    protected $table = 'marketing_akses_cabang';
    protected $guarded = ['id'];

    public function staff()
    {
        return $this->belongsTo(MarketingStaff::class, 'marketing_staff_id');
    }

    public function cabang()
    {
        return $this->belongsTo(MarketingCabang::class, 'kode_cabang', 'kode_cabang');
    }
}
