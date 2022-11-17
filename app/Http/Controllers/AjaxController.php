<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AjaxController extends Controller
{
    //
    public function fetchRoleDepttByUserId(Request $request)
    {

        $request->validate([
            'role' => 'required',
        ]);
        $options = "";
        $user = Auth::user();
        if ($request->role == 'hod') {
            $headships = $user->headships;
            foreach ($headships as $headship) {
                $options .= "<option value='" . $headship->department->id . "'>" . $headship->department->name . "</option>";
            }
        } elseif ($request->role == 'teacher') {
            $course_allocations = $user->course_allocations;
            foreach ($course_allocations as $course_allocation) {
                $options .= "<option value='" . $course_allocation->course->department->id . "'>" . $course_allocation->course->department->name . "</option>";
            }
        }
        return response()->json([
            'options' => $options,
        ]);
    }
}
