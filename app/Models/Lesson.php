<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable = [
        'course_id', 'title', 'video_path', 'duration', 'order'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function watchLogs()
    {
        return $this->hasMany(WatchLog::class);
    }
}
