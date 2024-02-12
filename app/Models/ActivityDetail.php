<?php

namespace App\Models;

use App\Models\ActivityItem;
use App\Models\Pgwr_Activity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ActivityDetail extends Model
{
    use HasFactory;

    protected $table = 'activity_details';
    protected $fillable = [
        'id_pgwr_activity',
        'tanggal',
        'gaji_harian',
    ];

    public function pgwr_activity()
    {
        return $this->belongsTo(Pgwr_Activity::class, 'id_pgwr_activity', 'id');
    }

    public function activity_items()
    {
        return $this->hasMany(ActivityItem::class, 'id_activity_detail', 'id');
    }
}
