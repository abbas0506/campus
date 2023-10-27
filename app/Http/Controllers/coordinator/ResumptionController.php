<?php

namespace App\Http\Controllers\coordinator;

use App\Http\Controllers\Controller;
use App\Models\Clas;
use App\Models\Resumption;
use App\Models\Status;
use App\Models\Student;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResumptionController extends Controller
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
        $grace_period = $student->section->clas->program->max_t - $student->section->clas->program->min_t;
        $clases = Clas::where('program_id', $student->section->clas->program_id)
            ->whereBetween('last_semester_id', [$student->root_section->clas->last_semester_id, $student->root_section->clas->last_semester_id + $grace_period * 2])
            ->where('last_semester_id', '>=', $student->section->clas->last_semester_id);

        return view('coordinator.students.resume', compact('student', 'clases'));
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
            'section_id' => 'required|numeric',
        ]);
        DB::beginTransaction();
        $student = Student::find($id);
        try {
            Resumption::create([
                'student_id' => $student->id,
                'status_id' => 1,
                'from_section_id' => $student->section->id,
                'to_section_id' => $request->section_id,
            ]);

            $student->section_id = $request->section_id;
            $student->status_id = 1;
            $student->update();
            DB::commit();
            return redirect()->route('coordinator.students.show', $student)->with('success', 'Successfully updated');;
        } catch (Exception $ex) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors($ex->getMessage());
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
