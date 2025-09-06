<?php

namespace App\Livewire\Student;

use Livewire\Component;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Auth;

class MyEnrollments extends Component
{
    public $enrollments;

    public function mount()
    {
        $this->enrollments = Enrollment::with('course')
            ->where('user_id', Auth::id())
            ->get();
    }

    public function render()
    {
        return view('livewire.student.my-enrollments');
    }
}
