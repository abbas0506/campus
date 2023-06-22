<?php

namespace App\Http\Controllers\teacher;

use App\Http\Controllers\Controller;
use App\Models\CourseAllocation;
use App\Models\Student;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    //
    public function fresh($id)
    {
        $course_allocation = CourseAllocation::find($id);

        $first_attempts = $course_allocation->first_attempts();
        $student_ids = $first_attempts->pluck('student_id')->toArray();

        $registered = Student::whereIn('id', $student_ids)
            ->where('section_id', $course_allocation->course_id)->get();

        //get not registered students
        $unregistered = Student::whereNotIn('id', $student_ids)
            ->where('section_id', $course_allocation->section_id)->get();

        return view('teacher.enroll.fresh', compact('course_allocation', 'unregistered'));
    }

    public function reappear($id)
    {
        $course_allocation = CourseAllocation::find($id);
        return view('teacher.enroll.reappear', compact('course_allocation'));
    }
}
