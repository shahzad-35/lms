<?php


namespace App\Livewire\Student;


use Livewire\Component;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;


class CourseView extends Component
{
    public $course;


    public function mount($courseId)
    {
        $this->course = Course::with('lessons')->findOrFail($courseId);


        // Optionally check enrollment
        if (!$this->course->enrollments()->where('user_id', Auth::id())->exists()) {
            abort(403, 'Not enrolled');
        }
    }


    public function render()
    {
        return view('livewire.student.course-view');
    }
}
