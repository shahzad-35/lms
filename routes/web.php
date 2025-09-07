<?php

use App\Http\Controllers\PaymentController;
use App\Livewire\Student\CourseDetail;
use App\Livewire\Student\MyEnrollments;
use App\Livewire\Student\StudentCourses;
use App\Livewire\Instructor\StudentProgress;
use App\Livewire\Student\CourseView;
use App\Livewire\Student\LessonView;
use Illuminate\Support\Facades\Route;
use App\Livewire\Instructor\Courses;
use App\Livewire\Instructor\CourseForm;
use App\Livewire\Instructor\LessonForm;
use Illuminate\Support\Facades\Auth;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');

Route::middleware(['auth', 'role:instructor'])->prefix('instructor')->name('instructor.')->group(function () {
    Route::get('/courses', Courses::class)->name('courses');
    Route::get('/courses/create', CourseForm::class)->name('courses.create');
    Route::get('/courses/{course}/lessons/create', LessonForm::class)->name('lessons.create');
    Route::get('/courses/{course}/progress', StudentProgress::class)->name('courses.progress');
});

Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/courses/{courseId}', CourseView::class)->name('courses.view');
    Route::get('/lessons/{lessonId}', LessonView::class)->name('lessons.view');
    Route::get('/courses', StudentCourses::class)->name('courses');
    // Route::get('/courses/{course}', CourseDetail::class)->name('course.show');
    Route::get('/enrollments', MyEnrollments::class)->name('enrollments');

    Route::post('/payment/pay', [PaymentController::class, 'pay'])
    ->name('payment.pay');

    Route::get('/courses_detail/{courseId}', CourseDetail::class)
        ->name('courses.detail');

});

require __DIR__ . '/auth.php';
