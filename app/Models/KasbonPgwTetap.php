<?php

namespace App\Models;

use App\Models\GajiTetap;
use App\Models\Pegawai_Normal;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KasbonPgwTetap extends Model
{
    use HasFactory;

    protected $table = 'kasbon_pgw_tetap';
    protected $fillable = [
        'id_pgw_tetap',
        'tanggal',
        'jumlah_kasbon',
        'sisa',
        'status'
    ];

    public function pegawai_normal()
    {
        return $this->belongsTo(Pegawai_Normal::class, 'id_pgw_tetap');
    }

    public function gaji_tetap()
    {
        return $this->hasOne(GajiTetap::class, 'id_kasbon_tetap');
    }
}
