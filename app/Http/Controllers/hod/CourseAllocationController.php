<?php

namespace App\Http\Controllers\hod;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseAllocation;
use App\Models\Department;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class CourseAllocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $department = Department::find(session('department_id'));
        return view('hod.course-allocations.index', compact('department'));
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
        if ($course_allocation->course()->exists())
            return view('hod.course-allocations.show', compact('course_allocation'));
        else {
            // enlist courses for selection
            $courses = Course::where('course_type_id', $course_allocation->slot_option->course_type_id)
                ->where('department_id', session('department_id'))
                ->where('id', '<>', $course_allocation->course_id)
                ->whereRaw('cr_theory+cr_practical=' . $course_allocation->slot_option->slot->cr)
                ->get();

            return redirect()->route('hod.course-allocations.courses', $course_allocation);
            // return view('hod.course-allocations.courses', compact('course_allocation', 'courses'));
        }
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
        try {
            $course_allocation = CourseAllocation::find($id);
            // if request for course update, check for its prerequiste course 
            if ($request->course_id) {
                $course = Course::find($request->course_id);
                if ($course->prerequisite_course()->exists() && !$course_allocation->section->course_allocations()->before(session('semester_id'))->contains($course->prerequisite_course_id)) {
                    return redirect()->back()->with('warning', 'Pre-requisite course "' . $course->prerequisite_course->code . " " . $course->prerequisite_course->name . ' ' . $course->prerequisite_course->lblCr() . '" required!');
                }
            }
            $course_allocation->update($request->all());
            return redirect()->route('hod.semester-plan.show', $course_allocation->section)->with('success', "Successfully saved");
        } catch (Exception $e) {
            echo $e->getMessage();
            // something went wrong
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
        try {
            $course_allocation = CourseAllocation::find($id);
            $course_allocation->course_id = null;
            $course_allocation->teacher_id = null;
            $course_allocation->update();
            return redirect()->route('hod.semester-plan.show', $course_allocation->section)->with('success', 'Successfully removed');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }

    // assign course to a given course allocation slot
    public function courses($id)
    {

        $course_allocation = CourseAllocation::find($id);
        $courses = Course::where('course_type_id', $course_allocation->slot_option->course_type_id)
            ->where('department_id', session('department_id'))
            ->where('id', '<>', $course_allocation->course_id)
            ->whereRaw('cr_theory+cr_practical=' . $course_allocation->slot_option->slot->cr)
            ->get();
        return view('hod.course-allocations.courses', compact('course_allocation', 'courses'));
    }

    public function teachers($course_allocation_id)
    {
        $course_allocation = CourseAllocation::find($course_allocation_id);
        $teachers = User::whereRelation('roles', 'name', 'teacher')
            ->where('id', '<>', $course_allocation->teacher_id)
            ->where('is_active', 1)
            ->get();
        return view('hod.course-allocations.teachers', compact('course_allocation', 'teachers'));
    }
}
