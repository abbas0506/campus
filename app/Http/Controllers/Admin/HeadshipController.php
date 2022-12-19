<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Headship;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class HeadshipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

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
        $selected_department = Department::find(session('department_id'));
        return view('admin.headship.create', compact('selected_department', 'departments'));
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
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'cnic' => 'required|unique:users|max:13|min:13',
            'department_id' => 'required|numeric',
        ]);
        DB::beginTransaction();
        try {

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make('password'),
                'cnic' => $request->cnic,
                'department_id' => $request->department_id,
            ]);

            $user->save();
            $user->assignRole('hod', 'teacher');

            Headship::create([
                'user_id' => $user->id,
                'department_id' => $request->department_id,
            ]);

            DB::commit();
            return redirect('departments')->with('success', 'Successfully created');
        } catch (Exception $ex) {
            DB::rollBack();
            return redirect()->back()->withErrors($ex->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Headship  $headship
     * @return \Illuminate\Http\Response
     */
    public function show(Headship $headship)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Headship  $headship
     * @return \Illuminate\Http\Response
     */
    public function edit($department_id)
    {
        //

        $users = User::whereHas(
            'roles',
            function ($q) {
                $q->where('name', 'teacher');
            }
        )->get();

        $departments = Department::all();   //to filter by department
        session([
            'department_id' => $department_id,
        ]);

        $selected_department = Department::find($department_id);
        return view('admin.headship.edit', compact('departments', 'users', 'selected_department'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Headship  $headship
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $user_id)
    {
        //
        DB::beginTransaction();
        try {
            $department_id = session('department_id');
            $department = Department::find($department_id);


            if ($department->headship) {
                //department hod exists, just update eixsting
                $headship = $department->headship;
                //if user heads only this department, clear hod role
                if ($headship->user->headships->count() == 1)
                    $headship->user->removeRole('hod');
                $headship->user_id = $user_id;
                $headship->update();

                //assign role
                $department = Department::find($department_id);
                $department->headship->user->assignRole('hod');
                DB::commit();
                return redirect('departments')->with('success', 'Successfully replaced');
            } else {
                $headship = Headship::create([
                    'department_id' => $department->id,
                    'user_id' => $user_id,

                ]);
                //assign role
                $headship->user->assignRole('hod');
                DB::commit();
                return redirect('departments')->with('success', 'Successfully assigned');
            }
        } catch (Exception $ex) {
            DB::rollBack();
            return redirect()->back()->withErrors($ex->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Headship  $headship
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        try {
            $department = Department::find($id);
            if ($department->headship->user->headships->count() == 1)
                $department->headship->user->removeRole('hod');
            $department->headship->delete();
            return redirect('departments')->with('success', 'Successfully removed');
        } catch (Exception $ex) {
            return redirect()->back()
                ->withErrors($ex->getMessage());
        }
    }
}
