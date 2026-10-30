<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketingHierarkiPenilaian extends Model
{
    use HasFactory;

    // Tambahkan properti nama tabel eksplisit berikut:
    protected $table = 'marketing_hierarki_penilaian';

    protected $guarded = ['id'];
}
