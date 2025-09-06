<?php

namespace App\Livewire\Student;

use Livewire\Component;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\WatchLog;
use Illuminate\Support\Facades\Auth;

class CourseDetail extends Component
{
    public $course;        // Course model
    public $isEnrolled = false;
    public $progress = []; // [ lesson_id => percent ]

    /**
     * $course param is the {course} route parameter (id)
     */
    public function mount($course)
    {
        // Load course with lessons (order if you set 'order' field)
        $this->course = Course::with(['lessons' => function ($q) {
            $q->orderBy('order', 'asc');
        }])->findOrFail($course);

        // check enrollment
        $this->isEnrolled = Enrollment::where('user_id', Auth::id())
            ->where('course_id', $this->course->id)
            ->exists();

        if ($this->isEnrolled) {
            $this->calculateProgress();
        }
    }

    /**
     * Enroll current user into this course.
     */
    public function enroll()
    {
        Enrollment::firstOrCreate([
            'user_id' => Auth::id(),
            'course_id' => $this->course->id,
        ], [
            // optional default values
            'status' => 'active',
        ]);

        $this->isEnrolled = true;
        $this->calculateProgress();

        session()->flash('success', 'You are now enrolled.');
        // redirect to my enrollments or stay on page — choose as you prefer:
        return redirect()->route('student.enrollments');
    }

    /**
     * Calculate per-lesson progress in percent for current user.
     * Uses WatchLog.watched_seconds and Lesson.duration (seconds).
     */
    protected function calculateProgress()
    {
        $userId = Auth::id();
        $this->progress = [];

        foreach ($this->course->lessons as $lesson) {
            $percent = 0;

            // If you stored lesson->duration (in seconds), compute percent, otherwise 0
            if ($lesson->duration && $lesson->duration > 0) {
                $log = WatchLog::where('user_id', $userId)
                    ->where('lesson_id', $lesson->id)
                    ->first();

                if ($log) {
                    $percent = min(100, round(($log->watched_seconds / max(1, $lesson->duration)) * 100, 1));
                }
            }

            $this->progress[$lesson->id] = $percent;
        }
    }

    public function render()
    {
        return view('livewire.student.course-detail');
    }
}
