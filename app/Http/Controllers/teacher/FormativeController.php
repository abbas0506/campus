<?php

namespace App\Http\Controllers\teacher;

use App\Http\Controllers\Controller;
use App\Models\CourseAllocation;
use App\Models\FirstAttempt;
use App\Models\Reappear;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FormativeController extends Controller
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
        $course_allocation = CourseAllocation::find($id);
        //if phd
        if ($course_allocation->section->clas->program->level == 21)
            return view('teacher.assessment.phd.formative', compact('course_allocation'));
        else
            return view('teacher.assessment.bsms.formative', compact('course_allocation'));
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
        $request->validate([
            'id' => 'required',
            'assignment' => 'required',
            'presentation' => 'required',
            'midterm' => 'required',
            'attempt_type' => "required",
        ]);

        $ids = $request->id;
        $assignment = $request->assignment;
        $presentation = $request->presentation;
        $midterm = $request->midterm;
        $attempt_type = $request->attempt_type;
        DB::beginTransaction();
        try {
            foreach ($ids as $key => $id) {
                if ($attempt_type[$key] == 'F')
                    $attempt = FirstAttempt::find($id);
                else
                    $attempt = Reappear::find($id);

                $attempt->assignment = $assignment[$key];
                $attempt->presentation = $presentation[$key];
                $attempt->midterm = $midterm[$key];

                $attempt->update();
            }
            DB::commit();
            return redirect()->route('teacher.assessment.show', $attempt->course_allocation_id)->with('success', "Formative assessement successful");
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
}
