<?php

namespace App\Http\Controllers\coordinator;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Exception;

use App\Models\Clas;
use App\Models\Department;
use App\Models\Program;
use App\Models\Scheme;
use App\Models\Section;
use App\Models\Semester;
use App\Models\Shift;


class ClasController extends Controller
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

        return view('coordinator.clases.index', compact('programs'));
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
            'program_id' => 'required|numeric',
            'shift_id' => 'required|numeric',
            'scheme_id' => 'required|numeric',
            'first_semester_id' => 'required|numeric',

        ]);
        $program = Program::find($request->program_id);
        //derive last semester of the class

        $request->merge([
            'last_semester_id' => $request->first_semester_id + intval($program->min_t * 2) - 1,
        ]);

        DB::beginTransaction();
        try {
            $exists = Clas::where('program_id', $request->program_id)
                ->where('shift_id', $request->shift_id)
                ->where('first_semester_id', $request->first_semester_id)
                ->first();
            if ($exists) {
                return redirect()->back()->with('warning', 'Class ' . $exists->title() . ' already exists! Please review your input carefully.');
            } else {
                $clas = Clas::create($request->all());

                Section::create([
                    'clas_id' => $clas->id,
                    'name' => 'A',
                ]);
                DB::commit();

                return redirect()->route('coordinator.clases.index')->with('success', 'Successfully created');
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
        $clas = Clas::find($id);
        $shifts = Shift::all();
        $semesters = Semester::till(session('semester_id'))->get();
        return view('coordinator.clases.edit', compact('clas', 'shifts', 'semesters'));
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
            'first_semester_id' => 'required',
            'shift_id' => 'required|numeric',
            'scheme_id' => 'required|numeric',
            'first_semester_id' => 'required|numeric',
        ]);

        try {

            //derive last semester id
            $clas = Clas::find($id);
            $request->merge([
                'last_semester_id' => $request->first_semester_id + intval($clas->program->min_t * 2) - 1,
            ]);

            $exists = Clas::where('program_id', $clas->program_id)
                ->where('shift_id', $request->shift_id)
                ->where('first_semester_id', $request->frist_semester_id)
                ->first();

            if ($exists) {
                return redirect()->back()->with('warning', 'Class ' . $exists->short() . ' already exists! You may promote/demote it.');
            } else {
                $clas->update($request->all());
                return redirect()->route('coordinator.clases.index')->with('success', 'Successfully updated');;
            }
        } catch (Exception $ex) {
            return redirect()->back()->withErrors($ex->getMessage());
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
        $clas = Clas::findOrFail($id);
        $shift_id = $clas->shift_id;
        try {
            $clas->delete();
            return redirect()->route('coordinator.clases.index')->with(['shift_id' => $shift_id, 'success' => 'Successfully removed']);
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }
    public function add($pid)
    {
        $program = Program::find($pid);
        $shifts = Shift::all();
        $schemes = Scheme::all();
        $semesters = Semester::till(session('semester_id'))->get();

        return view('coordinator.clases.create', compact('program', 'shifts', 'schemes', 'semesters'));
    }
}
