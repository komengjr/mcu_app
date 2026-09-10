<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketingTarget extends Model
{
    use HasFactory;

    protected $table = 'marketing_targets';

    protected $fillable = [
        'marketing_staff_id',
        'bulan',
        'tahun',
        'target_omset',
        'persentase_komisi',
        'tier_insentif',
        'status_pencapaian',
    ];

    protected $casts = [
        'target_omset' => 'decimal:2',
        'persentase_komisi' => 'decimal:2',
    ];

    // Relasi balik ke MarketingStaff
    public function staff()
    {
        return $this->belongsTo(MarketingStaff::class, 'marketing_staff_id');
    }
}
