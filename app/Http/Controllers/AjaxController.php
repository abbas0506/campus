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
        $options = "<option value=''>Select a department</option>";
        $user = Auth::user();
        if ($request->role == 'hod') {
            // return departments headed by the user
            $headships = $user->headships;
            foreach ($headships as $headship) {
                $options .= "<option value='" . $headship->department->id . "'>" . $headship->department->name . "</option>";
            }
        } elseif ($request->role == 'teacher') {
            // 
            $departments = $user->teaching_departments();
            if ($departments->count() > 0)
                foreach ($departments as $department) {
                    $options .= "<option value='" . $department->id . "'>" . $department->name . "</option>";
                }
            else
                $options .= "<option value=''> Sorry, no course allocation!</option>";
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
            'course_allocation_id' => 'required',
        ]);

        $student = Student::where('rollno', $request->rollno)->first();
        $course_allocation = CourseAllocation::find($request->course_allocation_id);

        $result = '';
        $roman = config('global.romans');
        if ($student) {
            $first_attempt = $student->first_attempts
                ->where('course_id', $course_allocation->course_id)
                ->where('program_id', $course_allocation->scheme_detail->scheme->program_id)
                ->where('semester_id', '<', $course_allocation->semester_id)
                ->first();
            if ($first_attempt) {
                $result .= '<tr>' .
                    '<td>' . $first_attempt->semester->title() . '</td>' .
                    '<td>' . $roman[$first_attempt->semester_no - 1] . '</td>' .
                    '<td>' . $first_attempt->total() . '/100' . '</td>' .
                    '<td>' . $first_attempt->gpa() . '</td>' .
                    '<td>' . $first_attempt->grade() . '</td>' .
                    '</tr>';

                foreach ($first_attempt->reappears->where('semester_id', '<', $course_allocation->semester_id) as $reappear)
                    $result .= '<tr>' .
                        '<td>' . $reappear->semester->title() . '</td>' .
                        '<td>' . $roman[$first_attempt->semester_no - 1] . '</td>' .
                        '<td>' . $reappear->total() . '/100' . '</td>' .
                        '<td>' . $reappear->gpa() . '</td>' .
                        '<td>' . $reappear->grade() . '</td>' .
                        '</tr>';

                //get the last attempt
                //if last attempt failed
                return response()->json([
                    'result' => $result,
                    'student_info' => $student->name . ($student->gender == 'M' ? ' s/o ' : ' d/o ') . $student->father,
                ]);
            } else {
                //student exists but has never made any attempt
                return response()->json([
                    'result' => '',
                    'student_info' => $student->name . ($student->gender == 'M' ? ' s/o ' : ' d/o ') . $student->father,
                ]);
            }
        } else {
            //student not found
            return response()->json([
                'result' => '',
                'student_info' => "Record not found",
            ]);
        }
    }
}
