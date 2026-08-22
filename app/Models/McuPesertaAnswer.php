<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class McuPesertaAnswer extends Model
{
    use HasFactory;

    protected $table = 'mcu_peserta_answers';
    protected $primaryKey = 'id_mcu_answer';

    protected $fillable = [
        'mou_peserta_code',
        'id_mcu_form',
        'answers_data',
        'is_completed',
    ];

    protected $casts = [
        'answers_data' => 'array',
        'is_completed' => 'boolean',
    ];

    public function peserta()
    {
        return $this->belongsTo(CompanyMouPeserta::class, 'mou_peserta_code', 'mou_peserta_code');
    }

    public function form()
    {
        return $this->belongsTo(McuForm::class, 'id_mcu_form', 'id_mcu_form');
    }
}
