<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseAllocation;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AjaxController extends Controller
{
    //
    public function fetchDepttByRole(Request $request)
    {

        $request->validate([
            'role' => 'required',
        ]);
        $options = "";
        $user = Auth::user();
        if ($request->role == 'hod') {
            // return departments headed by the user
            $headships = $user->headships;
            foreach ($headships as $headship) {
                $options .= "<option value='" . $headship->department->id . "'>" . $headship->department->name . "</option>";
            }
        } elseif ($request->role == 'teacher') {
            // return departments where the user tecaches any course
            // $course_allocations = $user->course_allocations;

            // foreach ($course_allocations as $course_allocation) {
            //     $options .= "<option value='" . $course_allocation->course->department->id . "'>" . $course_allocation->course->department->name . "</option>";
            // }

            $department_ids = Course::where('user_id', $user->id)
                ->join('course_allocations', 'courses.id', '=', 'course_allocations.course_id')
                ->join('departments', 'courses.department_id', '=', 'departments.id')
                ->pluck('departments.id')->toArray();

            $departments = Department::whereIn('id', $department_ids)->get();
            foreach ($departments as $department) {
                $options .= "<option value='" . $department->id . "'>" . $department->name . "</option>";
            }
        }

        return response()->json([
            'options' => $options,
        ]);
    }
}
