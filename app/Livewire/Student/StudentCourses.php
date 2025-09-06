<?php

namespace App\Livewire\Student;

use Livewire\Component;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Auth;

class StudentCourses extends Component
{
    public function enroll($courseId)
    {
        Enrollment::firstOrCreate([
            'user_id' => Auth::id(),
            'course_id' => $courseId,
        ]);

        session()->flash('message', 'Enrolled successfully!');
    }

    public function render()
    {
        $courses = Course::withCount('students')->get();
        $user = Auth::user();

        return view('livewire.student.courses', [
            'courses' => $courses,
            'user' => $user,
        ]);
    }
}
