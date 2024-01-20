<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    use HasFactory;

    protected $table = 'pengeluaran';
    protected $fillable = [
        'id_mstr_pengeluaran',
        'tanggal',
        'metode_pembayaran',
        'jmlh_bayar_awal',
        'subtotal',
        'keterangan',
        'bukti_pembayaran',
    ];

    public function master_pengeluaran()
    {
        return $this->belongsToMany(Master_Pengeluaran::class, 'id_mstr_pengeluaran', 'id');
    }
}
