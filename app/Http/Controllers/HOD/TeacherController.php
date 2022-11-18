<?php

namespace App\Http\Controllers\hod;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use App\Models\Department;
use App\Models\Designation;
use App\Models\Teacher;
use App\Models\Jobtype;
use App\Models\Nationality;
use App\Models\Prefix;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;

class TeacherController extends Controller
{
    //
    public function index()
    {
        //teachers from the same department as hod
        $teachers = User::whereHas(
            'roles',
            function ($q) {
                $q->where('name', 'teacher');
            }
        )->where('department_id', session('department_id'))->get();

        return view('hod.teachers.index', compact('teachers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $departments = Department::all();
        $designations = Designation::all();

        return view('hod.teachers.create', compact('departments', 'designations'));
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
            'email' => 'required|email|unique:users',
            'cnic' => 'required|unique:teachers',
            'department_id' => 'required|numeric'

        ]);
        try {

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make('password'),
                'phone' => $request->phone,
                'cnic' => $request->cnic,
                'department_id' => $request->department_id,
            ]);

            $user->save();
            $user->assignRole(['teacher']);
            return redirect('teachers')->with('success', 'Successfully created');
        } catch (Exception $ex) {
            return redirect()->back()->withErrors($ex->getMessage());
        }
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
        $teacher = User::findOrFail($id);
        $departments = Department::all();
        return view('hod.teachers.edit', compact('teacher', 'departments'));
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
        $teacher = Teacher::find($id);
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email,' . $id, 'id',
            'cnic' => 'unique:users,cnic,' . $id, 'id',
        ]);


        try {
            $user = User::findOrFail($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->cnic = $request->cnic;
            $user->department_id = $request->department_id;
            $user->save();

            return redirect('teachers')->with('success', 'Successfully updated');;
        } catch (Exception $ex) {
            return redirect()->back()->withErrors($ex->getMessage());
        }
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
        $teacher = Teacher::findOrFail($id);
        try {
            $teacher->delete();
            return redirect()->back()->with('success', 'Successfully deleted');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['deletion' => $e->getMessage()]);
            // something went wrong
        }
    }
}
