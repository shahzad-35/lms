<?php

namespace App\Livewire\Student;

use Livewire\Component;
use App\Models\Lesson;
use App\Models\WatchLog;
use Illuminate\Support\Facades\Auth;

class LessonView extends Component
{
    public $lesson;
    public $currentTime = 0; // seconds watched

    public function mount($lessonId)
    {
        $this->lesson = Lesson::findOrFail($lessonId);

        $log = WatchLog::where('user_id', Auth::id())
            ->where('lesson_id', $this->lesson->id)
            ->first();

        $this->currentTime = $log->last_position ?? 0;
    }

    public function updateWatch($currentTime)
    {
        $seconds = $currentTime;

        $WatchLog = WatchLog::query()->where('user_id', Auth::id())
            ->where('lesson_id', $this->lesson->id)
            ->first();

        if ($WatchLog) {
            $WatchLog->watched_seconds = $seconds;
            $WatchLog->last_position = $seconds;
            if ($this->lesson->duration && $seconds >= $this->lesson->duration) {
                $WatchLog->completed = true;
            }
            $WatchLog->save();
            return;
        } else {
            // Create new log
            WatchLog::create([
                'user_id' => Auth::id(),
                'lesson_id' => $this->lesson->id,
                'watched_seconds' => $seconds,
                'last_position' => $seconds,
                'completed' => $this->lesson->duration
                    ? ($seconds >= $this->lesson->duration)
                    : false
            ]);
        }
    }

    public function render()
    {
        return view('livewire.student.lesson-view');
    }
}
