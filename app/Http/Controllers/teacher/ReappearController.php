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

        $student = Student::where('rollno', 'S22-MPHIL-ZOOL-1033')->first();
        $course_allocation = CourseAllocation::find(145);

        echo $course_allocation->semester_id;
        $result = '' . $student->id;
        $roman = config('global.romans');
        if ($student) {
            $first_attempt = FirstAttempt::where('student_id', 3319)
                // ->where('course_allocation_id', 145)
                ->where('semester_id', '<', $course_allocation->semester_id)
                ->first();

            echo $first_attempt->toJson();
            // if ($first_attempt) {
            //     $result .=  $first_attempt->semester->title() .
            //         ',' . $roman[$first_attempt->semester_no - 1] . '<,>' .
            //         '<,>' . $first_attempt->total() . '/100' . '</,>' .
            //         '<,>' . $first_attempt->gpa() . '' .
            //         '<,>' . $first_attempt->grade();

            //     foreach ($first_attempt->reappears->where('semester_id', '<', $course_allocation->semester_id) as $reappear)
            //         $result .= '<tr>' .
            //             '<td>' . $reappear->semester->title() . '</td>' .
            //             '<td>' . $roman[$first_attempt->semester_no - 1] . '</td>' .
            //             '<td>' . $reappear->total() . '/100' . '</td>' .
            //             '<td>' . $reappear->gpa() . '</td>' .
            //             '<td>' . $reappear->grade() . '</td>' .
            //             '</tr>';
            // }
        }
        echo "result" . $result;
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
        $first_attempt = FirstAttempt::where('student_id', $student->id)
            ->where('program_id', $course_allocation->section->clas->program_id)
            ->where('course_id', $course_allocation->course_id)
            ->first();

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
