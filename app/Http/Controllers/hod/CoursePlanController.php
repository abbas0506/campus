<?php

namespace App\Http\Controllers\hod;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;

use App\Models\Course;
use App\Models\CourseAllocation;
use App\Models\Department;
use App\Models\SchemeDetail;
use App\Models\Section;
use App\Models\User;

class CoursePlanController extends Controller
{
    //
    public function index()
    {
        //
        $department = Department::find(session('department_id'));
        $programs = $department->programs;

        return view('hod.courseplan.index', compact('programs'));
    }

    public function show($sid)
    {
        //
        $section = Section::find($sid);
        return view('hod.courseplan.show', compact('section'));
    }

    public function store(Request $request)
    {
        //append current semester id to request object

        $request->merge([
            'semester_id' => session('semester_id'),
        ]);

        $request->validate([
            'semester_id' => 'required|numeric',
            'scheme_detail_id' => 'numeric',
            'section_id' => 'required|numeric',
            'course_id' => 'required|numeric',
            'semester_no' => 'required|numeric',
        ]);

        try {
            $course_allocation = CourseAllocation::create($request->all());
            return redirect()->route('courseplan.show', $course_allocation->section)->with('success', "Successfully saved");
        } catch (Exception $e) {
            echo $e->getMessage();
            // something went wrong
        }
    }

    public function update(Request $request, $id)
    {
        //append id of hod's current department
        $request->validate([
            'teacher_id' => 'required|numeric',
        ]);

        try {
            $course_allocation = CourseAllocation::find($id);
            $course_allocation->update($request->all());
            return redirect()->route('courseplan.show', $course_allocation->section)->with('success', "Successfully saved");
        } catch (Exception $e) {
            echo $e->getMessage();
            // something went wrong
        }
    }


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

    public function courses($sid)
    {
        $section = Section::find($sid);
        return view('hod.courseplan.courses', compact('section'));
    }

    // view available teachers for selected course
    public function teachers($id)
    {
        session(['course_allocation_id' => $id,]);

        $course_allocation = CourseAllocation::find($id);
        $teachers = User::whereRelation('roles', 'name', 'teacher')->get();
        return view('hod.courseplan.teachers', compact('course_allocation', 'teachers'));
    }
    public function optional($section_id, $schemedetail_id)
    {
        $section = Section::find($section_id);
        $scheme_detail = SchemeDetail::find($schemedetail_id);
        $courses = Course::where('course_type_id', $scheme_detail->course->course_type_id)->get();

        return view('hod.courseplan.optional', compact('section', 'scheme_detail', 'courses'));
    }
}
