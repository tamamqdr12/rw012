<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResidentsStatistic extends Model
{
    protected $fillable = [
        'rt_id',
        'male_count',
        'female_count',
        'total_count',
        'total_kk',
    ];

    public function rt()
    {
        return $this->belongsTo(Rt::class);
    }
}
