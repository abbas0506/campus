<?php

namespace App\Http\Controllers\ce;

use App\Http\Controllers\Controller;
use App\Models\CourseAllocation;
use App\Models\Student;
use Exception;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
// use PDF;
use Illuminate\Http\Request;
use App\Models\Result;

class TranscriptController extends Controller
{
    //index
    public function index()
    {
        $student = session('student');
        $searched = session('searched');
        return view('ce.transcripts.index', compact('student', 'searched'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'rollno' => 'required',
        ]);

        try {
            $rollno = $request->rollno;
            $student = Student::where('rollno', $rollno)->first();
            return redirect('transcripts')->with([
                'student' => $student,
                'searched' => true,
            ]);
        } catch (Exception $ex) {
            return redirect()->back()->withErrors($ex->getMessage());
        }
    }

    // show method
    public function show($id)
    {
        $student = Student::find($id);

        $results = Result::join('course_allocations', 'results.course_allocation_id', 'course_allocations.id')
            ->where('student_id', $id)
            ->get();
        $semester_nos = array_unique($results->pluck('semester_no')->toArray());
        return view('ce.transcripts.show', compact('student', 'results', 'semester_nos'));
    }
    public function pdf($id)
    {
        $student = Student::find($id);
        $results = Result::join('course_allocations', 'results.course_allocation_id', 'course_allocations.id')
            ->where('student_id', $id)
            ->get();
        $semester_nos = array_unique($results->pluck('semester_no')->toArray());

        // return view('ce.transcripts.pdf', compact('student', 'results', 'semester_nos'));
        $pdf = PDF::loadView('ce.transcripts.pdf', compact('student', 'results', 'semester_nos'))->setPaper('a4', 'portrait');

        // $pdf->output();
        return $pdf->stream();
        // return $pdf->setPaper('a4')->stream();
    }
}
