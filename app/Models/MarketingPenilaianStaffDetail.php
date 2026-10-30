<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketingPenilaianStaffDetail extends Model
{
    use HasFactory;

    protected $table = 'marketing_penilaian_staff_detail';
    protected $guarded = ['id'];

    public function header()
    {
        return $this->belongsTo(MarketingPenilaianStaff::class, 'penilaian_staff_id');
    }

    public function kpi()
    {
        return $this->belongsTo(MarketingSettingKpi::class, 'kpi_id');
    }
}
