<?php

namespace App\Http\Controllers\teacher;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\CourseAllocation;
use AgliPanci\LaravelCase\Query\CaseBuilder;
use App\Models\FirstAttempt;
use Exception;
use Illuminate\Http\Request;

class AssessmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

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

        $course_allocation = CourseAllocation::findOrFail($id);
        return view('teacher.assessment.index', compact('course_allocation'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //final submission
        $course_allocation = CourseAllocation::findOrFail($id);
        return view('teacher.assessment.edit', compact('course_allocation'));
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
        $course_allocation = CourseAllocation::findOrFail($id);
        try {
            $course_allocation->submitted_at = now();
            $course_allocation->update();
            return redirect()->route('teacher.mycourses.index', $course_allocation)->with('success', "Successfully updated");
        } catch (Exception $ex) {
            DB::rollBack();
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
    public function preview($id)
    {
        $course_allocation = CourseAllocation::findOrFail($id);

        //if phd
        if ($course_allocation->section->clas->program->level == 21)
            return view('teacher.assessment.phd.preview', compact('course_allocation'));
        else
            return view('teacher.assessment.bsms.preview', compact('course_allocation'));
    }
}
