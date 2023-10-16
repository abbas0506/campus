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
    public function index()
    {
        $department = Department::find(session('department_id'));
        $programs = $department->programs;

        return view('hod.printable.gazette.index', compact('programs'));
    }
    public function preview($id)
    {
        $section = Section::find($id);
        return view('hod.printable.gazette.preview', compact('section'));
    }
}
