<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'cnic',
        'role',
        'status',
        'department_id',
        'facebook_id',
        'google_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function student()
    {
        return $this->hasOne(Student::class);
    }
    public function headships()
    {
        return  $this->hasMany(Headship::class);
    }
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    public function course_allocations()
    {
        return $this->hasMany(CourseAllocation::class, 'teacher_id')->where('semester_id', session('semester_id'));
    }
    public function teaching_departments()
    {
        return Department::whereRelation('courses.course_allocations', 'teacher_id', $this->id)->get();
    }
}
