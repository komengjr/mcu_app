<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyMouPeserta extends Model
{
    protected $table = 'company_mou_peserta';
    protected $primaryKey = 'mou_peserta_code';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $guarded = [];

    public function mcuRegistrations()
    {
        return $this->hasMany(McuRegistration::class, 'mou_peserta_code', 'mou_peserta_code');
    }
}
