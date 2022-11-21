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
use App\Models\User;
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
        if (session('section_id')) {
            $section = Section::find(session('section_id'));
            return view('hod.course_allocation.index', compact('section'));
        } else {
            echo "Section not selected";
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
        $section = Section::find(session('section_id'));
        $scheme = $section->clas->scheme;

        return view('hod.course_allocation.create', compact('scheme', 'section'));
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

        // echo 'semester: ' . session('semester_id') . "section:" . session('section_id');
        //append id of hod's current department
        $request->merge([
            'semester_id' => session('semester_id'),
            'section_id' => session('section_id'),
            'semester_no' => 1,
        ]);

        $request->validate([
            'course_id' => 'required|numeric',
            'semester_id' => 'required|numeric',
            'section_id' => 'required|numeric',
            'semester_no' => 'required|numeric',

        ]);

        try {
            CourseAllocation::create($request->all());

            // $section = Section::find(session('section_id'));
            // CourseAllocation::create([
            //     'semester_id' => session('semester_id'),
            //     'section_id' => session('section_id'),
            //     'semester_no' => $section->semester_no,
            //     'scheme_detail_id' => $request->scheme_detail_id,
            //     'course_id' => $request->course_id,

            // ]);


            return redirect()->route('course-allocations.index')->with('success', "Successfully saved");
        } catch (Exception $e) {
            echo $e->getMessage();
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

    public function addOptional($id)
    {
        $section = Section::find(session('section_id'));
        $scheme_detail = SchemeDetail::find($id);
        $courses = Course::where('course_type_id', $scheme_detail->course->course_type_id)->get();

        return view('hod.course_allocation.assign.optional', compact('section', 'scheme_detail', 'courses'));
    }
    public function assignTeacher($id)
    {
        //save which course allocation is open
        session(['course_allocation_id' => $id,]);

        $teachers = User::whereHas(
            'roles',
            function ($q) {
                $q->where('name', 'teacher');
            }
        )->get();

        return view('hod.course_allocation.assign.teacher', compact('teachers'));
    }
    public function postAssignTeacher(Request $request)
    {

        //append id of hod's current department
        $request->merge(['course_allocation_id' => session('course_allocation_id')]);
        $request->validate([
            'course_allocation_id' => 'required|numeric',
            'teacher_id' => 'required|numeric',
        ]);

        try {

            $course_allocation = CourseAllocation::find(session('course_allocation_id'));
            $course_allocation->update($request->all());

            session([
                'course_allocation_id' => null, //nullify stored coure allocation
            ]);
            return redirect()->route('course-allocations.index')->with('success', "Successfully saved");
        } catch (Exception $e) {
            echo $e->getMessage();
            // something went wrong
        }
    }
}
