<?php

namespace App\Http\Controllers\teacher;

use App\Http\Controllers\Controller;
use App\Models\CourseAllocation;
use App\Models\CourseTrack;
use Exception;
use Illuminate\Http\Request;
use App\Models\Result;
use Illuminate\Support\Facades\DB;

class CourseTrackController extends Controller
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
        $course_allocation_id = $request->course_allocation_id;
        $course_allocation = CourseAllocation::find($course_allocation_id);
        $ids = array();
        $ids = $request->ids_array;
        DB::beginTransaction();
        try {
            if ($ids) {
                foreach ($ids as $id) {
                    //create course enrollment entry
                    $course_track = CourseTrack::create([
                        'student_id' => $id,
                        'program_id' => $course_allocation->section->clas->program_id,
                        'course_id' => $course_allocation->course_id,
                        'semester_no' => $course_allocation->section->clas->semester_no,
                    ]);

                    Result::create([
                        'course_track_id' => $course_track->id,
                        'teacher_id' => $course_allocation->teacher_id,
                        'semester_id' => session('semester_id'),
                        'semester_no' => $course_allocation->section->clas->semester_no,

                    ]);
                    // Result::create([
                    //     'student_id' => $id,
                    //     'course_allocation_id' => $course_allocation_id,
                    // ]);
                }
            }
            DB::commit();
            return response()->json(['msg' => "Successful"]);
        } catch (Exception $ex) {
            DB::rollBack();
            return response()->json(['msg' => $ex->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CourseTrack  $courseTrack
     * @return \Illuminate\Http\Response
     */
    public function show(CourseTrack $courseTrack)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CourseTrack  $courseTrack
     * @return \Illuminate\Http\Response
     */
    public function edit(CourseTrack $courseTrack)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CourseTrack  $courseTrack
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CourseTrack $courseTrack)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CourseTrack  $courseTrack
     * @return \Illuminate\Http\Response
     */
    public function destroy(CourseTrack $courseTrack)
    {
        //
    }
}
