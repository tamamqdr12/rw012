<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = [
        'title',
        'content',
        'photo_path',
        'is_pinned',
        'publish_date',
        'is_active',
    ];
}
