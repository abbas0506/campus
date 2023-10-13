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
    }

    public function update(Request $request, $id)
    {
    }


    public function destroy($id)
    {
        //

    }
}
