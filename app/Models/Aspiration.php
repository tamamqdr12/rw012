<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aspiration extends Model
{
    protected $fillable = [
        'sender_name',
        'contact_info',
        'category',
        'title',
        'message',
        'photo_path',
        'response',
        'status',
    ];
}
