<?php

namespace App\Models;

use App\Models\Master_Barang;
use App\Models\Penjualan_Lain;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CartPenjualanLain extends Model
{
    use HasFactory;

    protected $table = 'cart_penjualan_lain';
    protected $fillable = [
        'id_penjualan_lain',
        'id_mstr_barang',
        'jumlah_barang',
        'harga_satuan',
        'subtotal'
    ];

    public function penjualan_lain(){
        return $this->belongsTo(Penjualan_Lain::class, 'id_penjualan_lain', 'id');
    }

    public function master_barang(){
        return $this->belongsTo(Master_Barang::class, 'id_mstr_barang', 'id');
    }
}
