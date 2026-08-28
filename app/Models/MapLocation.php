<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MapLocation extends Model
{
    protected $fillable = [
        'name',
        'type',
        'latitude',
        'longitude',
        'description',
    ];
}
