<?php

namespace App\Http\Controllers\CE;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamType;
use App\Models\SemesterType;
use Illuminate\Http\Request;
use Exception;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $exams = Exam::all();
        return view('CE.exams.index', compact('exams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $exam_types = ExamType::all();
        $semester_types = SemesterType::all();
        $exams = Exam::all();
        return view('CE.exams.create', compact('exam_types', 'semester_types', 'exams'));
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
            'name' => 'required|unique:exams,name,NULL,NULL,exam_type_id,' . $request->exam_type_id,
            'exam_type_id' => 'required|numeric',
            'is_active' => 'required|boolean'
        ]);
        try {
            Exam::create($request->all());
            return redirect('exams')->with('success', 'Successfully created');
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
        $exam = Exam::findOrFail($id);
        $exam_types = ExamType::all();
        return view('CE.exams.edit', compact('exam', 'exam_types'));
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
        $exam = Exam::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:exams,name,' . $id . ',id,exam_type_id,' . $request->exam_type_id,
            'exam_type_id' => 'required|numeric',
            'is_active' => 'required|boolean'
        ]);

        try {
            $exam->update($request->all());
            return redirect()->route('exams.index')->with('success', 'Successfully updated');;
        } catch (Exception $ex) {
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
        $hod = Exam::findOrFail($id);
        try {
            $hod->delete();
            return redirect()->back()->with('success', 'Successfully deleted');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['deletion' => $e->getMessage()]);
            // something went wrong
        }
    }
}
