<?php

namespace App\Http\Livewire\Student;

use Livewire\Component;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Auth;

class BrowseCourses extends Component
{
    public $courses;

    public function mount()
    {
        $this->courses = Course::where('is_published', true)->get();
    }

    public function enroll($courseId)
    {
        $user = Auth::user();

        // Check if already enrolled
        if (Enrollment::where('user_id', $user->id)->where('course_id', $courseId)->exists()) {
            session()->flash('info', 'Already enrolled in this course.');
            return;
        }

        Enrollment::create([
            'user_id' => $user->id,
            'course_id' => $courseId,
            'status' => 'active',
        ]);

        session()->flash('success', 'Successfully enrolled!');
        return redirect()->route('student.enrollments');
    }

    public function render()
    {
        return view('livewire.student.browse-courses');
    }
}
