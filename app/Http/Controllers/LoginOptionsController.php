<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\Permission\Contracts\Role;

class LoginOptionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //


        $semesters = Semester::whereNotNull('edit_till')->get();
        return view('login_options', compact('semesters'));
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
        $request->validate([
            'role' => 'required',
            'department_id' => 'required_if:role,hod',
            'semester_id' => 'required_if:role,hod,teacher',
        ]);

        if (Auth::user()->hasRole($request->role)) {

            session([
                'current_role' => Str::title($request->role)
            ]);
            //save selected semester id for entire session
            if ($request->role == 'hod' || $request->role == 'teacher') {
                $semester = Semester::find($request->semester_id);
                session([
                    'semester_id' => $request->semester_id,
                    'semester' => $semester->title(),
                ]);
                if ($request->role == 'hod') {
                    $department = Department::find($request->department_id);
                    session([
                        'department_id' => $request->department_id,
                        'department' => $department,
                    ]);
                }
            }
            return redirect($request->role);
        } else
            return redirect('/');
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
