<?php

namespace App\Models;

use App\Models\Penjualan_Lain;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Master_Barang extends Model
{
    use HasFactory;
    protected $table = 'barang';
    protected $fillable = [
        'nama_barang',
        'harga_beli',
        'harga_jual'
    ];

    public function Penjualan_Lain(){
        return $this->hasMany(Penjualan_Lain::class);
    }

}
