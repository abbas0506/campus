<?php

namespace App\Http\Controllers\hod;

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

        return view('hod.clases.index', compact('programs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $programs = Program::where('department_id', session('department_id'))->get();
        $shifts = Shift::all();
        $schemes = Scheme::all();
        $semesters = Semester::all();
        return view('hod.clases.create', compact('programs', 'shifts', 'schemes', 'semesters'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //append current semester to request
        $request->merge(['semester_id' => session('semester_id')]);
        $request->validate([
            'program_id' => 'required|numeric',
            'shift_id' => 'required|numeric',
            'semester_no' => 'required|numeric',
            'semester_id' => 'required|numeric',
            'scheme_id' => 'required|numeric',

        ]);

        DB::beginTransaction();
        try {
            $exists = Clas::where('program_id', $request->program_id)
                ->where('shift_id', $request->shift_id)
                ->where('semester_no', $request->semester_no)
                ->where('semester_id', $request->semester_id)
                ->first();
            if ($exists) {
                return redirect()->back()->with('error', 'Already exists!');
            } else {
                $clas = Clas::create($request->all());
                Section::create([
                    'clas_id' => $clas->id,
                    'name' => 'A',
                ]);
                DB::commit();

                // return redirect('clases')->with('success', 'Successfully created');
                return redirect('clases')->with(['shift_id' => $clas->shift_id, 'success' => 'Successfully created']);
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
        $shift_id = $clas->shift_id;
        try {
            $clas->delete();
            return redirect('clases')->with(['shift_id' => $shift_id, 'success' => 'Successfully removed']);
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }
    public function append($pid, $sid)
    {
        $program = Program::find($pid);
        $shift = Shift::find($sid);
        $schemes = Scheme::all();
        $semesters = Semester::all();
        return view('hod.clases.create', compact('program', 'shift', 'schemes', 'semesters'));
    }

    public function promote(Request $request)
    {
        $request->validate([
            'ids_array' => 'required',
        ]);

        $ids = array();
        $ids = $request->ids_array;
        DB::beginTransaction();
        try {
            if ($ids) {
                foreach ($ids as $id) {
                    //promote to next semester
                    $clas = Clas::find($id);
                    $clas->semester_no = $clas->semester_no + 1;
                    $clas->update();
                    //if class duration is over, finish the class
                    if ($clas->semester_no > $clas->program->max_duration * 2) {
                        $clas->status = 0;
                        $clas->update();
                    }
                }
            }
            DB::commit();
            return response()->json(['msg' => "Successful"]);
        } catch (Exception $ex) {
            DB::rollBack();
            return response()->json(['msg' => $ex->getMessage()]);
        }
    }

    public function demote(Request $request)
    {
        $request->validate([
            'ids_array' => 'required',
        ]);

        $ids = array();
        $ids = $request->ids_array;
        DB::beginTransaction();
        try {
            if ($ids) {
                foreach ($ids as $id) {
                    $clas = Clas::find($id);
                    //demoting below 1st semester is illegal
                    if ($clas->semester_no > 1) {
                        $clas->semester_no = $clas->semester_no - 1;
                        $clas->update();
                    }
                }
            }
            DB::commit();
            return response()->json(['msg' => "Successful"]);
        } catch (Exception $ex) {
            DB::rollBack();
            return response()->json(['msg' => $ex->getMessage()]);
        }
    }
}
