<?php

namespace App\Http\Controllers\hod;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\Section;
use App\Models\Semester;
use App\Models\Session;
use Exception;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if (session('semester_id') && session('program_id')) {
            $semester = Semester::find(session('semester_id'));
            $program = Program::find(session('program_id'));

            return view('hod.sections.index', compact('semester', 'program'));
        } else {
            echo 'session or program variable not set... probably you have tried direct access to this page';
            //send to error page showing direct access
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        if (session('semester_id') && session('program_id')) {
            $semester = Semester::find(session('semester_id'));
            $program = Program::find(session('program_id'));
            return view('hod.sections.create', compact('semester', 'program'));
        } else {
            echo 'session or program variable not set... probably you have tried direct access to this page';
            //send to error page showing direct access
        }
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
            'name' => 'required',
        ]);

        if (session('semester') && session('program')) {
            $semester = session('semester');
            $program = session('program');

            try {
                Section::create([
                    'semester_id' => $semester->id,
                    'program_id' => $program->id,
                    'name' => $request->name,

                ]);

                return redirect('sections')->with('success', 'Successfully created');
            } catch (Exception $e) {
                return redirect()->back()->withErrors($e->getMessage());
                // something went wrong
            }
        } else {
            echo 'session or program variable not set... probably you have tried direct access to this page';
            //send to error page showing direct access
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function show(Section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function edit(Section $section)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Section $section)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(Section $section)
    {
        //
    }
}
