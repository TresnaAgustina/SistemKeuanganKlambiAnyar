<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Master_Jaritan extends Model
{
    use HasFactory;

    protected $table = 'master_jaritan';
    protected $fillable = [
        'jenis_jaritan',
        'harga_dalam',
        'harga_luar',
    ];
}
