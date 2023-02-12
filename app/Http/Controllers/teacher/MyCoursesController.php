<?php

namespace App\Http\Controllers\teacher;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CourseAllocation;
use App\Models\Student;

class MyCoursesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $teacher = Auth::user();
        $course_allocations = $teacher->course_allocations;
        return view('teacher.mycourses.index', compact('course_allocations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $course_allocation = CourseAllocation::find($id);

        //get all registrations for the selected course
        $first_attempts = $course_allocation->first_attempts();
        $student_ids = $first_attempts->pluck('student_id')->toArray();

        $registered = Student::whereIn('id', $student_ids)
            ->where('section_id', $course_allocation->course_id)->get();

        //get not registered students
        $unregistered = Student::whereNotIn('id', $student_ids)
            ->where('section_id', $course_allocation->section_id)->get();

        return view('teacher.mycourses.show', compact('course_allocation', 'registered', 'unregistered'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //

    }
    public function enrollFresh($id)
    {
        $course_allocation = CourseAllocation::find($id);

        $first_attempts = $course_allocation->first_attempts();
        $student_ids = $first_attempts->pluck('student_id')->toArray();

        $registered = Student::whereIn('id', $student_ids)
            ->where('section_id', $course_allocation->course_id)->get();

        //get not registered students
        $unregistered = Student::whereNotIn('id', $student_ids)
            ->where('section_id', $course_allocation->section_id)->get();

        return view('teacher.mycourses.enroll.fresh', compact('course_allocation', 'unregistered'));
    }
    public function enrollReappear($id)
    {
        $course_allocation = CourseAllocation::find($id);
        return view('teacher.mycourses.enroll.reappear', compact('course_allocation'));
    }
}
