<?php

namespace App\Http\Controllers\hod;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Department;
use App\Models\SchemeDetail;
use Illuminate\Http\Request;

class ElectiveAllocationController extends Controller
{
    //
    public function edit($id)
    {
        //id: scheme detail id
        $scheme_detail = SchemeDetail::find($id);

        session(['scheme_detail_id' => $id]);
        $courses = Course::all();   //later on it will be filtered on selected course type only
        $department = Department::find(session('department_id'));
        $teachers = $department->teachers;
        return view('hod.course_allocation.options.electives', compact('scheme_detail', 'courses', 'teachers'));
    }
}
