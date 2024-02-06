<?php

namespace App\Models;

use App\Models\CartPenjualanLain;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Master_Barang extends Model
{
    use HasFactory;
    protected $table = 'master_barang';
    protected $fillable = [
        'nama_barang',
        'harga_beli',
        'harga_jual'
    ];

    // cart_penjualan_lain
    public function cart_penjualan_lain(){
        return $this->hasMany(CartPenjualanLain::class, 'id_mstr_barang', 'id');
    }
}
