<?php


namespace App\Livewire\Instructor;


use Livewire\Component;
use App\Models\Course;


class StudentProgress extends Component
{
    public $course;


    public function mount($courseId)
    {
        $this->course = Course::with(['lessons.watchLogs.user'])->findOrFail($courseId);
    }


    public function render()
    {
        return view('livewire.instructor.student-progress');
    }
}
