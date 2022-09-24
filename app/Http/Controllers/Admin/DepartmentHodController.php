<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Hod;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;

class DepartmentHodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $departments = Department::all();
        return view('admin.hods.index', compact('departments'));
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
        $selected_department = session('selected_department');
        return view('admin.hods.create', compact('selected_department', 'departments'));
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
            'cnic' => 'required|unique:employees'
        ]);
        DB::beginTransaction();
        try {

            $department = session('selected_department');
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make('password'),
            ]);

            $user->save();
            $user->assignRole('hod');

            $employee = Employee::create(
                [
                    'user_id' => $user->id,
                    'department_id' => $department->id,
                    'cnic' => $request->cnic,
                ]
            );

            Hod::create([
                'employee_id' => $employee->id,
                'department_id' => $department->id,
            ]);

            DB::commit();
            return redirect('departmenthods')->with('success', 'Successfully created');
        } catch (Exception $ex) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors($ex->getMessage());
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
        $employees = Employee::all();
        $departments = Department::all();
        $selected_department = Department::find($id);
        session([
            'selected_department' => $selected_department
        ]);

        return view('admin.hods.edit', compact('departments', 'employees', 'selected_department'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $employee_id)
    {
        try {
            $department = session('selected_department');

            if ($department->hod) {
                //department hod exists, just update eixsting
                $hod = $department->hod;
                $hod->employee_id = $employee_id;
                $hod->update();
                return redirect('departmenthods')->with('success', 'Successfully replaced');
            } else {
                Hod::create([
                    'employee_id' => $employee_id,
                    'department_id' => $department->id,
                ]);
                return redirect('departmenthods')->with('success', 'Successfully assigned');
            }
        } catch (Exception $ex) {
            return redirect()->back()
                ->withErrors($ex->getMessage());
        }
        // $request->validate([
        //     'user_id' => 'required|numeric',
        // ]);
        // $request->mer
        // try {
        //     $department = Department::findOrFail($request->id);
        //     $department->user_id = $request->user_id;
        //     $department->save();
        //     // $department->update($request->all());
        //     return redirect('hods')->with('success', 'Successfully assigned');
        // } catch (Exception $ex) {
        //     return redirect()->back()
        //         ->withErrors([$ex->getMessage()]);
        // }
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

        try {
            $department = Department::find($id);
            $department->hod->delete();
            return redirect('departmenthods')->with('success', 'Successfully removed');
        } catch (Exception $ex) {
            return redirect()->back()
                ->withErrors($ex->getMessage());
        }
    }

    // public function viewAssignHod(Request $request, $id)
    // {
    //     $employees = Employee::all();
    //     $departments = Department::all();
    //     $selected_department = Department::find($id);

    //     $request->session()->put('selected_department', $selected_department);

    //     return view('admin.hods.assign', compact('departments', 'employees', 'selected_department'));
    // }
}
