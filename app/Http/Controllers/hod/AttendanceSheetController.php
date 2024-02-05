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
    public function index()
    {
        //
        $department = Department::find(session('department_id'));
        $programs = $department->programs;
        return view('hod.printable.attendance-sheets.index', compact('department', 'programs'));
    }

    public function pdf($clasId, $shiftId, $termId)
    {

        $clas = Clas::find($clasId);
        // $courseAllocation = $clas->course_allocations()->first();
        // $fresh = $courseAllocation->first_attempts()->pluck('student_id');
        // foreach ($clas->sections as $section) {
        //     foreach ($section->course_allocations as $course_allocation) {

        //         echo $course_allocation->first_attempts->count() . "," . $course_allocation->reappears->count() . ",";
        //         $students = $course_allocation->enrolled()->pluck('id');

        //         echo $students;
        //         echo "<br>";
        //     }
        // }
        $pdf = PDF::loadView('pdf.attendance', compact('clas'))->setPaper('a4', 'portrait');
        $pdf->set_option("isPhpEnabled", true);

        $file = "Attendance " . $clas->short() . ".pdf";
        return $pdf->stream($file);
    }
}
