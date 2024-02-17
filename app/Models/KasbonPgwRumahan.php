<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KasbonPgwRumahan extends Model
{
    use HasFactory;

    protected $table = 'kasbon_pgw_rumahan';
    protected $fillable = [
        'id_pgw_rumahan',
        'tanggal',
        'jumlah_kasbon',
        'sisa',
        'status'
    ];

    public function pegawai_rumahan()
    {
        return $this->belongsTo(Pegawai_Rumahan::class, 'id_pgw_rumahan');
    }
}
