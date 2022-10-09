<?php

namespace App\Http\Controllers\hod;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Clas;
use App\Models\Course;
use App\Models\Program;
use App\Models\Semester;
use Exception;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if (session('semester_id')) {
            $semester = Semester::find(session('semester_id'));
            return view('hod.classes.index', compact('semester'));
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
        if (session('semester_id')) {
            $semester = Semester::find(session('semester_id'));
            $programs = Program::where('department_id', Auth::user()->employee->department_id)->get();
            return view('hod.classes.create', compact('semester', 'programs'));
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
            'program_id' => 'required|numeric',
            'shift' => 'required',
        ]);

        if (session('semester_id')) {

            $semester = Semester::find(session('semester_id'));
            if ($semester->classes->where('program_id', $request->program_id)->where('shift', $request->shift)->count() > 0)
                return redirect('classes')->with('error', 'Class already exists');
            else {
                try {
                    Clas::create([
                        'semester_id' => session('semester_id'),
                        'program_id' => $request->program_id,
                        'shift' => $request->shift,

                    ]);

                    return redirect('classes')->with('success', 'Successfully created');
                } catch (Exception $e) {
                    return redirect()->back()->withErrors($e->getMessage());
                    // something went wrong
                }
            }
        } else {
            echo 'session or program variable not set... probably you have tried direct access to this page';
            //send to error page showing direct access
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Clas  $clas
     * @return \Illuminate\Http\Response
     */
    public function show(Clas $clas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Clas  $clas
     * @return \Illuminate\Http\Response
     */
    public function edit(Clas $clas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Clas  $clas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Clas $clas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Clas  $clas
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //

        try {
            $clas = Clas::find($id);
            $clas->delete();
            return redirect()->back()->with('success', 'Successfully deleted');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }
}
