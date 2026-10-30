<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketingSettingKpiTarget extends Model
{
    use HasFactory;

    protected $table = 'marketing_setting_kpi_target';
    protected $guarded = ['id'];

    public function kpi()
    {
        return $this->belongsTo(MarketingSettingKpi::class, 'kpi_id');
    }
}
