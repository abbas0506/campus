<?php

namespace App\Http\Controllers\ce;

use App\Http\Controllers\Controller;
use App\Models\CourseAllocation;
use App\Models\Department;
use App\Models\Section;
use App\Models\Semester;
use Carbon\Carbon;
use App\Exports\ExportAward;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class AwardController extends Controller
{

    public function step1()
    {
        //
        $semesters = Semester::where('year', '<=', Carbon::now()->format('Y'))->get();
        $departments = Department::all();
        return view('ce.award.step1', compact('semesters', 'departments'));
    }

    public function step2()
    {
        //
        $department = Department::find(session('department_id'));
        $programs = $department->programs;
        return view('ce.award.step2', compact('department', 'programs'));
    }

    public function step3($id)
    {
        $section = Section::find($id);

        $semester_nos = collect();
        for ($i = 1; $i <= $section->clas->semester_no; $i++) {
            $semester_nos->add($i);
        }
        return view('ce.award.step3', compact('section', 'semester_nos'));
    }


    public function store(Request $request)
    {

        $request->validate([
            'semester_id' => 'required',
            'department_id' => 'required',
        ]);

        //save for next pages
        session([
            'semester' => $request->semester_id,
            'department' => $request->department_id,
        ]);

        return redirect()->route('ce.award.step2');
    }
    public function export($id)
    {
        $course_allocation = CourseAllocation::find($id);
        return Excel::download(new ExportAward($course_allocation), 'award_' . ($course_allocation->course->code == '' ? $course_allocation->id : $course_allocation->course->code) . '.xlsx');
    }
}
