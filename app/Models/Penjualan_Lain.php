<?php

namespace App\Models;

use App\Models\Piutang;
use App\Models\Keuangan;
use App\Models\Master_Barang;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Penjualan_Lain extends Model
{
    use HasFactory;
    protected $table = 'penjualan_lain';

    protected $fillable = [
        'id_mstr_barang',
        'id_keuangan',
        'kode_penjualan',
        'tanggal',
        'nama_pembeli',
        'no_telp',
        'quantity',
        'metode_pembayaran',
        'jmlh_bayar_awal',
        'subtotal',
        'keterangan',
        'bukti_pembayaran',
    ];

    public function Master_Barang(){
        return $this->belongsTo(Master_Barang::class, 'id_mstr_barang', 'id');
    }

    public function keuangan(){
        return $this->belongsTo(Keuangan::class, 'id_keuangan', 'id');
    }

    public function piutang(){
        return $this->hasOne(Piutang::class, 'id_jual_lain', 'id');
    }
}
