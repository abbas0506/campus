<?php

namespace App\Http\Controllers\teacher;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\CourseAllocation;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class AwardController extends Controller
{
    //
    public function index()
    {
        $teacher = Auth::user();
        $course_allocations = $teacher->course_allocations()->during(session('semester')->id)->get();

        return view('teacher.award.index', compact('course_allocations'));
    }

    public function pdf($id)
    {
        $course_allocation = CourseAllocation::find($id);
        if ($course_allocation->section->clas->program->level == 21)
            $pdf = PDF::loadView('teacher.award.pdf_phd', compact('course_allocation'))->setPaper('a4', 'portrait');
        else
            $pdf = PDF::loadView('teacher.award.pdf', compact('course_allocation'))->setPaper('a4', 'portrait');
        $pdf->set_option("isPhpEnabled", true);

        return $pdf->stream();
    }
}
