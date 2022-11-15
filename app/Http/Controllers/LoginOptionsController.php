<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Semester;
use Illuminate\Http\Request;
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
        // echo $semesters->count();
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
            'role_name' => 'required',
            'semester_id' => 'required',
        ]);

        if (Auth::user()->hasRole($request->role_name)) {
            //save selected semester id for entire session
            if (Auth::user()->hasAnyRole(['hod', 'teacher'])) {
                session([
                    'semester_id' => $request->semester_id,
                    'department_id' => Auth::user()->department_id,
                ]);
            } else {
                session([
                    'semester_id' => $request->semester_id,
                ]);
            }

            return redirect($request->role_name);
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
