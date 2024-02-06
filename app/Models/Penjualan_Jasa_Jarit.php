<?php

namespace App\Models;

use App\Models\Piutang;
use App\Models\Keuangan;
use App\Models\Master_Jaritan;
use App\Models\Master_Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Penjualan_Jasa_Jarit extends Model
{
    use HasFactory;
    protected $table = 'penjualan_jasa_jarit';

    protected $fillable = [
        'id_customer',
        'kode_penjualan',
        'tanggal',
        'metode_pembayaran',
        'jmlh_bayar_awal',
        'tgl_jatuh_tempo',
        'jmlh_dibayar',
        'keterangan',
        'bukti_pembayaran',
    ];

    public function piutang(){
        return $this->hasOne(Piutang::class, 'id_jual_jasa', 'id');
    }

    public function customer(){
        return $this->belongsTo(Master_Customer::class, 'id_customer', 'id');
    }

    public function cart_penjualan_jasa(){
        return $this->hasMany(CartPenjualanJasa::class, 'id_penjualan_jasa', 'id');
    }
}
