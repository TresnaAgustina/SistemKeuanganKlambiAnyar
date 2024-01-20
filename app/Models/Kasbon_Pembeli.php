<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kasbon_Pembeli extends Model
{
    use HasFactory;

    protected $table = 'kasbon_pembeli';
    protected $fillable = [
        'id_penjualan',
        'jumlah_kasbon',
        'tgl_jatuh_tempo',
        'sisa',
        'status',
    ];

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'id_penjualan', 'id');
    }
}
