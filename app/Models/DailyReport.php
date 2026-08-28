<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyReport extends Model
{
    protected $fillable = [
        'title',
        'description',
        'date',
        'author_id',
        'category',
        'photo_path',
        'writer_name',
        'is_published',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
