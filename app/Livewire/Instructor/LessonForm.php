<?php

namespace App\Livewire\Instructor;


use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Lesson;
use FFMpeg\FFMpeg;


class LessonForm extends Component
{
    use WithFileUploads;


    public $course_id, $title, $video;


    protected $rules = [
        'title' => 'required|min:3',
        'video' => 'required|file|mimes:mp4,avi,mov,wmv|max:51200',
    ];


    public function save()
    {
        $this->validate();
        $path = $this->video->store('lessons', 'public');

        $ffmpeg = FFMpeg::create();
        $video = $ffmpeg->open(storage_path("app/public/{$path}"));
        $duration = $video->getStreams()->videos()->first()->get('duration');

        Lesson::create([
            'course_id' => $this->course_id,
            'title' => $this->title,
            'video_path' => $path,
            'duration' => floor ($duration),
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
