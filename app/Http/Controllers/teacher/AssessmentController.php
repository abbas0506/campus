<?php

namespace App\Http\Controllers\teacher;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\CourseAllocation;
use AgliPanci\LaravelCase\Query\CaseBuilder;
use App\Models\FirstAttempt;
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

        // $course_allocation = CourseAllocation::find($id);
        // $subquery = DB::table('first_attempts')
        //     ->selectRaw("id, assignment+presentation+midterm+summative as marks")
        //     ->where('course_allocation_id', $id);

        // // if ($course_allocation->section->clas->program->level == 18) {
        // //     $attempts = FirstAttempt::query()
        // //         ->joinSub($subquery, 'sub', function ($join) {
        // //             $join->on('first_attempts.id', '=', 'sub.id');
        // //         })->selectRaw(
        // //             "first_attempts.*, 
        // //     (CASE 
        // //         WHEN sub.marks>=85 THEN 'A' 
        // //         WHEN sub.marks>=80 THEN 'A-' 
        // //         WHEN sub.marks>=75 THEN 'B+' 
        // //         WHEN sub.marks>=71 THEN 'B' 
        // //         WHEN sub.marks>=68 THEN 'B-' 
        // //         WHEN sub.marks>=64 THEN 'C+' 
        // //         WHEN sub.marks>=61 THEN 'C' 
        // //         WHEN sub.marks>=58 THEN 'C-' 
        // //         WHEN sub.marks>=54 THEN 'D+' 
        // //         WHEN sub.marks>=50 THEN 'D' 
        // //         ELSE 'F' 
        // //     END) as grade,
        // //     (CASE 
        // //         WHEN sub.marks>=85 THEN 4 
        // //         WHEN sub.marks>=80 THEN 3.66 
        // //         WHEN sub.marks>=75 THEN 3.33 
        // //         WHEN sub.marks>=71 THEN 3 
        // //         WHEN sub.marks>=68 THEN 2.66 
        // //         WHEN sub.marks>=64 THEN 2.33 
        // //         WHEN sub.marks>=61 THEN 2 
        // //         WHEN sub.marks>=58 THEN 1.66 
        // //         WHEN sub.marks>=54 THEN 1.33 
        // //         WHEN sub.marks>=50 THEN 1 
        // //     ELSE 0 
        // //     END) as gpa"

        // //         )
        // //         ->where('course_allocation_id', $id)
        // //         ->get();
        // // } else {
        // //     // BS or PhD case
        // //     $attempts = FirstAttempt::query()
        // //         ->joinSub($subquery, 'sub', function ($join) {
        // //             $join->on('first_attempts.id', '=', 'sub.id');
        // //         })->selectRaw(
        // //             "first_attempts.*, 
        // // (CASE 
        // //     WHEN sub.marks>=90 THEN 'A+' 
        // //     WHEN (sub.marks-10)*0.05>=3.5 THEN 'A' 
        // //     WHEN (sub.marks-10)*0.05>=3 THEN 'B' 
        // //     WHEN (sub.marks-10)*0.05>=2.5 THEN 'C' 
        // //     WHEN (sub.marks-10)*0.05>=2 THEN 'D' 
        // //     ELSE 'F' 
        // // END) as grade,
        // // (CASE 
        // //     WHEN sub.marks>=90 THEN '4' 
        // //     WHEN sub.marks>=50 THEN (sub.marks-10)*0.05
        // //     ELSE '0' 
        // // END) as gpa"

        // //         )
        // //         ->where('course_allocation_id', $id)
        // //         ->get();
        // // }


        // // if ($course_allocation->section->clas->program->level == 18) {
        // //     $attempts = FirstAttempt::query()
        // //         ->joinSub($subquery, 'sub', function ($join) {
        // //             $join->on('first_attempts.id', '=', 'sub.id');
        // //         })->selectRaw(
        // //             "first_attempts.*, 
        // //             (CASE 
        // //                 WHEN sub.marks>=85 THEN 'A' 
        // //                 WHEN sub.marks>=80 THEN 'A-' 
        // //                 WHEN sub.marks>=75 THEN 'B+' 
        // //                 WHEN sub.marks>=71 THEN 'B' 
        // //                 WHEN sub.marks>=68 THEN 'B-' 
        // //                 WHEN sub.marks>=64 THEN 'C+' 
        // //                 WHEN sub.marks>=61 THEN 'C' 
        // //                 WHEN sub.marks>=58 THEN 'C-' 
        // //                 WHEN sub.marks>=54 THEN 'D+' 
        // //                 WHEN sub.marks>=50 THEN 'D' 
        // //                 ELSE 'F' 
        // //             END) as grade"
        // //         )
        // //         ->where('course_allocation_id', $id)
        // //         ->get();
        // // } else {
        // //     // BS or PhD case
        // //     $attempts = FirstAttempt::query()
        // //         ->joinSub($subquery, 'sub', function ($join) {
        // //             $join->on('first_attempts.id', '=', 'sub.id');
        // //         })->selectRaw(
        // //             "first_attempts.*, 
        // //             (CASE 
        // //                 WHEN sub.marks>=90 THEN 'A+' 
        // //                 WHEN (sub.marks-10)>=3.5 THEN 'A' 

        // //                 ELSE 'F' 
        // //             END) as grade"

        // //         )
        // //         ->where('course_allocation_id', $id)
        // //         ->get();
        // // }

        // echo $course_allocation->section->clas->program->level;

        // $attempts = FirstAttempt::query()
        //     ->case(function (CaseBuilder $case) {
        //         $case->whenRaw('(assignment+presentation+midterm+summative-10)*0.05>60')->then('B')
        //             ->when('assignment', '>', 4)->then('A')
        //             ->else('F');
        //     }, 'grade')
        //     ->where('course_allocation_id', $id)
        //     ->get();


        // foreach ($attempts as $attempt)
        //     echo $attempt->student_id .  ", " . $attempt->course_allocation->course->name . ", " . $attempt->grade . "<br>";
        // // echo $results;
        // // $course_allocation = CourseAllocation::find($id);
        // // if ($course_allocation->section->clas->program->level == 21)
        // //     return view('teacher.assessment.phd.show', compact('course_allocation'));
        // // else
        // //     return view('teacher.assessment.bsms.show', compact('course_allocation'));
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
