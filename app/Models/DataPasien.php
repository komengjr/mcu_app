<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPasien extends Model
{
    protected $table = 'monitoring_hasil_pasien';
    protected $fillable = [
        'id_monitoring_hasil_pasien',
        'monitoring_hasil_pasien_code',
        'monitoring_hasil_pasien_nama',
        'monitoring_hasil_pasien_nik',
        'monitoring_hasil_pasien_tgl_lahir',
        'monitoring_hasil_pasien_jk',
        'monitoring_hasil_pasien_reg',
        'monitoring_hasil_pasien_tgl_periksa',
        'monitoring_hasil_pasien_tgl_selesai',
        'monitoring_hasil_pasien_type',
        'monitoring_hasil_pasien_file',
        'monitoring_hasil_pasien_cabang',
        'monitoring_hasil_pasien_user',
        'monitoring_hasil_pasien_status',
        'created_at',
    ];
}
