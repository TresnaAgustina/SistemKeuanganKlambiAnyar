<?php

namespace App\Models;

use App\Models\Penjualan_Lain;
use App\Models\Penjualan_Jasa_Jarit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Master_Customer extends Model
{
    use HasFactory;

    protected $table = 'master_customer';
    protected $fillable = [
        'nama_customer',
        'alamat_customer',
        'no_telp_customer',
        'status_customer',
    ];

    public function penjualan_jasa_jarit(){
        return $this->hasMany(Penjualan_Jasa_Jarit::class, 'id_customer', 'id');
    }

    public function penjualan_lain(){
        return $this->hasMany(Penjualan_Lain::class, 'id_customer', 'id');
    }
}
