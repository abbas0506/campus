<?php

namespace App\Http\Controllers\hod;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Program;
use App\Models\Scheme;
use App\Models\Semester;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SchemeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // $schemes = Scheme::all();
        $department = Department::find(session('department_id'));
        $programs = $department->programs;
        return view('hod.schemes.index', compact('programs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $semesters = Semester::whereNotNull('edit_till')->get();
        $programs = Program::where('department_id', session('department_id'))->get();

        return view('hod.schemes.create', compact('semesters', 'programs'));
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
            'wef_semester_id' => 'required|numeric',
            'program_id' => 'required|numeric|unique:schemes,program_id,NULL,id,wef_semester_id,' . $request->wef_semester_id,
        ]);

        try {
            Scheme::create($request->all());
            return redirect()->route('programs.index')->with('success', 'Successfully created');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Scheme $scheme)
    {
        //
        session(['scheme' => $scheme]);
        return view('hod.schemes.show', compact('scheme'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Scheme $scheme)
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
    public function destroy(Scheme $scheme)
    {
        try {
            $scheme->delete();
            return redirect('programs')->with('success', 'Successfully deleted');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function append($id)
    {
        $program = Program::find($id);
        $semesters = Semester::whereNotNull('edit_till')->get();
        return view('hod.schemes.create', compact('semesters', 'program',));
    }
}
