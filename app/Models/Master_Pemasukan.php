<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Master_Pemasukan extends Model
{
    use HasFactory;

    protected $table = 'master_pemasukan';
    protected $fillable = [
        'nama_atribut',
    ];


    public function master_pemasukan()
    {
        return $this->hasMany(Pemasukan::class);
    }
}
