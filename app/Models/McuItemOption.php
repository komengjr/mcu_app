<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class McuItemOption extends Model
{
    protected $table = 'mcu_item_options';
    protected $primaryKey = 'id_mcu_item_option';
    protected $guarded = [];

    public function item()
    {
        return $this->belongsTo(McuFormItem::class, 'id_mcu_form_item', 'id_mcu_form_item');
    }
}
