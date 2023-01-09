<?php

namespace App\Http\Controllers\hod;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use App\Models\Clas;
use App\Models\Department;
use App\Models\Program;
use App\Models\Scheme;
use App\Models\Section;
use App\Models\Semester;
use Exception;
use Illuminate\Http\Request;

class MorningClasesController extends Controller
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

        return view('hod.clases.morning.index', compact('programs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        echo "create";
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
        $request->merge([
            'semester_id' => session('semester_id'),
            'shift_id' => 1,
        ]);
        $request->validate([
            'program_id' => 'required|numeric',
            'shift_id' => 'required|numeric',
            'semester_no' => 'required|numeric',
            'semester_id' => 'required|numeric',

        ]);
        DB::beginTransaction();
        try {
            $exists = Clas::where('program_id', $request->program_id)
                ->where('shift_id', $request->shift_id)
                ->where('semester_no', $request->semester_no)
                ->where('semester_id', $request->semester_id)
                ->first();
            if ($exists)
                return redirect('morningclases')->with('error', 'Already exists!');
            else {
                $clas = Clas::create($request->all());
                Section::create([
                    'clas_id' => $clas->id,
                    'name' => 'A',
                ]);
                DB::commit();
                return redirect('morningclases')->with('success', 'Successfully created');
            }
        } catch (Exception $e) {
            DB::rollBack();
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
        $clas = Clas::findOrFail($id);
        try {
            $clas->delete();
            return redirect()->back()->with('success', 'Successfully deleted');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['deletion' => $e->getMessage()]);
            // something went wrong
        }
    }

    public function append($pid)
    {
        $program = Program::find($pid);
        $schemes = Scheme::all();
        $semesters = Semester::all();
        return view('hod.clases.morning.create', compact('program', 'schemes', 'semesters'));
    }

    public function promote()
    {
        $department = Department::find(session('department_id'));
        $programs = $department->programs;
        return view('hod.clases.morning.promote', compact('programs'));
    }
}
