<?php

namespace App\Http\Controllers\hod;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;

use App\Models\Course;
use App\Models\CourseAllocation;
use App\Models\CourseType;
use App\Models\Department;
use App\Models\SchemeDetail;
use App\Models\Section;
use App\Models\Slot;
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
    public function create()
    {
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
            'section_id' => 'required|numeric',
            'slot_id' => 'required|numeric',
            'course_id' => 'required|numeric',

        ]);

        try {
            $course_allocation = CourseAllocation::create($request->all());
            return redirect()->route('courseplan.edit', $request->section_id)->with('success', "Successfully saved");
        } catch (Exception $e) {
            echo $e->getMessage();
            // something went wrong
        }
    }

    public function edit($id)
    {
        $section = Section::find($id);
        return view('hod.courseplan.edit', compact('section'));
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
            return redirect()->route('courseplan.edit', $course_allocation->section)->with('success', "Successfully saved");
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

    public function courses($section_id, $slot_id)
    {
        $section = Section::find($section_id);
        $slot = Slot::find($slot_id);

        try {

            $coursetype_ids = $slot->slot_options->pluck('course_type_id')->toArray();
            $courses = Course::whereIn('course_type_id', $coursetype_ids)
                ->where('department_id', session('department_id'));
            return view('hod.courseplan.courses', compact('section', 'courses', 'slot'));
        } catch (Exception $e) {
            echo $e->getMessage();
            // something went wrong
        }
    }

    public function teachers($course_allocation_id)
    {
        session(['course_allocation_id' => $course_allocation_id,]);

        $course_allocation = CourseAllocation::find($course_allocation_id);
        $teachers = User::whereRelation('roles', 'name', 'teacher')->get();
        return view('hod.courseplan.teachers', compact('course_allocation', 'teachers'));
    }

    public function replace($course_allocation_id)
    {
        $course_allocation = CourseAllocation::find($course_allocation_id);
        $teachers = User::whereRelation('roles', 'name', 'teacher')
            ->get()
            ->whereNotIn('id', $course_allocation->teacher_id);

        return view('hod.courseplan.teachers', compact('course_allocation', 'teachers'));
    }
    public function replaceTeacher(Request $request)
    {
        $request->validate([
            'course_allocation_id' => 'required|numeric',
            'teacher_id' => 'required|numeric',
        ]);

        try {
            $course_allocation = CourseAllocation::find($request->course_allocation_id);
            $course_allocation->update($request->all());
            return redirect()->route('courseplan.edit', $course_allocation->section)->with('success', "Successfully saved");
        } catch (Exception $e) {
            echo $e->getMessage();
            // something went wrong
        }
    }
}
