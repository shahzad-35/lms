<?php


namespace App\Livewire\Student;


use Livewire\Component;
use App\Models\Lesson;
use Illuminate\Support\Facades\Auth;


class LessonView extends Component
{
    public $lesson;


    public function mount($lessonId)
    {
        $this->lesson = Lesson::with('course')->findOrFail($lessonId);


        // Security: ensure student is enrolled
        if (!$this->lesson->course->enrollments()->where('user_id', Auth::id())->exists()) {
            abort(403, 'Not enrolled');
        }
    }


    public function render()
    {
        return view('livewire.student.lesson-view');
    }
}
