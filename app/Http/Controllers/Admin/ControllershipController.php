<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControllershipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $user = User::whereHas(
            'roles',
            function ($q) {
                $q->where('name', 'controller');
            }
        )->first();

        return view('admin.controllership.index', compact('user'));
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
        $controller = User::find($id); //existing controller exam
        // $users = User::whereHas(
        //     'roles',
        //     function ($q) {
        //         $q->where('name', 'teacher');
        //     }
        // )->get();
        $users = User::whereNot('id', $id)->get();
        return view('admin.controllership.edit', compact('users', 'controller'));
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
            'existing_controller_id' => 'required|numeric',
        ]);
        DB::beginTransaction();
        try {
            $future_controller = User::find($id);
            $existing_controller = User::find($request->existing_controller_id);
            $existing_controller->removeRole('controller');
            $future_controller->assignRole('controller');
            $existing_controller->update();
            $future_controller->update();

            DB::commit();
            return redirect('controllership')->with('success', 'Successfully replaced');
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
    }
}
