<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemasukan extends Model
{
    use HasFactory;

    protected $table = 'pemasukan';
    protected $fillable = [
        'id_mstr_pemasukan',
        'tanggal',
        'jumlah',
    ];

    public function master_pemasukan()
    {
        return $this->belongsToMany(Master_Pemasukan::class, 'id_mstr_pemasukan', 'id');
    }
}
