<?php

namespace App\Models;

use App\Models\Kasbon_Pegawai;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function kasbon_Pegawai()
    {
        return $this->hasMany(Kasbon_Pegawai::class);
    }
}
