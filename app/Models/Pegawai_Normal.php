<?php

namespace App\Models;

use App\Models\KasbonPgwTetap;
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
        'gaji_final',
    ];

    // kasbon KasbonPgwTetap
    public function kasbon_pegawai()
    {
        return $this->hasMany(KasbonPgwTetap::class, 'id_pgw_normal');
    }

}
