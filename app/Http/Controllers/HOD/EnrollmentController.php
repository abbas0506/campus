<?php

namespace App\Http\Controllers\hod;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\Section;
use App\Models\Semester;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $semesters = Semester::whereNotNull('edit_till')->get();
        return view('hod.enrollment.semesters', compact('semesters'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'shift' => 'required',
            'section_id' => 'required|numeric|max:10',
        ]);

        $section = Section::find($request->section_id);
        session([
            'shift' => $request->shift,
            'section' => $section,
        ]);

        $students = Student::all();
        return view('hod.students.index', compact('students'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $semester = Semester::find($id);
        session(['semester' => $semester]);

        //get current department id of the hod
        $programs = Program::all();
        return view('hod.enrollment.programs', compact('programs'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //

        $program = Program::find($id);
        session(['program' => $program]);

        //get current department id of the hod
        $sections = Section::all();
        return view('hod.enrollment.sections', compact('sections'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
