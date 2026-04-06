<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $table = 'master_test';
    protected $fillable = [
        'id_master_test',
        'master_test_code',
        'master_test_name',
        'master_test_type',
        'created_at'
    ];
}
