<?php

namespace App\Models;

use App\Models\Keuangan;
use App\Models\Master_Pemasukan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pemasukan extends Model
{
    use HasFactory;

    protected $table = 'pemasukan';
    protected $fillable = [
        'id_mstr_pemasukan',
        'tanggal',
        'total',
        'keterangan',
        'bukti_pembayaran',
    ];

    public function master_pemasukan()
    {
        return $this->belongsTo(Master_Pemasukan::class, 'id_mstr_pemasukan', 'id');
    }
}
