<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai_Normal extends Model
{
    use HasFactory;

    protected $table = 'pegawai_normal';
    protected $fillable = [
        'nama',
        'nip',
        'alamat',
        'no_telp',
        'jenis_kelamin',
        'gaji_pokok',
        'status',
    ];
}
