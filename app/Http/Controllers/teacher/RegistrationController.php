<?php

namespace App\Http\Controllers\teacher;

use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Models\Student;
use Exception;
use Illuminate\Http\Request;
use App\Models\Result;

class RegistrationController extends Controller
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
        $registration = Result::find($id);
        try {
            $registration->delete();
            return redirect()->back()->with('success', 'Successfully deleted');
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    public function bulk_registration(Request $request)
    {
        $request->validate([
            'course_allocation_id' => 'required|numeric',
            'ids_array' => 'required',
        ]);
        $course_allocation_id = $request->course_allocation_id;
        $ids = array();
        $ids = $request->ids_array;
        try {
            if ($ids) {
                foreach ($ids as $id) {
                    Result::create([
                        'student_id' => $id,
                        'course_allocation_id' => $course_allocation_id,
                    ]);
                }
            }
            return response()->json(['msg' => "Successful"]);
        } catch (Exception $ex) {
            return response()->json(['msg' => $ex->getMessage()]);
        }
    }
}
