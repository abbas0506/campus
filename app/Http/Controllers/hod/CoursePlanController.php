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
        //
        $section = Section::find($sid);
        if (!$section->course_allocations()->for(session('semester_id'))->exists()) {
            // auto create course allocation plan
            DB::beginTransaction();
            try {
                $semester_no = $section->clas->semesterNo(session('semester_id'));
                // retrieve all slots for current semester
                foreach ($section->clas->scheme->slots()->for($semester_no)->get()->sortBy('slot_no') as $slot) {
                    // if slot has some fixed subject association, upaate course allocaitons as it is
                    $course_id = null;
                    if ($slot->slot_options->count() == 1)
                        $course_id = $slot->slot_options->first()->course_id;

                    CourseAllocation::create([
                        'semester_id' => session('semester_id'),
                        'section_id' => $section->id,
                        'slot_id' => $slot->id,
                        'course_id' => $course_id,
                    ]);
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

        //get courses and related/available teachers list teacher
        $course_allocation = CourseAllocation::find($id);
        // $slot = Slot::find($course_allocation->slot_id);
        // $related_courses = collect();

        // foreach ($slot->slot_options as $slot_option) {
        //     if ($slot_option->course_id != '') {
        //         $course = Course::find($slot_option->course_id);
        //         $related_courses->add($course);
        //     } else {
        //         $courses = Course::where('course_type_id', $slot_option->course_type_id)->where('department_id', session('department_id'))->get();
        //         foreach ($courses as $course) {
        //             $related_courses->add($course);
        //         }
        //     }
        // }

        // $teachers = User::whereRelation('roles', 'name', 'teacher')
        //     ->get()
        //     ->whereNotIn('id', $course_allocation->teacher_id);

        // // return view('hod.courseplan.courses', compact('section', 'slot', 'related_courses'));

        return view('hod.courseplan.edit', compact('course_allocation'));
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
        $related_courses = collect();
        try {
            foreach ($slot->slot_options as $slot_option) {
                if ($slot_option->course_id != '') {
                    $course = Course::find($slot_option->course_id);
                    $related_courses->add($course);
                } else {
                    $courses = Course::where('course_type_id', $slot_option->course_type_id)->where('department_id', session('department_id'))->get();
                    foreach ($courses as $course) {
                        $related_courses->add($course);
                    }
                }
            }
            // $coursetype_ids = $slot->slot_options->pluck('course_type_id')->toArray();
            // $courses = Course::whereIn('course_type_id', $coursetype_ids)
            //     ->where('department_id', session('department_id'));
            return view('hod.courseplan.courses', compact('section', 'slot', 'related_courses'));
        } catch (Exception $e) {
            echo $e->getMessage();
            // something went wrong
        }





        // $courses = Course::whereIn('course_type_id', $course_ids)
        //     ->where('department_id', session('department_id'))->get();

        // echo $courses;
    }

    public function teachers($course_allocation_id)
    {
        $course_allocation = CourseAllocation::find($course_allocation_id);
        $teachers = User::whereRelation('roles', 'name', 'teacher')
            ->get()
            ->whereNotIn('id', $course_allocation->teacher_id);
        return view('hod.courseplan.teachers', compact('course_allocation', 'teachers'));
    }
}
