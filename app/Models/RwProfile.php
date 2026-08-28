<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RwProfile extends Model
{
    protected $fillable = [
        'name',
        'village',
        'district',
        'city',
    ];
}
