<?php

namespace App\Http\Controllers\hod;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\Jobtype;
use App\Models\Nationality;
use App\Models\Prefix;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;

class EmployeeController extends Controller
{
    //
    public function index()
    {
        //
        $employees = Employee::where('department_id', Auth::user()->employee->department_id)->get();
        return view('hod.employees.index', compact('employees'));
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
        $prefixes = Prefix::all();
        $designations = Designation::all();
        $jobtypes = Jobtype::all();
        $nationalities = Nationality::all();
        return view('hod.employees.create', compact('departments', 'prefixes', 'designations', 'jobtypes', 'nationalities'));
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
            'designation_id' => 'required|numeric',
            'cnic' => 'required|unique:employees|string|max:15',
            'phone' => 'required|unique:employees|string|max:15',
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
            $user->assignRole('examiner');

            Employee::create(
                [
                    'user_id' => $user->id,
                    'designation_id' => $request->designation_id,
                    'phone' => $request->phone,
                    'cnic' => $request->cnic,
                    'department_id' => Auth::user()->employee->department_id,

                ]
            );

            DB::commit();
            return redirect()->route('employees.index')->with('success', 'Successfully created');
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
        $employee = Employee::findOrFail($id);
        $departments = Department::all();
        $designations = Designation::all();
        return view('hod.employees.edit', compact('employee', 'departments', 'designations'));
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
        $employee = Employee::find($id);
        $request->validate([
            'name' => 'required|string|max:50',
            'designation_id' => 'required|numeric',
            'cnic' => 'required|string|max:15|unique:employees,cnic,' . $id, 'id',
            'phone' => 'required|string|max:15|unique:employees,phone,' . $id, 'id',
            'email' => 'required|email|unique:users,email,' . $employee->user->id, 'id',

        ]);

        try {

            $employee->designation_id = $request->designation_id;
            $employee->phone = $request->phone;
            $employee->update();

            $user = $employee->user;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->update();

            return redirect()->route('employees.index')->with('success', 'Successfully updated');;
        } catch (Exception $ex) {
            return redirect()->back()
                ->withErrors(['update' => $ex->getMessage()]);
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
        $employee = Employee::findOrFail($id);
        try {
            $employee->delete();
            return redirect()->back()->with('success', 'Successfully deleted');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['deletion' => $e->getMessage()]);
            // something went wrong
        }
    }
}
