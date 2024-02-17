<?php

namespace App\Models;

use App\Models\ActivityDetail;
use App\Models\Master_Jaritan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ActivityItem extends Model
{
    use HasFactory;

    protected $table = 'activity_items';
    protected $fillable = [
        'id_activity_detail',
        'id_mstr_jaritan',
        'jumlah_jaritan',
        'total_bayaran',
    ];

    public function activity_detail()
    {
        return $this->belongsTo(ActivityDetail::class, 'id_activity_detail', 'id');
    }

    public function master_jaritan()
    {
        return $this->belongsTo(Master_Jaritan::class, 'id_mstr_jaritan', 'id');
    }
}
