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
    public function index()
    {
        $department = Department::find(session('department_id'));
        $programs = $department->programs;
        return view('hod.printable.cumulative.index', compact('programs', 'department'));
    }

    public function preview($section_id)
    {
        $section = Section::find($section_id);
        $slots = $section->clas->scheme->slots()->for($section->clas->semesterNo(session('semester_id')))->orderBy('slot_no');
        $slot_nos = array_unique($slots->pluck('slot_no')->toArray());
        return view('hod.printable.cumulative.preview', compact('section', 'slot_nos'));
    }
}
