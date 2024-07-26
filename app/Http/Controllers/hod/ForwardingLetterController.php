<?php

namespace App\Http\Controllers\hod;

use App\Http\Controllers\Controller;
use App\Models\Clas;
use App\Models\Department;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Http\Request;

class ForwardingLetterController extends Controller
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
            return view('hod.printable.forwarding-letters.morning', compact('department', 'programs'));
        else
            return view('hod.printable.forwarding-letters.self-support', compact('department', 'programs'));
    }

    public function pdf($clasId)
    {

        $clas = Clas::find($clasId);
        $pdf = PDF::loadView('pdf.forwarding-letter', compact('clas'))->setPaper('a4', 'landscape');
        $pdf->set_option("isPhpEnabled", true);

        $file = "Forwarding " . $clas->short() . ".pdf";
        return $pdf->stream($file);
    }
}
