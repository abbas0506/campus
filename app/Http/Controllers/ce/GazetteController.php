<?php

namespace App\Http\Controllers\ce;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Section;
use App\Models\Semester;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GazetteController extends Controller
{
    //
    public function step1()
    {
        //
        $semesters = Semester::where('year', '<=', Carbon::now()->format('Y'))->get();
        $departments = Department::all();
        return view('ce.gazette.step1', compact('semesters', 'departments'));
    }

    public function step2()
    {
        //
        $department = session('department');
        $semester = session('semester');
        return view('ce.gazette.step2', compact('semester', 'department'));
    }

    public function step3($id)
    {

        $section = Section::find($id);
        return view('ce.gazette.step3', compact('section'));

        // $section = Section::find($id);

        // $semester_nos = collect();
        // for ($i = 1; $i <= $section->clas->semester_no; $i++) {
        //     $semester_nos->add($i);
        // }
        // return view('ce.award.step3', compact('section', 'semester_nos'));
    }



    public function store(Request $request)
    {

        $request->validate([
            'semester_id' => 'required',
            'department_id' => 'required',
        ]);

        $department = Department::find($request->department_id);
        $semester = Semester::find($request->semester_id);

        //save for next pages
        session([
            'semester' => $semester,
            'department' => $department,
        ]);

        return redirect()->route('ce.gazette.step2');
    }
}
