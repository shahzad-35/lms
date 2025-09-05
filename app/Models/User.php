<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\WatchLog;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;


    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];


    protected $hidden = ['password', 'remember_token'];


    public function courses()
    {
        return $this->hasMany(Course::class, 'instructor_id');
    }


    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }


    public function watchLogs()
    {
        return $this->hasMany(WatchLog::class);
    }
}
