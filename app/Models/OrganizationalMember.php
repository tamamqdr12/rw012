<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganizationalMember extends Model
{
    /**
     * Atribut pengurus yang dapat diisi melalui formulir admin.
     */
    protected $fillable = [
        'name',
        'role',
        'rt_id',
        'photo_path',
        'contact_info',
        'period',
        'is_active',
        'is_karang_taruna',
    ];

    public function rt()
    {
        return $this->belongsTo(Rt::class);
    }
}
