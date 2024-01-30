<?php

namespace App\Models;

use App\Models\Piutang;
use App\Models\Keuangan;
use App\Models\Master_Jaritan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Penjualan_Jasa_Jarit extends Model
{
    use HasFactory;
    protected $table = 'penjualan_jasa_jarit';

    protected $fillable = [
        'id_mstr_jaritan',
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

    public function Master_Jaritan(){
        return $this->belongsTo(Master_Jaritan::class, 'id_mstr_jaritan', 'id');
    }

    public function keuangan(){
        return $this->belongsTo(Keuangan::class, 'id_keuangan', 'id');
    }

    public function piutang(){
        return $this->hasOne(Piutang::class, 'id_jual_jasa', 'id');
    }
}
