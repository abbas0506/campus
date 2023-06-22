<?php

namespace App\Http\Controllers\teacher;

use App\Http\Controllers\Controller;
use App\Models\CourseAllocation;
use App\Models\FirstAttempt;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FirstAttemptController extends Controller
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
        $request->validate([
            'course_allocation_id' => 'required|numeric',
            'ids_array' => 'required',
        ]);

        $course_allocation = CourseAllocation::find($request->course_allocation_id);
        $ids = array();
        $ids = $request->ids_array;
        DB::beginTransaction();
        //stop if already registered
        try {
            if ($ids) {
                foreach ($ids as $id) {
                    //register students for this course
                    FirstAttempt::create([
                        'student_id' => $id,
                        'semester_no' => $course_allocation->section->clas->semester_no,
                        'semester_id' => $course_allocation->semester_id,
                        'course_allocation_id' => $request->course_allocation_id,
                    ]);
                }
            }
            DB::commit();
            return response()->json(['msg' => "Successfully saved"]);
        } catch (Exception $ex) {
            DB::rollBack();
            return response()->json(['msg' => $ex->getMessage()]);
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
            $first_attempt = FirstAttempt::find($id);
            $first_attempt->delete();
            return redirect()->back()->with('success', 'Successfully removed');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
