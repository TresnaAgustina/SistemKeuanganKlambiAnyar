<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bayaran_Pegawai_Rumahan extends Model
{
    use HasFactory;

    protected $table = 'bayaran_pegawai_rumahan';
    protected $fillable = [
        'id_pgw_rumahan',
        'id_kasbon_pgw',
        'id_mstr_jaritan',
        'tanggal',
        'banyak_jarit',
        'jumlah',
        'jumlah_bersih',
    ];

    public function pegawai_rumahan()
    {
        return $this->belongsTo(Pegawai_Rumahan::class, 'id_pgw_rumahan', 'id');
    }

    public function kasbon_pegawai()
    {
        return $this->belongsTo(Kasbon_Pegawai::class, 'id_kasbon_pgw', 'id');
    }

    public function master_jaritan()
    {
        return $this->belongsTo(Master_Jaritan::class, 'id_mstr_jaritan', 'id');
    }
}
