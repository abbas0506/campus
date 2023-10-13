<?php

namespace App\Http\Controllers\hod;

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
            'rollno' => 'required',
            'course_allocation_id' => 'required|numeric',
        ]);

        $student = Student::where('rollno', $request->rollno)->first();
        $requested_course_allocation = CourseAllocation::find($request->course_allocation_id);
        //search for an attempt in the course before current semester
        $basic_attempt_in_course = $student->first_attempts()
            ->course($requested_course_allocation->course_id)
            ->where('semester_id', '<', $requested_course_allocation->semester_id)
            ->first();

        // intitally reset eligiblity to reappear in the course
        $eligible_to_reappear = 0;

        if (!$basic_attempt_in_course)
            return redirect()->back()->with('warning', 'Student has never apeared in this course!');
        else {
            $last_attempt_in_course = $basic_attempt_in_course;
            foreach ($basic_attempt_in_course->reappears as $later_attempt)
                $last_attempt_in_course = $later_attempt;

            if ($last_attempt_in_course->obtained() < 50) {
                //failure case,  allow reeappear
                $eligible_to_reappear = 1;
            } elseif ($last_attempt_in_course->gpa() < 3.5) {
                //passed but low gp, eligible for improvement
                //improvement chances can also be tested here
                $eligible_to_reappear = 1;
            } else
                return redirect()->back()->with('warning', 'Student has already passed the course with GP >=3.5!');
        }

        if ($eligible_to_reappear) {
            // check if already enrolled in the same course during same semester
            $already_enrolled = Reappear::where('first_attempt_id', $basic_attempt_in_course->id)
                ->where('course_allocation_id', $requested_course_allocation->id)
                ->where('semester_id', $requested_course_allocation->semester_id)
                ->count();
            if ($already_enrolled) {
                return redirect()->back()->with('warning', 'Already enrolled in the same course!');
            } else {
                //previously not enrolled 
                try {
                    Reappear::create([
                        'first_attempt_id' => $basic_attempt_in_course->id,
                        'semester_id' => $requested_course_allocation->semester_id,
                        'course_allocation_id' => $requested_course_allocation->id,
                    ]);
                    return redirect()->back()->with('success', 'Successfully added');
                } catch (Exception $e) {
                    return redirect()->back()->withErrors($e->getMessage());
                    // something went wrong
                }
            }
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
