<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterAccess extends Model
{
    use HasFactory;

    protected $table = 'master_access';
    protected $primaryKey = 'id_master_access';
    protected $guarded = ['id_master_access'];
}
