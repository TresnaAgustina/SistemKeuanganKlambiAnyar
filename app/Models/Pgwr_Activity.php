<?php

namespace App\Models;

use App\Models\GajiRumahan;
use App\Models\ActivityDetail;
use App\Models\Master_Jaritan;
use App\Models\Pegawai_Rumahan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pgwr_Activity extends Model
{
    use HasFactory;

    protected $table = 'pgwr_activities';
    protected $fillable = [
        'id_pgw_rumahan',
        'gaji_bulanan',
    ];

    public function pegawai_rumahan()
    {
        return $this->belongsTo(Pegawai_Rumahan::class, 'id_pgw_rumahan', 'id');
    }

    public function activity_details()
    {
        return $this->hasMany(ActivityDetail::class, 'id_pgwr_activity', 'id');
    }

    // to GajiRumahan
    // public function gaji_rumahan()
    // {
    //     return $this->hasOne(GajiRumahan::class, 'id_activity');
    // }
}
