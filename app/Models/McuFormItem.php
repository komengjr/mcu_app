<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class McuFormItem extends Model
{
    protected $table = 'mcu_form_items';
    protected $primaryKey = 'id_mcu_form_item';
    protected $guarded = [];

    public function form()
    {
        return $this->belongsTo(McuForm::class, 'id_mcu_form', 'id_mcu_form');
    }

    public function options()
    {
        return $this->hasMany(McuItemOption::class, 'id_mcu_form_item', 'id_mcu_form_item');
    }

    public function results()
    {
        return $this->hasMany(McuResult::class, 'id_mcu_form_item', 'id_mcu_form_item');
    }
}
