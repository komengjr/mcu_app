<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class McuForm extends Model
{
    protected $table = 'mcu_forms';
    protected $primaryKey = 'id_mcu_form';
    protected $guarded = [];

    public function items()
    {
        return $this->hasMany(McuFormItem::class, 'id_mcu_form', 'id_mcu_form')
            ->orderBy('sort_order', 'asc');
    }
}
