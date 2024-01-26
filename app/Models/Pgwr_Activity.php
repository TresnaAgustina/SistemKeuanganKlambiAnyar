<?php

namespace App\Models;

use App\Models\Pegawai_Rumahan;
use App\Models\Master_Jaritan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pgwr_Activity extends Model
{
    use HasFactory;

    protected $table = 'pgwr_activities';
    protected $fillable = [
        'nama',
        'id_pgw_rumahan',
        'id_mstr_jahitan',
        'tanggal',
        'jumlah_jaritan',
        'total_jaritan',
        'total_bayaran',
    ];

    public function pegawai_rumahan()
    {
        return $this->belongsTo(Pegawai_Rumahan::class, 'id_pgw_rumahan', 'id');
    }

    public function master_jaritan()
    {
        return $this->belongsToMany(Master_Jaritan::class, 'id_mstr_jahitan', 'id');
    }
}
