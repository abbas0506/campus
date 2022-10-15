<?php

namespace App\Http\Controllers\hod;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Clas;
use App\Models\Program;
use App\Models\Section;
use App\Models\Shift;
use Illuminate\Http\Request;

class CourseAllocationOptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //find all program of this department
        $programs = Program::where('department_id', Auth::user()->teacher->department_id)->get();
        $shifts = Shift::all();


        // $classes = Clas::join('programs', function ($join) {
        //     $join->on('program_id', '=', 'programs.id');
        // })
        //     ->where('programs.department_id', '=', Auth::user()->teacher->department_id)
        //     ->get();


        // foreach ($classes as $clas) {
        //     echo $clas->title();
        // }
        //find all class of the programs
        //find all section of a concerned class

        // $classes = Clas::all();
        return view('hod.course_allocations.options', compact('programs', 'shifts'));
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
