<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class McuRegistration extends Model
{
    protected $table = 'mcu_registrations';
    protected $primaryKey = 'id_mcu_registration';
    protected $guarded = [];

    public function peserta()
    {
        return $this->belongsTo(CompanyMouPeserta::class, 'mou_peserta_code', 'mou_peserta_code');
    }

    public function results()
    {
        return $this->hasMany(McuResult::class, 'id_mcu_registration', 'id_mcu_registration');
    }
}
