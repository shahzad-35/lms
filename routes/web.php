<?php

use App\Livewire\Student\CourseView;
use App\Livewire\Student\LessonView;
use Illuminate\Support\Facades\Route;
use App\Livewire\Instructor\Courses;
use App\Livewire\Instructor\CourseForm;
use App\Livewire\Instructor\LessonForm;


Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');


Route::middleware(['auth'])->group(function () {
    Route::middleware('can:is-instructor')->prefix('instructor')->name('instructor.')->group(function () {
        Route::get('/courses', Courses::class)->name('courses');
        Route::get('/courses/create', CourseForm::class)->name('courses.create');
        Route::get('/courses/{course}/lessons/create', LessonForm::class)->name('lessons.create');
    });
    Route::middleware(['auth', 'can:is-student'])->prefix('student')->name('student.')->group(function () {
        Route::get('/courses/{course}', CourseView::class)->name('courses.view');
        Route::get('/lessons/{lesson}', LessonView::class)->name('lessons.view');
    });
});

require __DIR__ . '/auth.php';
