<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Department;
use App\Models\Employee;
use App\Models\User;
use App\Models\UserDepartment;
use Exception;

class HodController extends Controller
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
        $departments = Department::all();
        $selected_department = Department::find($id);

        return view('admin.hods.create', compact('selected_department', 'departments'));
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
            'email' => 'required|email|unique:users',
            'cnic' => 'required|unique:employees'
        ]);
        DB::beginTransaction();
        try {

            $department = Department::findOrFail($id);
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make('password'),
            ]);

            $user->save();

            Employee::create(
                [
                    'user_id' => $user->id,
                    'department_id' => $request->department_id,
                    'cnic' => $request->cnic,
                ]
            );

            DB::commit();
            return redirect('hods')->with('success', 'Successfully assigned');
        } catch (Exception $ex) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors([$ex->getMessage()]);
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
        try {
            $department = Department::findOrFail($id);
            $department->user_id = NULL;
            $department->save();
            return redirect('hods')->with('success', 'Successfully removed');
        } catch (Exception $ex) {
            return redirect()->back()
                ->withErrors([$ex->getMessage()]);
        }
    }

    public function assign(Request $request, $id)
    {
        $users = User::all();
        $departments = Department::all();
        $selected_department = Department::find($id);

        $request->session()->put('selected_department', $selected_department);

        return view('admin.hods.assign', compact('selected_department', 'departments', 'users'));
    }
    public function post_assign(Request $request)
    {
        try {
            $department = $request->session()->pull('selected_department', 'default');
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }


        // $request->validate([
        //     'id' => 'required|numeric',
        //     'user_id' => 'required|numeric',
        // ]);
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

    public function replace(Request $request, $id)
    {

        $departments = Department::all();
        $selected_department = Department::find($id);
        $users = User::whereNot('id', $selected_department->user_id)->get();

        return view('admin.hods.replace', compact('selected_department', 'departments', 'users'));
    }
    public function post_replace(Request $request)
    {
        $request->validate([
            'id' => 'required|numeric',
            'user_id' => 'required|numeric',
        ]);
        try {
            $department = Department::findOrFail($request->id);
            $department->user_id = $request->user_id;
            $department->save();
            return redirect('hods')->with('success', 'Successfully replaced');
        } catch (Exception $ex) {
            return redirect()->back()
                ->withErrors($ex->getMessage());
        }
    }
}
