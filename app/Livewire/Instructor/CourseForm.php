<?php

namespace App\Livewire\Instructor;


use Livewire\Component;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class CourseForm extends Component
{
    public $title, $description, $price;


    protected $rules = [
        'title' => 'required|min:3',
        'description' => 'nullable',
        'price' => 'nullable|numeric'
    ];


    public function save()
    {
        $this->validate();


        Course::create([
            'instructor_id' => Auth::id(),
            'title' => $this->title,
            'slug' => Str::slug($this->title) . '-' . uniqid(),
            'description' => $this->description,
            'price' => $this->price,
        ]);


        session()->flash('success', 'Course created!');
        return redirect()->route('instructor.courses');
    }


    public function render()
    {
        return view('livewire.instructor.course-form');
    }
}
