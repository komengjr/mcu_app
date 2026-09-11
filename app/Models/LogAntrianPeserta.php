<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogAntrianPeserta extends Model
{
    use HasFactory;

    protected $table = 'log_antrian_peserta';
    protected $primaryKey = 'log_antrian_id';

    protected $fillable = [
        'log_antrian_code',
        'company_mou_code',
        'mou_peserta_code',
        'nomor_antrian',
        'nama_pos_pemeriksaan',
        'status_antrian',
        'panggilan_ke',
        'operator_user_id',
        'waktu_panggil',
        'waktu_melayani',
        'waktu_selesai',
    ];

    /**
     * Relasi ke Data Peserta MCU
     */
    public function peserta()
    {
        return $this->belongsTo(CompanyMouPeserta::class, 'mou_peserta_code', 'mou_peserta_code');
    }

    /**
     * Relasi ke Data Company MOU
     */
    public function companyMou()
    {
        return $this->belongsTo(CompanyMou::class, 'company_mou_code', 'company_mou_code');
    }
}
