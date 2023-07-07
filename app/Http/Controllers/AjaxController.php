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
        $semester_count = $program->min_t * 2;
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

    public function fetchProgramsByDepartmentId(Request $request)
    {
        $request->validate([
            'semester_id' => 'required',
            'department_id' => 'required',
        ]);
        session([
            'semester_id' => $request->semester_id,
            'department_id' => $request->department_id,
        ]);
        $department = Department::find($request->department_id);
        $programs = $department->programs;
        $text = "";
        foreach ($programs as $program) {
            $text .= "<li><a href='" . url("gazette/final/preview/" . $program->id) . "'>" . $program->short . "</a></li>";
        }
        return response()->json([
            'text' => $text,
        ]);
    }

    public function searchReappearer(Request $request)
    {
        $request->validate([
            'rollno' => 'required',
            'course_allocation_id' => 'required',
        ]);

        $student = Student::where('rollno', $request->rollno)->first();
        $current_course_allocation = CourseAllocation::find($request->course_allocation_id);

        $eligible = 0;
        $student_info = 'Student not found';
        $result = '';

        $roman = config('global.romans');
        //if student found, fetch student history and check whether he/she has ever failed in the same course
        if ($student) {
            $student_info = $student->name . ($student->gender == 'M' ? ' s/o ' : ' d/o ') . $student->father;

            //get previous semesters data
            $first_attempts = $student->first_attempts->where('semester_id', '<', $current_course_allocation->semester_id);

            foreach ($first_attempts as $first_attempt) {
                //look for only same course
                if ($current_course_allocation->course->id == $first_attempt->course_allocation->course->id) {
                    //if student failed in the same course, show its first attempt
                    $result .= "<tr>" .
                        "<td class='text-center'>" . $first_attempt->semester->short() . "</td>" .
                        "<td class='text-center'>" . $roman[$first_attempt->semester_no - 1] . "</td>" .
                        "<td class='text-center'>" . $first_attempt->total() . "/100" . "</td>" .
                        "<td class='text-center'>" . $first_attempt->gpa() . "</td>" .
                        "<td class='text-center'>" . $first_attempt->grade() . "</td>" .
                        '</tr>';
                    //also look into reappear attempts
                    foreach ($first_attempt->reappears->where('semester_id', '<', $current_course_allocation->semester_id) as $reappear) {
                        $result .= "<tr>" .
                            '<td>' . $reappear->semester->short() . '</td>' .
                            '<td>' . $roman[$first_attempt->semester_no - 1] . '</td>' .
                            '<td>' . $reappear->total() . '/100' . '</td>' .
                            '<td>' . $reappear->gpa() . '</td>' .
                            '<td>' . $reappear->grade() . '</td>' .
                            '</tr>';
                    }

                    //student data found
                    $eligible = 1;
                    break;
                }
            }
            if ($eligible == 0)
                $result .= "<tr>" .
                    '<td colspan=5> Student has never made any attempt for the course</td>' .
                    '</tr>';
        }
        // return search output
        return response()->json([
            'eligible' => $eligible,
            'result' => $result,
            'student_info' => $student_info,
        ]);
    }

    public function searchByRollNoOrName(Request $request)
    {
        $request->validate([
            'searchby' => 'required',
        ]);

        // $students = Student::where('rollno', $request->searchby)->get();

        $studentsByRollNo = Student::where('rollno', 'like', '%' . $request->searchby . '%')
            ->whereRelation('section.clas.program', 'department_id', session('department')->id);

        $studentsByName = Student::where('name', 'like', '%' . $request->searchby . '%')
            ->whereRelation('section.clas.program', 'department_id', session('department')->id);
        $students = $studentsByRollNo->union($studentsByName)->get();

        $result = '';
        $roman = config('global.romans');
        //if student found, fetch student history and check whether he/she has ever failed in the same course

        foreach ($students as $student) {
            //look for only same course

            //if student failed, then look into reappear attempts
            $result .=

                "<div class='flex flex-row w-full py-1'>" .
                "<a href='/students/" . $student->id . "' class='link w-1/4'>" . $student->rollno . "</a>" .
                "<div class='w-1/4'>" . $student->name . "</div>" .
                "<div class='w-1/4'>" . $student->father . "</div>" .
                "<div class='w-1/4'>" . $student->section->clas->title() . "</div>" .
                "</div>";
        }
        //student data found
        return response()->json([
            'result' => $result,
        ]);
    }

    public function searchAllByRollNoOrName(Request $request)
    {
        $request->validate([
            'searchby' => 'required',
        ]);

        $students = Student::where('rollno', 'like', '%' . $request->searchby . '%')
            ->orWhere('name', 'like', '%' . $request->searchby . '%')->get();

        $result = '';
        $roman = config('global.romans');

        foreach ($students as $student) {
            //students data found
            $result .=

                "<div class='flex flex-row w-full py-1'>" .
                "<a href='/ce/transcripts/pdf/" . $student->id . "' class='link w-1/4' target='_blank'>" . $student->rollno . "</a>" .
                "<div class='w-1/4'>" . $student->name . "</div>" .
                "<div class='w-1/4'>" . $student->father . "</div>" .
                "<div class='w-1/4'>" . $student->section->clas->short() . "</div>" .
                "</div>";
        }
        //student data missing
        if ($result == '') {
            $result = "<div class='flex flex-row flex-1 py-1 text-center'>No record found!</div>";
        }
        return response()->json([
            'result' => $result,
        ]);
    }
}
