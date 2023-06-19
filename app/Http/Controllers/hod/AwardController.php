<?php

namespace App\Http\Controllers\hod;

use App\Http\Controllers\Controller;
use App\Models\CourseAllocation;
use App\Models\Department;
use App\Models\Section;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class AwardController extends Controller
{
    //
    public function step1()
    {

        $department = Department::find(session('department_id'));
        $programs = $department->programs;

        return view('hod.printable.award.step1', compact('programs', 'department'));
    }
    public function step2($id)
    {
        $section = Section::find($id);

        $semester_nos = collect();
        for ($i = 1; $i <= $section->clas->semester_no; $i++) {
            $semester_nos->add($i);
        }
        return view('hod.printable.award.step2', compact('section', 'semester_nos'));
    }

    public function pdf($id)
    {
        $course_allocation = CourseAllocation::find($id);
        if ($course_allocation->section->clas->program->level == 21)
            $pdf = PDF::loadView('hod.printable.award.pdf_phd', compact('course_allocation'))->setPaper('a4', 'portrait');
        else
            $pdf = PDF::loadView('hod.printable.award.pdf', compact('course_allocation'))->setPaper('a4', 'portrait');
        $pdf->set_option("isPhpEnabled", true);

        return $pdf->stream();
    }
}
