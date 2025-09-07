<?php

namespace App\Livewire\Student;

use Livewire\Component;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\WatchLog;
use Illuminate\Support\Facades\Auth;

class CourseDetail extends Component
{
    public $course;
    public $isEnrolled = false;
    public $progress = [];

    public function mount($courseId)
    {
        $this->course = Course::with('lessons')->findOrFail($courseId);

        $this->isEnrolled = Enrollment::where('user_id', Auth::id())
            ->where('course_id', $this->course->id)
            ->exists();

        // later we can load progress per lesson
        $this->progress = Watchlog::where('user_id', auth()->id())
        ->whereIn('lesson_id', $this->course->lessons->pluck('id'))
        ->get()
        ->mapWithKeys(function ($log) {
            if ($log->lesson->duration && $log->lesson->duration > 0) {
                $percent = round(($log->watched_seconds / $log->lesson->duration) * 100);
            } else {
                $percent = 0;
            }
            return [$log->lesson_id => $percent];
        })
        ->toArray();
    }

    public function enroll()
    {
        if ($this->course->price > 0) {
            session()->flash('error', 'This course requires payment.');
            return;
        }

        Enrollment::firstOrCreate([
            'user_id' => Auth::id(),
            'course_id' => $this->course->id,
        ]);

        return redirect()->route('student.enrollments')
            ->with('success', 'You have been enrolled successfully!');
    }

    public function render()
    {
        return view('livewire.student.course-detail')
            ->layout('layouts.app');
    }
}
