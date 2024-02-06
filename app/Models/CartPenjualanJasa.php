<?php

namespace App\Models;

use App\Models\Master_Jaritan;
use App\Models\Penjualan_Jasa_Jarit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CartPenjualanJasa extends Model
{
    use HasFactory;

    protected $table = 'cart_penjualan_jasa';
    protected $fillable = [
        'id_penjualan_jasa',
        'id_mstr_jaritan',
        'jumlah_barang',
        'harga_satuan',
        'subtotal'
    ];

    public function penjualan_jasa(){
        return $this->belongsTo(Penjualan_Jasa_Jarit::class, 'id_penjualan_jasa', 'id');
    }

    public function master_jaritan(){
        return $this->belongsTo(Master_Jaritan::class, 'id_mstr_jaritan', 'id');
    }

}
