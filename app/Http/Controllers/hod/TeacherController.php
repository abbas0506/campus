<?php

namespace App\Http\Controllers\hod;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Exception;

class TeacherController extends Controller
{
    //
    public function index()
    {
        $department = Department::find(session('department_id'));
        $teachers = $department->teachers();
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
        return view('hod.teachers.create');
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
        $request->merge(['department_id' => session('department_id')]);
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'nullable|unique:users',
            'cnic' => 'nullable|unique:users',
            'department_id' => 'required|numeric'

        ]);
        DB::beginTransaction();
        try {
            // generate random password for teacher
            $random_password = Str::random(8);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($random_password),
                'phone' => $request->phone,
                'cnic' => $request->cnic,
                'department_id' => $request->department_id,
            ]);

            $user->assignRole(['teacher']);

            // intimate teacher 
            Mail::raw('Respected teacher, here is your password for exam portal. Please dont share it with anyone!  ' . $random_password, function ($message) use ($user) {
                $message->to($user->email);
                $message->subject("Password for Exam Portal!");
            });
            Db::commit();
            return redirect()->route('hod.teachers.index')->with('success', 'Successfully created');
        } catch (Exception $ex) {
            DB::rollBack();
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
        return view('hod.teachers.edit', compact('teacher'));
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
        $request->validate([
            'name' => 'required',
            // 'email' => 'required|email|unique:users,email,' . $id, 'id',
            'cnic' => 'nullable|unique:users,cnic,' . $id, 'id',
        ]);


        try {
            $user = User::findOrFail($id);
            $user->update($request->all());

            return redirect()->route('hod.teachers.index')->with('success', 'Successfully updated');;
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
        $teacher = User::findOrFail($id);
        try {
            $teacher->delete();
            return redirect()->back()->with('success', 'Successfully deleted');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }
}
