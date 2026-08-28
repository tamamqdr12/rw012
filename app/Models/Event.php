<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    /**
     * Atribut kegiatan yang dapat diisi melalui formulir admin.
     */
    protected $fillable = [
        'title',
        'description',
        'event_date',
        'event_time',
        'location',
        'organizer',
        'photo_path',
        'status',
    ];
}
