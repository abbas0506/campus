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
use Illuminate\Support\Facades\DB;

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
        $section = Section::find($sid);
        if (!$section->course_allocations()->for(session('semester_id'))->exists()) {
            //if empty, auto create course allocation plan according to related scheme
            DB::beginTransaction();
            try {
                $semester_no = $section->clas->semesterNo(session('semester_id'));
                // retrieve all slots for current semester
                foreach ($section->clas->scheme->slots()->for($semester_no)->get()->sortBy('slot_no') as $slot) {
                    //if slot has fixed course, save as it is
                    foreach ($slot->slot_options as $slot_option) {
                        if ($slot_option->course()->exists())
                            $course_id = $slot_option->course_id;
                        else
                            $course_id = null;

                        CourseAllocation::create([
                            'semester_id' => session('semester_id'),
                            'section_id' => $section->id,
                            'slot_option_id' => $slot_option->id,
                            'course_id' => $course_id,
                        ]);
                    }
                }
                DB::commit();
            } catch (Exception $ex) {
                DB::rollBack();
                return redirect()->back()->withErrors($ex->getMessage());
            }
        }
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
            return redirect()->route('courseplan.show', $request->section_id)->with('success', "Successfully saved");
        } catch (Exception $e) {
            echo $e->getMessage();
            // something went wrong
        }
    }

    public function edit($id)
    {

        $course_allocation = CourseAllocation::find($id);
        return view('hod.courseplan.edit', compact('course_allocation'));
    }

    public function update(Request $request, $id)
    {
        try {
            $course_allocation = CourseAllocation::find($id);
            $course_allocation->update($request->all());
            return redirect()->route('courseplan.edit', $course_allocation)->with('success', "Successfully saved");
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
            $clas->course_id = null;
            $clas->teacher_id = null;
            $clas->update();
            return redirect()->back()->with('success', 'Successfully deleted');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }

    public function courses($id)
    {

        $course_allocation = CourseAllocation::find($id);
        $courses = Course::where('course_type_id', $course_allocation->slot_option->course_type_id)
            ->where('department_id', session('department_id'))
            ->where('id', '<>', $course_allocation->course_id)
            ->whereRaw('cr_theory+cr_practical=' . $course_allocation->slot_option->slot->cr)
            ->get();
        return view('hod.courseplan.courses', compact('course_allocation', 'courses'));
    }

    public function teachers($course_allocation_id)
    {
        $course_allocation = CourseAllocation::find($course_allocation_id);
        $teachers = User::whereRelation('roles', 'name', 'teacher')
            ->where('id', '<>', $course_allocation->teacher_id)
            ->where('is_active', 1)
            ->get();
        return view('hod.courseplan.teachers', compact('course_allocation', 'teachers'));
    }
}
