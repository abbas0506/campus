<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseAllocation extends Model
{
    use HasFactory;
    protected $fillable = [
        'section_id',
        'semester_no',
        'course_id',    //optional course id
        'scheme_detail_id',
        'teacher_id',
        'semester_id',

    ];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
    public function scheme_detail()
    {
        return $this->belongsTo(SchemeDetail::class);
    }
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function registered()
    {
    }
    public function unregistered()
    {
    }
    public function registrations()
    {
        $course_track_ids = CourseTrack::where('course_id', $this->course_id)->pluck('id')->toArray();
        $results = Result::where('teacher_id', $this->teacher_id)
            ->where('semester_id', session('semester_id'))
            ->whereIn('course_track_id', $course_track_ids)
            ->get();

        return $results;
    }
    public function registered_course_tracks()
    {
        // $course_tracks = CourseTrack::where('course_id', $this->course_id)
        //     ->where('program_id', $this->scheme_detail->scheme->program_id);
        $course_allocation = CourseAllocation::find($this->id);
        $course_tracks = CourseTrack::whereHas(
            'results',
            function ($q) use ($course_allocation) {
                return $q
                    ->where('teacher_id', $course_allocation->teacher_id)
                    ->where('semester_id', session('semester_id'));
            }
        )->where('course_id', $course_allocation->course_id)
            ->where('program_id', $course_allocation->scheme_detail->scheme->program_id)
            ->get();

        return $course_tracks;
    }

    public function results()
    {
        // $course_track_ids = CourseTrack::where('course_id', $this->course_id)->pluck('id')->toArray();
        // return $this->semester->results
        //     ->where('teacher_id', $this->teacher_id)
        //     ->whereIn('course_track_id', $course_track_ids);
        return $this->hasMany(FirstAttempt::class);
    }
    public function first_attempts()
    {
        return $this->hasMany(FirstAttempt::class);
    }
}
