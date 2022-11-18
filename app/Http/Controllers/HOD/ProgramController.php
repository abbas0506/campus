<?php

namespace App\Http\Controllers\hod;

use App\Http\Controllers\Controller;
use App\Models\CourseType;
use App\Models\Department;
use Illuminate\Http\Request;
use Exception;
use App\Models\Program;

class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $department = Department::find(session('department_id'));
        $programs = $department->programs;
        return view('hod.programs.index', compact('programs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $durations = [1, 1.5, 2, 2.5, 3, 3.5, 4, 4.5, 5, 5.5, 6, 6.5, 7, 7.5, 8];
        return view('hod.programs.create', compact('durations'));
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
            'name' => 'required|unique:programs',
            'short' => 'required',
            'code' => 'nullable|unique:programs',
            'min_duration' => 'required|numeric',
            'max_duration' => 'required|numeric',
            'department_id' => 'required|numeric',

        ]);

        try {
            Program::create($request->all());
            return redirect()->route('programs.index')->with('success', 'Successfully created');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['create' => $e->getMessage()]);
            // something went wrong
        }
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
        $program = Program::findOrFail($id);
        $durations = [1, 1.5, 2, 2.5, 3, 3.5, 4, 4.5, 5, 5.5, 6, 6.5, 7, 7.5, 8];
        return view('hod.programs.edit', compact('program', 'durations'));
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
        $request->validate([
            'name' => 'required|unique:programs,name,' . $id, 'id',
            'short' => 'required',
            'code' => 'nullable|unique:programs,code,' . $id, 'id',
            'min_duration' => 'required|numeric',
            'max_duration' => 'required|numeric',
            'department_id' => 'required|numeric',

        ]);

        try {
            $program = Program::findOrFail($id);
            $program->update($request->all());
            return redirect()->route('programs.index')->with('success', 'Successfully updated');;
        } catch (Exception $ex) {
            return redirect()->back()
                ->withErrors(['update' => $ex->getMessage()]);
        }
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
        $program = Program::findOrFail($id);
        try {
            $program->delete();
            return redirect()->back()->with('success', 'Successfully deleted');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['deletion' => $e->getMessage()]);
            // something went wrong
        }
    }
}
