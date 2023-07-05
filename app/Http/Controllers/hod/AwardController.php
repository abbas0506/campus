<?php

namespace App\Http\Controllers\hod;

use App\Exports\ExportAward;
use App\Http\Controllers\Controller;
use App\Models\CourseAllocation;
use App\Models\Department;
use App\Models\Section;
use App\Models\Semester;
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
        return view('hod.printable.award.step2', compact('section'));
    }

    public function export($id)
    {
        $course_allocation = CourseAllocation::find($id);
        return Excel::download(new ExportAward($course_allocation), 'award_' . ($course_allocation->course->code == '' ? $course_allocation->id : $course_allocation->course->code) . '.xlsx');
    }
}
