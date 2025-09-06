<?php

namespace App\Livewire\Instructor;


use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Lesson;


class LessonForm extends Component
{
    use WithFileUploads;


    public $course_id, $title, $video;


    protected $rules = [
        'title' => 'required|min:3',
        'video' => 'required|max:51200'

    ];


    public function save()
    {
        $this->validate();
        $path = $this->video->store('lessons', 'public');


        Lesson::create([
            'course_id' => $this->course_id,
            'title' => $this->title,
            'video_path' => $path,
            'order' => 0
        ]);


        session()->flash('success', 'Lesson added!');
        return redirect()->route('instructor.courses');
    }

    public function mount($course)
    {
        $this->course_id = $course;
    }

    public function render()
    {
        return view('livewire.instructor.lesson-form');
    }
}
