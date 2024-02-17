<?php

namespace App\Models;

use App\Models\KasbonPgwRumahan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pegawai_Rumahan extends Model
{
    use HasFactory;

    protected $table = 'pegawai_rumahan';
    protected $fillable = [
        'nama',
        'nip',
        'alamat',
        'no_telp',
        'jenis_kelamin',
        'status'
    ];

    public function kasbon_pegawai()
    {
        return $this->hasMany(KasbonPgwRumahan::class, 'id_pgw_rumahan');
    }
}
