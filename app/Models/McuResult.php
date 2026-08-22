<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class McuResult extends Model
{
    protected $table = 'mcu_results';
    protected $primaryKey = 'id_mcu_result';
    protected $guarded = [];

    public function registration()
    {
        return $this->belongsTo(McuRegistration::class, 'id_mcu_registration', 'id_mcu_registration');
    }

    public function formItem()
    {
        return $this->belongsTo(McuFormItem::class, 'id_mcu_form_item', 'id_mcu_form_item');
    }
}
