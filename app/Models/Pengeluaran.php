<?php

namespace App\Models;

use App\Models\Hutang;
use App\Models\Keuangan;
use App\Models\Master_Pengeluaran;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pengeluaran extends Model
{
    use HasFactory;

    protected $table = 'pengeluaran';
    protected $fillable = [
        'id_mstr_pengeluaran',
        'id_keuangan',
        'tanggal',
        'metode_pembayaran',
        'subtotal',
        'keterangan',
        'bukti_pembayaran',
    ];

    public function master_pengeluaran()
    {
        return $this->belongsToMany(Master_Pengeluaran::class, 'id_mstr_pengeluaran', 'id');
    }

    public function keuangan()
    {
        return $this->belongsTo(Keuangan::class, 'id_keuangan', 'id');
    }

    public function hutang()
    {
        return $this->hasOne(Hutang::class, 'id_pengeluaran', 'id');
    }

}
