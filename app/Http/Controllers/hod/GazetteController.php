<?php

namespace App\Http\Controllers\hod;

use App\Http\Controllers\Controller;
use App\Models\Clas;
use App\Models\Department;
use App\Models\Section;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class GazetteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function step1()
    {
        $department = Department::find(session('department_id'));
        $programs = $department->programs;

        return view('hod.printable.gazette.step1', compact('programs'));
    }
    public function preview($id)
    {
        $section = Section::find($id);
        return view('hod.printable.gazette.preview', compact('section'));
    }
}
