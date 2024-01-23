<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Master_Jaritan extends Model
{
    use HasFactory;

    protected $table = 'master_jaritan';
    protected $fillable = [
        'jenis_jaritan',
        'harga_dalam',
        'harga_luar',
    ];


    // penjualan
    public function penjualan()
    {
        return $this->hasMany(Penjualan::class);
    }

    // bayaran_pegawai_rumahan
    public function bayaran_pegawai_rumahan()
    {
        return $this->hasMany(Bayaran_Pegawai_Rumahan::class);
    }
}
