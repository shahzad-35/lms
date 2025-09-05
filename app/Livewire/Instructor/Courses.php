<?php

namespace App\Livewire\Instructor;

use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Courses extends Component
{
    public $courses;


    public function mount()
    {
        $this->courses = Course::where('instructor_id', Auth::id())->get();
    }

    public function render()
    {
        return view('livewire.instructor.courses');
    }
}
