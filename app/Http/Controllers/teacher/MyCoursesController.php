<?php

namespace App\Http\Controllers\teacher;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseAllocation;
use App\Models\ElectiveCourseAllocation;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Result;

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
        $course_id = $course_allocation->scheme_detail->is_compulsory() ? $course_allocation->scheme_detail->course_id : $course_allocation->course_id;
        $section_id = $course_allocation->section_id;
        $teacher_id = $course_allocation->teacher_id;
        $semester_id = $course_allocation->semester_id;
        $program_id = $course_allocation->section->program_id;

        $mycourse = Course::find($course_id);
        $mycourse_students = Result::where('course_id', $course_id);
        $section = Section::find($section_id);

        //get registered students 
        //get not notregistered students
        //get reappear students

        return view('teacher.mycourses.show', compact('mycourse', 'mycourse_students', 'section'));
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
