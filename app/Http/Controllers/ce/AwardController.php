<?php

namespace App\Http\Controllers\ce;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Section;
use App\Models\Semester;
use Illuminate\Http\Request;

class AwardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $semesters = Semester::all();
        $departments = Department::all();
        return view('ce.award.index', compact('semesters', 'departments'));
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

        $request->validate([
            'semester_id' => 'required',
            'department_id' => 'required',
        ]);
        $department = Department::find($request->department_id);
        session([
            'semester_id' => $request->semester_id,
            'department' => $department,
        ]);
        $department = Department::find($request->department_id);
        $programs = $department->programs;
        return view('ce.award.sections', compact('programs', 'department'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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
    public function courses($id)
    {
        $section = Section::find($id);

        $semester_nos = collect();
        for ($i = 1; $i <= $section->clas->semester_no; $i++) {
            $semester_nos->add($i);
        }
        return view('ce.award.courses', compact('section', 'semester_nos'));
    }
}
