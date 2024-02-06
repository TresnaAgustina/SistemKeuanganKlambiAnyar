<?php

namespace App\Models;

use App\Models\Penjualan_Lain;
use App\Models\Penjualan_Jasa_Jarit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Piutang extends Model
{
    use HasFactory;
    protected $table = 'piutang';

    protected $fillable = [
        'id_jual_lain',
        'id_jual_jasa',
        'jumlah_bayar', // untuk update piutang ketika pelunasan
        'jumlah_piutang',
        'tgl_jatuh_tempo',
        'sisa_piutang',
        'status',
    ];

    public function penjualan_lain()
    {
        return $this->belongsTo(Penjualan_Lain::class, 'id_jual_lain');
    }

    public function penjualan_jasa_jarit()
    {
        return $this->belongsTo(Penjualan_Jasa_Jarit::class, 'id_jual_jasa');
    }
}
