<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Mail\SendTwoFaCodeMail;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
    public function teaching_departments()
    {
        return Department::whereRelation('courses.course_allocations', 'teacher_id', $this->id)->get();
    }
    public function allocations()
    {
        $allocations = CourseAllocation::where('teacher_id', $this->id)
            ->where('semester_id', session('semester_id'))
            ->join('sections', 'course_allocations.section_id', '=', 'sections.id')
            ->join('clas', 'sections.clas_id', '=', 'clas.id')
            ->join('shifts', 'clas.shift_id', '=', 'shifts.id')
            ->join('slots', 'course_allocations.slot_id', '=', 'slots.id')
            ->orderBy('clas.program_id')
            ->select('course_allocations.*', 'shifts.short', 'slots.cr');

        return $allocations;
    }

    public function sendCode()
    {
        $code = rand(1000, 9999);

        TwoFa::updateOrCreate(
            ['user_id' => auth()->user()->id],
            ['code' => $code]
        );

        try {

            $details = [
                'title' => 'Mail from admin@es.codifysol.com',
                'code' => $code
            ];

            // Mail::to(auth()->user()->email)->send(new SendTwoFaCodeMail($details));
            Mail::raw('User authentication code', function ($message) use ($code) {
                $message->to(auth()->user()->email);
                $message->subject($code);
            });
        } catch (Exception $e) {
            info("Error: " . $e->getMessage());
        }
    }
}
