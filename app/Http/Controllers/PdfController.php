<?php

namespace App\Http\Controllers;

use App\Models\CourseAllocation;
use App\Models\FirstAttempt;
use App\Models\Section;
use App\Models\Student;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class PdfController extends Controller
{
    public function award($id)
    {

        $course_allocation = CourseAllocation::find($id);
        $pdf = PDF::loadView('pdf.award', compact('course_allocation'))->setPaper('a4', 'portrait');
        $pdf->set_option("isPhpEnabled", true);

        $file = "Award " . $course_allocation->course->code . ".pdf";
        return $pdf->stream($file);
    }

    public function gazette($id)
    {
        $section = Section::find($id);
        $pdf = PDF::loadView('pdf.gazette', compact('section'))->setPaper('a4', 'landscape');

        return $pdf->stream();
    }

    public function previewCumulative($section_id, $semester_no)
    {
        $section = Section::find($section_id);
        $course_allocations = $section->course_allocations;


        // $course1=FirstAttempt::where('course_allocation_id', 1)

        // echo typeOf($course_allocations);
        // $array = $course_allocations->toJson();
        // echo $array['id'][0];
        $course_array = [];
        foreach ($course_allocations as $course_allocation) {
            array_push($course_array, $course_allocation->id);
        }
        // for

        $sub1 = FirstAttempt::where('course_allocation_id', $course_array[0])->where('semester_no', $semester_no);
        $sub2 = FirstAttempt::where('course_allocation_id', $course_array[1])->where('semester_no', $semester_no);

        $result = Student::select('students.id', 'students.name', 'sub1.assignment as as1', 'sub2.assignment as as2')
            ->where('section_id', $section_id)
            ->joinSub($sub1, 'sub1', function ($join) {
                $join->on('sub1.student_id', '=', 'students.id');
            })
            ->joinSub($sub2, 'sub2', function ($join) {
                $join->on('sub2.student_id', '=', 'students.id');
            })->get();

        echo $result->toJson();

        // $countries = Country::select('countries.id', 'countries.name', 'essential')
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
}
