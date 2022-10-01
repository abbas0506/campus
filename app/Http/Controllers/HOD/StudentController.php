<?php

namespace App\Http\Controllers\hod;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Nationality;
use App\Models\Program;
use App\Models\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        if (session('semester') && session('program') && session('shift') && session('section')) {
            $students = Student::where('semester_id', session('semester')->id)
                ->where('program_id', session('program')->id)
                ->where('shift', session('shift'))
                ->where('section_id', session('section')->id)
                ->get();
            return view('hod.students.index', compact('students'));
        } else
            echo "Something missing";
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('hod.students.create');
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
            'name' => 'required|string|max:50',
            'gender' => 'required|string|max:1',
            'cnic' => 'required|unique:students|string|max:15',
            'phone' => 'nullable|unique:students|string|max:15',
            'email' => 'required|email|unique:users',

        ]);

        try {
            //should be HOD department id
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make('password'),
            ]);

            $user->save();
            $user->assignRole('student');

            Student::create(
                [
                    'user_id' => $user->id,
                    'program_id' => session('program')->id,
                    'semester_id' => session('semester')->id,
                    'shift' => session('shift'),
                    'section_id' => session('section')->id,
                    'gender' => $request->gender,
                    'phone' => $request->phone,
                    'cnic' => $request->cnic,
                    'address' => $request->address,
                ]
            );

            DB::commit();
            return redirect()->route('students.index')->with('success', 'Successfully created');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['create' => $e->getMessage()]);
            // something went wrong
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
        $student = Student::findOrFail($id);
        return view('hod.students.edit', compact('student'));
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
        $student = Student::find($id);
        $request->validate([
            'name' => 'required|string|max:50',
            'gender' => 'required|string|max:1',
            'cnic' => 'required|string|max:15|unique:students,cnic,' . $id, 'id',
            'phone' => 'nullable|string|max:15|unique:students,phone,' . $id, 'id',
            'email' => 'required|email|unique:users,email,' . $student->user->id, 'id',
            'address' => 'nullable'

        ]);

        try {
            $student->gender = $request->gender;
            $student->cnic = $request->cnic;
            $student->phone = $request->phone;
            $student->address = $request->address;

            $student->update();

            $user = $student->user;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->update();

            return redirect()->route('students.index')->with('success', 'Successfully updated');;
        } catch (Exception $ex) {
            return redirect()->back()
                ->withErrors($ex->getMessage());
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
        $student = Student::findOrFail($id);
        try {
            $student->delete();
            return redirect()->back()->with('success', 'Successfully deleted');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['deletion' => $e->getMessage()]);
            // something went wrong
        }
    }
}
