<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use App\Models\Department;
use App\Models\Teacher;
use App\Models\Hod;
use App\Models\User;
use Illuminate\Http\Request;
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
        $departments = Department::all();
        $selected_department = Department::find(session('department_id'));
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
            'cnic' => 'required|unique:teachers'
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

            $teacher = Teacher::create(
                [
                    'user_id' => $user->id,
                    'department_id' => $department->id,
                    'cnic' => $request->cnic,
                ]
            );

            Hod::create([
                'teacher_id' => $teacher->id,
                'department_id' => $department->id,
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
    public function edit($department_id)
    {
        //
        $teachers = Teacher::all();
        $departments = Department::all();   //to filter by department
        session([
            'department_id' => $department_id,
        ]);

        $selected_department = Department::find($department_id);
        return view('admin.hods.edit', compact('departments', 'teachers', 'selected_department'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $teacher_id)
    {
        DB::beginTransaction();
        try {
            $department_id = session('department_id');
            $department = Department::find($department_id);
            echo $department->hod;
            if ($department->hod) {
                //department hod exists, just update eixsting
                $hod = $department->hod;
                $hod->teacher->user->removeRole('hod');
                $hod->teacher_id = $teacher_id;
                $hod->update();

                //assign role
                $department = Department::find($department_id);
                $department->hod->teacher->user->assignRole('hod');
                DB::commit();
                return redirect('hods')->with('success', 'Successfully replaced');
            } else {
                $hod = Hod::create([
                    'teacher_id' => $teacher_id,
                    'department_id' => $department->id,
                ]);
                //assign role
                $hod->teacher->user->assignRole('hod');
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //

        try {
            $department = Department::find($id);
            $department->hod->teacher->user->removeRole('hod');
            $department->hod->delete();
            return redirect('departments')->with('success', 'Successfully removed');
        } catch (Exception $ex) {
            return redirect()->back()
                ->withErrors($ex->getMessage());
        }
    }
}
