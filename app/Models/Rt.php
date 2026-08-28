<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rt extends Model
{
    protected $fillable = [
        'name',
    ];

    public function organizationalMembers()
    {
        return $this->hasMany(OrganizationalMember::class);
    }

    public function residentsStatistic()
    {
        return $this->hasOne(ResidentsStatistic::class);
    }
}
