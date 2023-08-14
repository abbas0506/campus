<?php

namespace App\Http\Controllers\teacher;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CourseAllocation;
use App\Models\FirstAttempt;
use App\Models\Reappear;
use App\Models\Shift;
use App\Models\Student;
use Database\Seeders\CourseSeeder;

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
        $teacher = Auth::user();
        $shifts = Shift::all();
        return view('teacher.mycourses.index', compact('teacher', 'shifts'));
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
        // $students = $course_allocation->registered_students()->sortBy('rollno');
        $first_attempts = FirstAttempt::with('student')->where('course_allocation_id', $id)->get()->sortBy('student.rollno');

        // $reappears = Reappear::with([
        //     'first_attempt' => function ($query) {
        //         $query->with(['student' => function ($q) {
        //             $q->orderBy('rollno', 'DESC');
        //         }]);
        //     }
        // ])->get();

        // $reappears = Reappear::all();
        $reappears = Reappear::with('first_attempt')->get()->sortBy('first_attempt.student.rollno');

        // $first_attempts = $course_allocation->first_attempts->with('student')->where('course_allocation_id', $id)->get()->sortByDesc('student.rollno');
        // $first_attempts = FirstAttempt::with(['student' => function ($query) {
        //     $query->orderBy('rollno', 'DESC');
        // }]);
        // echo $reappears;
        // foreach ($first_attempts as $first_attempt) {
        //     echo "<br>" . $first_attempt->student_id . $first_attempt->student->name . ":";
        // }

        // get all registrations for the selected course
        $first_attempts = $course_allocation->first_attempts();
        $student_ids = $first_attempts->pluck('student_id')->toArray();

        $registered = Student::whereIn('id', $student_ids)
            ->where('section_id', $course_allocation->course_id)->get();

        // get not registered students
        $unregistered = Student::whereNotIn('id', $student_ids)
            ->where('section_id', $course_allocation->section_id)->get();

        return view('teacher.mycourses.show', compact('course_allocation', 'registered', 'unregistered'));
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
