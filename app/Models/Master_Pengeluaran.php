<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Master_Pengeluaran extends Model
{
    use HasFactory;

    protected $table = 'master_pengeluaran';
    protected $fillable = [
        'nama_atribut',
        'tipe',
    ];
}
