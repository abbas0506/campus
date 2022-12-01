<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseAllocation;
use App\Models\Department;
use App\Models\Program;
use App\Models\Student;
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
            $department_ids = Course::where('teacher_id', $user->id)
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

    public function fetchSchemesByProgramId(Request $request)
    {

        $request->validate([
            'program_id' => 'required',
        ]);
        $program = Program::find($request->program_id);
        $schemes = $program->schemes;
        $scheme_options = "";
        foreach ($schemes as $scheme) {
            $scheme_options .= "<option value='" . $scheme->id . "'>" . $scheme->title() . "</option>";
        }
        $semester_nos = '0';
        $semester_count = $program->min_duration * 2;
        if ($semester_count > 0) {
            for ($i = 1; $i <= $semester_count; $i++) {
                $semester_nos .= "<option value='" . $i . "'>" . $i . "</option>";
            }
        }

        return response()->json([
            'scheme_options' => $scheme_options,
            'semester_nos' => $semester_nos,
        ]);
    }

    public function searchReappearer(Request $request)
    {
        $request->validate([
            'rollno' => 'required',
        ]);

        $student = Student::where('rollno', $request->rollno)->first();

        if ($student) {
            $course_track = $student->course_tracks->first();
            return response()->json([
                'course_track_id' => $course_track->id,
                'student_info' => $student->name . ($student->gender == 'M' ? ' s/o ' : ' d/o ') . $student->father,
            ]);
        } else {
            return response()->json([
                'course_track_id' => '',
                'student_info' => "Not found",
            ]);
        }
    }
}
