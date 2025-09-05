<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WatchLog extends Model
{
    protected $fillable = [
        'user_id', 'lesson_id', 'watched_seconds', 'last_position', 'completed'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
}
