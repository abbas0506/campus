<?php

namespace App\Http\Controllers\teacher;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\CourseAllocation;
use App\Models\Result;
use App\Models\Section;
use Exception;
use Illuminate\Http\Request;

class ResultController extends Controller
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

        return view('teacher.results.index', compact('sections', 'teacher'));
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
        return view('teacher.results.show', compact('course_allocation'));
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
        $course_allocation = CourseAllocation::find($id);
        return view('teacher.results.edit', compact('course_allocation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $course_allocation_id)
    {
        //
        $request->validate([
            'student_id' => 'required',
            'assignment' => 'required',
            'presentation' => 'required',
            'midterm' => 'required',
            'summative' => 'required',
        ]);


        $students = $request->student_id;
        $assignment = $request->assignment;
        $presentation = $request->presentation;
        $midterm = $request->midterm;
        $summative = $request->summative;
        try {
            foreach ($students as $key => $id) {

                $result = Result::where('student_id', $id)->where('course_allocation_id', $course_allocation_id)->first();

                $result->assignment = $assignment[$key];
                $result->presentation = $presentation[$key];
                $result->midterm = $midterm[$key];
                $result->summative = $summative[$key];

                $result->update();
            }
            return redirect()->back()->with('success', "Successfully added");
        } catch (Exception $ex) {
            return redirect()->back()->withErrors($ex->getMessage());
        }
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
