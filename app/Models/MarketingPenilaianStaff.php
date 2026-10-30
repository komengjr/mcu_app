<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketingPenilaianStaff extends Model
{
    use HasFactory;

    protected $table = 'marketing_penilaian_staff';
    protected $guarded = ['id'];

    public function staff()
    {
        return $this->belongsTo(MarketingStaff::class, 'marketing_staff_id');
    }

    public function details()
    {
        return $this->hasMany(MarketingPenilaianStaffDetail::class, 'penilaian_staff_id');
    }
}
