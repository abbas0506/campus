<?php

namespace App\Http\Controllers\teacher;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CourseAllocation;
use App\Models\CourseTrack;
use App\Models\Section;
use App\Models\Student;
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
        $user = Auth::user();
        $section_ids = CourseAllocation::where('teacher_id', $user->id)->distinct()->pluck('section_id')->toArray();
        $sections = Section::whereIn('id', $section_ids)->get();
        $teacher = $user;

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

        //get all registrations for the selected course
        $results = $course_allocation->results();

        // $registered_course_tracks = CourseTrack::whereHas(
        //     'results',
        //     function ($q) use ($course_allocation) {
        //         return $q
        //             ->where('teacher_id', $course_allocation->teacher_id)
        //             ->where('semester_id', session('semester_id'));
        //     }
        // )->where('course_id', $course_allocation->course_id)->get();

        $registered_course_tracks = $course_allocation->registered_course_tracks();
        $registered_student_ids = $registered_course_tracks->pluck('student_id')->toArray();

        $registered = Student::whereIn('id', $registered_student_ids)
            ->where('section_id', $course_allocation->course_id)->get();

        // // //get not notregistered students
        $unregistered = Student::whereNotIn('id', $registered_student_ids)
            ->where('section_id', $course_allocation->section_id)->get();

        // // //get reappear students

        return view('teacher.mycourses.show', compact('course_allocation', 'results', 'registered_course_tracks', 'registered', 'unregistered'));
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
