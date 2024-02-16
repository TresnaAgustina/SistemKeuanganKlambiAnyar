<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kasbon_Pegawai extends Model
{
    use HasFactory;

    protected $table = 'kasbon_pegawai';
    protected $fillable = [
        'id_pgw_normal',
        'id_pgw_rumahan',
        'tanggal',
        'jumlah_kasbon',
        'sisa',
        'status',
    ];

    public function pegawai_normal()
    {
        return $this->belongsTo(Pegawai_Normal::class, 'id_pgw_normal', 'id');
    }

    public function pegawai_rumahan()
    {
        return $this->belongsTo(Pegawai_Rumahan::class, 'id_pgw_rumahan', 'id');
    }
}
