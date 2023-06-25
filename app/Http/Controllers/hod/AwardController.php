<?php

namespace App\Http\Controllers\hod;

use App\Exports\ExportAward;
use App\Http\Controllers\Controller;
use App\Models\CourseAllocation;
use App\Models\Department;
use App\Models\Section;
use Maatwebsite\Excel\Facades\Excel;

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

    public function export($id)
    {
        $course_allocation = CourseAllocation::find($id);
        return Excel::download(new ExportAward($course_allocation), 'award_' . ($course_allocation->course->code == '' ? $course_allocation->id : $course_allocation->course->code) . '.xlsx');
    }
}
