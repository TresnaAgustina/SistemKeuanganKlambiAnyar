<?php

namespace App\Models;

use App\Models\ActivityItem;
use App\Models\Penjualan_Jasa_Jarit;
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


    // penjualan_jasa_jarit
    public function penjualan_jasa_jarit()
    {
        return $this->hasMany(PenjualanJasaJarit::class);
    }

    // activity_items
    public function activity_items()
    {
        return $this->hasMany(ActivityItem::class);
    }
}
