<?php

namespace App\Http\Controllers\hod;

use App\Http\Controllers\Controller;
use App\Models\Clas;
use App\Models\Student;
use App\Models\StudentStatus;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentStatusController extends Controller
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

    public function move($id)
    {
        $student = Student::find($id);
        $clases = Clas::where('program_id', $student->section->clas->program_id)
            ->where('first_semester_id', $student->section->clas->first_semester_id);
        return view('hod.students.move', compact('student', 'clases'));
    }
    public function struckoff($id)
    {
        $student = Student::find($id);
        return view('hod.students.struckoff', compact('student'));
    }

    public function readmit($id)
    {
        $student = Student::find($id);
        $program = $student->section->clas->program;
        return view('hod.students.readmit', compact('student', 'program'));
    }

    public function freeze($id)
    {
        $student = Student::find($id);
        return view('hod.students.freeze', compact('student'));
    }
    public function unfreeze($id)
    {
        $student = Student::find($id);
        $program = $student->section->clas->program;
        return view('hod.students.unfreeze', compact('student', 'program'));
    }

    public function deactivate(Request $request)
    {
        $request->validate([
            'student_id' => 'required|numeric',
            'status_id' => 'required|numeric',
            'remarks' => 'nullable|string|max:200',
        ]);

        try {
            StudentStatus::create($request->all());
            return redirect()->route('hod.students.show', $request->student_id)->with('success', 'Successfully updated');;
        } catch (Exception $ex) {
            return redirect()->back()
                ->withErrors($ex->getMessage());
        }
    }

    public function activate(Request $request)
    {
        $request->validate([
            'student_id' => 'required|numeric',
        ]);
        DB::beginTransaction();
        try {
            StudentStatus::create([
                'student_id' => $request->student_id,
                'status_id' => 1,
                // increase activation frequence by 1;
            ]);

            $student = Student::find($request->student_id);
            $student->section_id = $request->section_id;
            $student->update();
            DB::commit();
            return redirect()->route('hod.students.show', $request->student_id)->with('success', 'Successfully updated');;
        } catch (Exception $ex) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors($ex->getMessage());
        }
    }

    public function swap(Request $request, $id)
    {

        $request->validate([
            'section_id' => 'required|numeric',
        ]);

        try {
            $student = Student::find($id);
            $student->section_id = $request->section_id;
            $student->update();
            return redirect()->route('hod.students.show', $student->id)->with('success', 'Successfully updated');;
        } catch (Exception $ex) {
            return redirect()->back()
                ->withErrors($ex->getMessage());
        }
    }
}
