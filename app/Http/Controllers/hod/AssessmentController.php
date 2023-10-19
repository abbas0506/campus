<?php

namespace App\Http\Controllers\hod;

use App\Http\Controllers\Controller;
use App\Models\CourseAllocation;
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
        // $course_allocations = CourseAllocation::where('semester_id', session('semester_id'))
        //     // ->whereRelation('section.clas.program.department', 'department_id', session('department_id'))
        //     ->whereNotNull('course_id')
        //     ->whereNotNull('teacher_id')
        //     ->join('sections', 'section_id', 'sections.id')
        //     ->join('clases', 'clas_id', 'clases.id')
        //     ->join('programs', 'program_id', 'programs.id')
        //     ->orderBy('programs.id')
        //     ->get();

        $course_allocations = CourseAllocation::Join('sections', 'section_id', 'sections.id')
            ->Join('clas', 'clas_id', 'clas.id')
            ->join('programs', 'program_id', 'programs.id')
            ->where('semester_id', session('semester_id'))
            ->whereNotNull('course_id')
            ->whereNotNull('teacher_id')
            ->orderBY('programs.id')
            ->orderBY('clas.id')
            ->orderBY('sections.name')
            // ->orderBy('course_allocations.submitted_at', 'desc')
            ->get();

        return view('hod.course-allocations.assessment.index', compact('course_allocations'));
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
