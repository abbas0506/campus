<?php

namespace App\Http\Controllers\ce;

use App\Http\Controllers\Controller;
use App\Models\Clas;
use App\Models\Department;
use App\Models\Semester;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PrintController extends Controller
{

    public function chooseClass()
    {
        $semesters = Semester::where('year', '<=', Carbon::now()->format('Y'))->get();
        $departments = Department::all();
        return view('ce.printable.choose-class', compact('semesters', 'departments'));
    }
    public function classAllocations(Request $request)
    {
        $request->validate([
            'clas_id' => 'required',
            'semester_id' => 'required',
        ]);
        $clas = Clas::find($request->clas_id);
        $semester_id = $request->semester_id;

        return view('ce.printable.class-allocations', compact('clas', 'semester_id'));
    }
}
