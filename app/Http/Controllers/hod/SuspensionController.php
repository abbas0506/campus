<?php

namespace App\Http\Controllers\hod;

use App\Http\Controllers\Controller;
use App\Models\Clas;
use App\Models\Status;
use App\Models\Student;
use App\Models\Suspension;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SuspensionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $student = Student::find($id);
        $clases = Clas::where('program_id', $student->section->clas->program_id)
            ->where('first_semester_id', $student->section->clas->first_semester_id);

        $statuses = Status::all();
        return view('hod.students.suspend', compact('student', 'clases', 'statuses'));
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
            'status_id' => 'required|numeric',
            'remarks' => 'nullable|string|max:200',
        ]);
        DB::beginTransaction();
        try {
            $student = Student::find($id);
            $student->status_id = $request->status_id;
            $student->update();
            //log student suspension status as well
            Suspension::create([
                'student_id' => $student->id,
                'status_id' => $request->status_id,
                'remarks' => $request->remarks,
            ]);
            DB::commit();
            return redirect()->route('hod.students.show', $student)->with('success', 'Successfully updated');;
        } catch (Exception $ex) {
            DB::rollBack();
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
    }
}
