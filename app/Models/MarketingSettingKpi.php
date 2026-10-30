<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketingSettingKpi extends Model
{
    use HasFactory;

    protected $table = 'marketing_setting_kpi';
    protected $guarded = ['id'];

    // Relasi ke seluruh target bulanan
    public function targets()
    {
        return $this->hasMany(MarketingSettingKpiTarget::class, 'kpi_id');
    }

    // Helper relasi target per periode spesifik
    public function targetBulanIni($bulan, $tahun)
    {
        return $this->hasOne(MarketingSettingKpiTarget::class, 'kpi_id')
            ->where('bulan', $bulan)
            ->where('tahun', $tahun);
    }
}
