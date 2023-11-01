<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Mail\SendTwoFaCodeMail;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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
        'is_regular',
        'is_active',
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



    public function allocated_fresh()
    {
        return $this->hasManyThrough(FirstAttempt::class, CourseAllocation::class, 'teacher_id');
    }
    public function allocated_reappears()
    {
        return $this->hasManyThrough(Reappear::class, CourseAllocation::class, 'teacher_id');
    }
    public function headships()
    {
        return  $this->hasMany(Headship::class);
    }

    public function intern_programs()
    {
        return $this->hasMany(Program::class, 'internal_id');
    }
    public function cdr_programs()
    {
        return $this->hasMany(Program::class, 'coordinator_id');
    }
    public function intern_students_count()
    {
        $count = 0;
        foreach ($this->intern_course_allocations()->get() as $allocation) {
            $count += $allocation->first_attempts->count();
        }
        return $count;
    }
    public function cdr_departments()
    {
        return Department::whereRelation('programs.coordinator', 'coordinator_id', $this->id);
    }
    public function intern_departments()
    {
        return Department::whereRelation('programs.internal', 'internal_id', $this->id);
    }

    public function intern_course_allocations()
    {
        return CourseAllocation::where('semester_id', session('semester_id'))
            ->whereRelation('course', 'department_id', session('department_id'))
            ->whereRelation('section.clas.program', 'internal_id', $this->id)
            ->whereNotNull('course_id')
            ->whereNotNull('teacher_id');
    }

    public function teacher()
    {
        return  $this->hasOne(Teacher::class);
    }
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    public function course_allocations()
    {
        return $this->hasMany(CourseAllocation::class, 'teacher_id')
            ->where('semester_id', session('semester_id'));
    }
    public function notifications_sent()
    {
        return $this->hasMany(Notification::class, 'sender_id');
    }
    public function notifications_received()
    {
        return $this->hasMany(Notification::class, 'receiver_id');
    }
    public function teaching_departments()
    {
        return Department::whereRelation('courses.course_allocations', 'teacher_id', $this->id)->get();
    }

    public function sendCode()
    {
        $code = rand(1000, 9999);

        TwoFa::updateOrCreate(
            ['user_id' => auth()->user()->id],
            ['code' => $code]
        );

        try {

            // $details = [
            //     'title' => 'Mail from admin@es.codifysol.com',
            //     'code' => $code
            // ];

            // Mail::to(auth()->user()->email)->send(new SendTwoFaCodeMail($details));
            Mail::raw('OTP for current session', function ($message) use ($code) {
                $message->to(auth()->user()->email);
                $message->subject($code);
            });
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
