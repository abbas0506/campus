<?php

namespace App\Http\Controllers\hod;

use App\Http\Controllers\Controller;
use App\Models\Clas;
use App\Models\Program;
use App\Models\Scheme;
use App\Models\Section;
use App\Models\Semester;
use App\Models\Shift;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

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
        $clases = Clas::whereHas(
            'program',
            function ($q) {
                $q->where('department_id', session('department_id'));
            }
        )->get();
        // $clases = Clas::all();
        return view('hod.clases.index', compact('clases'));
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

        ]);
        DB::beginTransaction();
        try {
            $clas = Clas::create($request->all());
            Section::create([
                'clas_id' => $clas->id,
                'name' => 'A',
            ]);
            DB::commit();
            return redirect('clases')->with('success', 'Successfully created');
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
    }
}
