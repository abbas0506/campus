<?php

namespace App\Http\Controllers\hod;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\FirstAttempt;
use App\Models\Section;
use App\Models\Semester;
use App\Models\Student;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Database\Seeders\SemesterSeeder;

class CumulativeController extends Controller
{
    //
    public function step1()
    {

        $department = Department::find(session('department_id'));
        $programs = $department->programs;

        return view('hod.printable.cumulative.step1', compact('programs', 'department'));
    }
    public function step2($id)
    {
        $section = Section::find($id);
        $semesters = Semester::whereBetween('id', [$section->clas->semester_id, session('semester_id')])->get();

        return view('hod.printable.cumulative.step2', compact('section', 'semesters'));
    }

    public function preview1($id, $semester_no)
    {
        $section = Section::find($id);
        $course_allocations = $section->course_allocations()->allocated($semester_no)->get();

        $students = $section->students;
        // foreach ($students->sortBy('rollno') as $student) {
        //     echo $student->rollno . "__" . $student->name;
        //     foreach ($course_allocations as $course_allocation) {
        //         $attempt = $student->first_attempts()->courses($course_allocation->id)->first();
        //         if ($attempt)
        //             // echo  "__" . $attempt->toJson();
        //             echo  "__" . $attempt->gpa() . "__" . $attempt->grade();
        //     }
        //     echo "<br>";
        // }
        return view('hod.printable.cumulative.preview', compact('course_allocations', 'section'));
        // $course1=FirstAttempt::where('course_allocation_id', 1)

        // echo typeOf($course_allocations);
        // $array = $course_allocations->toJson();
        // echo $array['id'][0];
        // $course_array = [];
        // foreach ($course_allocations as $course_allocation) {
        //     array_push($course_array, $course_allocation->id);
        // }
        // // for

        // $sub1 = FirstAttempt::where('course_allocation_id', $course_array[0])->where('semester_no', $semester_no);
        // $sub2 = FirstAttempt::where('course_allocation_id', $course_array[1])->where('semester_no', $semester_no);


        // $result = Student::select('students.id', 'students.name', 'sub1.assignment as as1', 'sub2.assignment as as2')
        //     ->where('section_id', $id)
        //     ->joinSub($sub1, 'sub1', function ($join) {
        //         $join->on('sub1.student_id', '=', 'students.id');
        //     })
        //     ->joinSub($sub2, 'sub2', function ($join) {
        //         $join->on('sub2.student_id', '=', 'students.id');
        //     })->get();

        // echo $result->toJson();

        // // $countries = Country::select('countries.id', 'countries.name', 'essential')
        //         ->joinSub($studycosts, 'studycosts', function ($join) {
        //             $join->on('studycosts.country_id', '=', 'countries.id');
        //         })->joinSub($livingcosts, 'livingcosts', function ($join) {
        //             $join->on('livingcosts.country_id', '=', 'countries.id');
        //         })
        //         ->get();
        // $result1 = Student::join('first_attempts', 'first_attempts.student_id', 'students.id')
        //     ->join('sections', 'sections.id', 'students.section_id')
        //     ->where('course_id', $course_array[0])
        //     ->where('section_id', $section_id)
        //     ->where('semester_no', $semester_no)
        //     ->select('student_id', 'course_id', 'assignment as ass1')->get();

        // $result2 = Student::join('first_attempts', 'first_attempts.student_id', 'students.id')
        //     ->join('sections', 'sections.id', 'students.section_id')
        //     ->where('course_id', $course_array[1])
        //     ->where('section_id', $section_id)
        //     ->where('semester_no', $semester_no)
        //     ->select('student_id', 'course_id', 'assignment as ass2')->get();

        // $result = $result1->intersect($result2);
        // echo $result->toJson();
        // echo "<br>";
        // echo $result2->toJson();

    }
    public function preview($section_id, $semester_id)
    {
        $section = Section::find($section_id);
        $course_allocations = $section->course_allocations()->during($semester_id)->get();

        $students = $section->students;
        $ids_1 = $section->students->pluck('id')->toArray();
        $ids_2 = $section->students->where('id', '>', 7140)->pluck('id')->toArray();
        $ids_3 = $section->students->where('id', '<', 7148)->pluck('id')->toArray();


        $ids_4 = array_intersect($ids_1, $ids_2, $ids_3);
        dd($ids_4);
    }
}
