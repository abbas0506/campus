<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Department extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'title', //degree title

    ];
    public function programs()
    {
        return $this->hasMany(Program::class);
    }
    public function courses()
    {
        return $this->hasMany(Course::class);
    }
    public function headship()
    {
        return $this->hasOne(Headship::class);
    }
    public function hod()
    {
        return $this->headship->user;
    }
    public function schemes()
    {
        return Scheme::whereRelation('program', 'department_id', $this->id)->get();
    }
    public function teachers()
    {
        return User::whereRelation('roles', 'name', 'teacher')->where('department_id', $this->id)->get();
    }
    public function clases()
    {
        return Clas::whereRelation('program', 'department_id', $this->id);
    }
    public function sections()
    {
        return Section::whereRelation('clas.program', 'department_id', $this->id)->get();
    }
    public function students()
    {
        return Student::whereRelation('section.clas.program', 'department_id', $this->id);
    }

    public function currentStudents()
    {
        $currentSemesterId = session('semester_id');
        return Student::whereRelation('section.clas', function ($query) use ($currentSemesterId) {
            $query->where('first_semester_id', '<=', $currentSemesterId)
                ->where('last_semester_id', '>=', $currentSemesterId)
                ->whereRelation('program', function ($query) {
                    $query->where('department_id', $this->id);
                });
        });
    }
    public function current_allocations()
    {
        // 
        return CourseAllocation::whereRelation('course.department', 'id', $this->id)
            ->where('semester_id', session('semester_id'))
            ->whereNotNull('course_id')
            ->whereNotNull('teacher_id');
    }

    public function currentlyInactiveStudents()
    {
        $currentSemesterId = session('semester_id');
        $inactiveStudents = Student::whereRelation('section.clas', function ($query) use ($currentSemesterId) {
            $query->where('first_semester_id', '<=', $currentSemesterId)
                ->where('last_semester_id', '>=', $currentSemesterId)
                ->whereRelation('program', function ($query) {
                    $query->where('department_id', $this->id);
                });
        })->where('status_id', '>', 1)
            ->get();
        return $inactiveStudents;
    }
}
