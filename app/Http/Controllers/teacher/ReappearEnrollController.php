<?php

namespace App\Http\Controllers\teacher;

use App\Http\Controllers\Controller;
use App\Models\CourseAllocation;
use App\Models\FirstAttempt;
use App\Models\Reappear;
use App\Models\Student;
use Exception;
use Illuminate\Http\Request;

class ReappearEnrollController extends Controller
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
        // $request->validate([
        //     'course_allocation_id' => 'required|numeric',
        //     'rollno' => 'required|numeric',
        // ]);
        // $course_allocation = CourseAllocation::find($request->course_allocation_id);
        // $student = Student::where('rollno', $request->rollno)->first();
        // $first_attempt = FirstAttempt::where('student_id', $student->id)
        //     ->where('program_id', $course_allocation->scheme_detail->scheme->program->id)
        //     ->where('course_id', $course_allocation->course_id)
        //     ->first();

        // $request->merge([
        //     'first_attempt_id' => $first_attempt->id,
        //     'semester_id' => $course_allocation->semester_id,
        //     'semester_no' => $course_allocation->semester_no,
        // ]);

        // try {
        //     Reappear::create($request->all());
        //     return response()->json(['msg' => "Successful"]);
        // } catch (Exception $e) {
        //     return response()->json(['msg' => $e->getMessage()]);
        //     // something went wrong
        // }
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
