<?php

namespace App\Http\Controllers\teacher;

use App\Http\Controllers\Controller;
use App\Models\CourseAllocation;
use App\Models\FirstAttempt;
use App\Models\Reappear;
use App\Models\Student;
use Exception;
use Illuminate\Http\Request;

class ReappearController extends Controller
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
        $request->validate([
            'course_allocation_id' => 'required|numeric',
            'rollno' => 'required',
        ]);
        $course_allocation = CourseAllocation::find($request->course_allocation_id);
        $student = Student::where('rollno', $request->rollno)->first();

        // echo $first_attempt->toJson();
        // echo $student->first_attempts->first()->toJson();
        $first_attempt = $student->first_attempts->first();
        // $first_attempt = FirstAttempt::where('student_id', $student->id)
        //     ->where('course_allocation_id', $request->course_allocation_id)
        //     ->first();

        // echo $first_attempt->toJson();


        // stop if already registered in the same semester
        if ($first_attempt) {
            $exists = Reappear::where('first_attempt_id', $first_attempt->id)
                ->where('course_allocation_id', $course_allocation->id)
                ->where('semester_id', $course_allocation->semester_id)
                ->count();
            if ($exists > 0) {
                return redirect()->back()->with('error', 'Already enrolled!');
            } else {

                //if last cgp above 3.5 cant register 
                if ($first_attempt->last_gpa() > 3.5) {
                    return redirect()->back()->with('error', 'CGP above 3.5, not eligible!');
                } else {
                    try {
                        $request->merge([
                            'first_attempt_id' => $first_attempt->id,
                            'semester_id' => $course_allocation->semester_id,
                            'semester_no' => $course_allocation->semester_no,
                        ]);
                        Reappear::create($request->all());
                        return redirect()->back()->with('success', 'Successfully added');
                    } catch (Exception $e) {
                        return redirect()->back()->withErrors($e->getMessage());
                        // something went wrong
                    }
                }
            }
        } else {
            return redirect()->back()->with('error', 'Data not found!');
        }
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
        try {
            $reappear = Reappear::find($id);
            $reappear->delete();
            return redirect()->back()->with('success', 'Successfully removed');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
