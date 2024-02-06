<?php

namespace App\Http\Controllers\hod;

use App\Http\Controllers\Controller;
use App\Models\Clas;
use App\Models\Department;
use App\Models\Program;
use App\Models\Student;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class AttendanceSheetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($shiftId)
    {
        //
        $department = Department::find(session('department_id'));
        $programs = $department->programs;
        // $programs = Program::where('department_id', $department->id)
        //     ->whereHas('clases.sections')->get();
        if ($shiftId == 1)
            return view('hod.printable.attendance-sheets.morning', compact('department', 'programs'));
        else
            return view('hod.printable.attendance-sheets.self-support', compact('department', 'programs'));
    }

    public function pdf($clasId, $termId)
    {

        $clas = Clas::find($clasId);
        $pdf = PDF::loadView('pdf.attendance', compact('clas', 'termId'))->setPaper('a4', 'portrait');
        $pdf->set_option("isPhpEnabled", true);

        $file = "Attendance " . $clas->short() . ".pdf";
        return $pdf->stream($file);
    }
}
