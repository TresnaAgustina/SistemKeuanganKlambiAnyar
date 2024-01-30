<?php

namespace App\Models;

use App\Models\Pengeluaran;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Hutang extends Model
{
    use HasFactory;
    protected $table = 'hutang';

    protected $fillable = [
        'id_pengeluaran',
        'jumlah_hutang',
        'tgl_jatuh_tempo',
        'sisa_hutang',
        'status',
    ];

    public function pengeluaran()
    {
        return $this->belongsTo(Pengeluaran::class, 'id_pengeluaran');
    }
}
