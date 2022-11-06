<?php

namespace App\Http\Controllers\teacher;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CourseAllocation;
use App\Models\Section;
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
        $teacher = Auth::user()->teacher;
        $section_ids = CourseAllocation::where('teacher_id', $teacher->id)->distinct()->pluck('section_id')->toArray();
        $sections = Section::whereIn('id', $section_ids)->get();

        return view('teacher.mycourses.index', compact('sections', 'teacher'));
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

        //get registered students 
        $registrations = $course_allocation->results;
        $registered_student_ids = $registrations->pluck('student_id')->toArray();

        //get not notregistered students
        $unregistered = Student::whereNotIn('id', $registered_student_ids)->get();

        //get reappear students

        return view('teacher.mycourses.show', compact('course_allocation', 'registrations', 'unregistered'));
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
}
