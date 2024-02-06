<?php

namespace App\Models;

use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use App\Models\Penjualan_Lain;
use App\Models\Penjualan_Jasa_Jarit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Keuangan extends Model
{
    use HasFactory;

    protected $table = 'keuangan';
    protected $fillable = [
        'saldo_bank',
        'saldo_kas',
    ];

    public function pemasukan()
    {
        return $this->hasMany(Pemasukan::class);
    }

    public function pengeluaran()
    {
        return $this->hasMany(Pengeluaran::class);
    }

    public function penjualan_lain()
    {
        return $this->hasMany(Penjualan_Lain::class);
    }

    public function penjualan_jasa_jarit()
    {
        return $this->hasMany(Penjualan_Jasa_Jarit::class);
    }

    
}
