<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

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
        try {
            $department = Department::findOrFail($id);
            $department->user_id = NULL;
            $department->save();
            // $department->update($request->all());
            return redirect('hods')->with('success', 'Successfully assigned');
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

        return view('admin.hods.assign', compact('selected_department', 'departments', 'users'));
    }
    public function post_assign(Request $request)
    {
        $request->validate([
            'id' => 'required|numeric',
            'user_id' => 'required|numeric',
        ]);
        try {
            $department = Department::findOrFail($request->id);
            $department->user_id = $request->user_id;
            $department->save();
            // $department->update($request->all());
            return redirect('hods')->with('success', 'Successfully assigned');
        } catch (Exception $ex) {
            return redirect()->back()
                ->withErrors([$ex->getMessage()]);
        }
    }
}
