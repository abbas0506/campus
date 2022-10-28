<?php

namespace App\Http\Controllers\hod;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Models\Course;
use App\Models\CourseAllocation;
use App\Models\Department;
use App\Models\Teacher;
use App\Models\Scheme;
use App\Models\SchemeDetail;
use App\Models\Section;
use App\Models\Semester;
use Exception;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        if (session('section_id') && session('scheme_id')) {
            $scheme = Scheme::find(session('scheme_id'));
            $section = Section::find(session('section_id'));
            return view('hod.course_allocation.index', compact('section', 'scheme'));
        } else {
            echo "Scheme of study and section not selected";
        }
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
            'teacher_id' => 'required|numeric',
        ]);

        try {
            CourseAllocation::create([
                'scheme_detail_id' => session('scheme_detail_id'),
                'semester_id' => session('semester_id'),
                'shift_id' => session('shift_id'),
                'section_id' => session('section_id'),
                'teacher_id' => $request->teacher_id,
                'course_id' => $request->course_id,


            ]);

            return redirect()->route('course-allocations.index')->with('success', "Successfully saved");
        } catch (Exception $e) {
            echo $e->getMessage();
            // return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
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
        //id : scehme dtail id

        session([
            'scheme_detail_id' => $id,
        ]);

        $scheme_detail = SchemeDetail::find($id);
        $department = Department::find(session('department_id'));
        $teachers = $department->teachers;

        return view('hod.course_allocation.options.teachers', compact('teachers'));
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
            $clas = CourseAllocation::find($id);
            $clas->delete();
            return redirect()->back()->with('success', 'Successfully deleted');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }
}
