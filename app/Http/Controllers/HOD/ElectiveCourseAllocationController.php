<?php

namespace App\Http\Controllers\hod;

use App\Http\Controllers\Controller;

use App\Models\Course;
use App\Models\CourseType;
use App\Models\Department;
use App\Models\ElectiveCourseAllocation;
use App\Models\SchemeDetail;
use App\Models\Teacher;
use Exception;
use Illuminate\Http\Request;

class ElectiveCourseAllocationController extends Controller
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
            'course_id' => 'required|numeric',
            'teacher_id' => 'required|numeric',
        ]);

        try {
            ElectiveCourseAllocation::create([
                'semester_id' => session('semester_id'),
                'shift_id' => session('shift_id'),
                'section_id' => session('section_id'),
                'scheme_detail_id' => $request->scheme_detail_id,
                'course_id' => $request->course_id,
                'teacher_id' => $request->teacher_id,

            ]);

            return redirect()->route('course-allocations.index')->with('success', "Successfully saved");
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ElectiveCourseAllocation  $electiveCourseAllocation
     * @return \Illuminate\Http\Response
     */
    public function show(ElectiveCourseAllocation $electiveCourseAllocation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ElectiveCourseAllocation  $electiveCourseAllocation
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //id: schme detail id from course allocation index page
        $scheme_detail = SchemeDetail::find($id);
        $courses = Course::all();   //later on it will be filtered on selected course type only
        $department = Department::find(session('department_id'));
        $teachers = $department->teachers;
        return view('hod.course_allocation.options.electives', compact('scheme_detail', 'courses', 'teachers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ElectiveCourseAllocation  $electiveCourseAllocation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ElectiveCourseAllocation $electiveCourseAllocation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ElectiveCourseAllocation  $electiveCourseAllocation
     * @return \Illuminate\Http\Response
     */
    public function destroy(ElectiveCourseAllocation $electiveCourseAllocation)
    {
        //
        try {
            // $clas = ElectiveCourseAllocation::find($id);
            $electiveCourseAllocation->delete();
            return redirect()->back()->with('success', 'Successfully deleted');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }
}
