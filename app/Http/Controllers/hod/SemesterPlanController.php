<?php

namespace App\Http\Controllers\hod;

use App\Http\Controllers\Controller;
use App\Models\CourseAllocation;
use App\Models\Department;
use App\Models\Section;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SemesterPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $department = Department::find(session('department_id'));
        $programs = $department->programs;

        return view('hod.semester-plan.index', compact('programs'));
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
        $section = Section::find($id);
        if (!$section->course_allocations()->for(session('semester_id'))->exists()) {
            //if empty, auto create course allocation plan according to related scheme
            DB::beginTransaction();
            try {
                $semester_no = $section->clas->semesterNo(session('semester_id'));
                // retrieve all slots for current semester
                foreach ($section->clas->scheme->slots()->for($semester_no)->get()->sortBy('slot_no') as $slot) {
                    //if slot has fixed course, save as it is
                    foreach ($slot->slot_options as $slot_option) {
                        if ($slot_option->course()->exists())
                            $course_id = $slot_option->course_id;
                        else
                            $course_id = null;

                        CourseAllocation::create([
                            'semester_id' => session('semester_id'),
                            'section_id' => $section->id,
                            'slot_option_id' => $slot_option->id,
                            'course_id' => $course_id,
                        ]);
                    }
                }
                DB::commit();
            } catch (Exception $ex) {
                DB::rollBack();
                return redirect()->back()->withErrors($ex->getMessage());
            }
        }
        return view('hod.semester-plan.show', compact('section'));
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
    }
}
