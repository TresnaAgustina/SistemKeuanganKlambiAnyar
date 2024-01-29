<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $table = 'penjualan';
    protected $fillable = [
        'id_mstr_jaritan',
        'kode_penjualan',
        'tanggal',
        'nama_pembeli',
        'no_telp',
        'metode_pembayaran',
        'jmlh_bayar_awal',
        'subtotal',
        'keterangan',
        'bukti_pembayaran',
    ];

    public function master_jaritan()
    {
        return $this->belongsToMany(MasterJaritan::class, 'id_mstr_jaritan', 'id');
    }
}
