<?php

namespace App\Http\Controllers\hod;

use App\Http\Controllers\Controller;

use App\Models\Course;
use App\Models\CourseAllocation;
use App\Models\Teacher;
use App\Models\Scheme;
use App\Models\SchemeDetail;
use App\Models\Section;
use App\Models\Semester;
use Exception;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseAllocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        
        $course_allocations = session('course_allocations');
        $scheme = session('course_allocations_scheme');
        return view('hod.course_allocations.index', compact('course_allocations', 'scheme'));
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
            'scheme_id' => 'required|numeric',
            'semester_id' => 'required',
            'shift_id' => 'required',
            'section_id' => 'required|numeric|max:10',
        ]);

        $scheme = Scheme::find($request->scheme_id);

        DB::beginTransaction();
        try {
            foreach ($scheme->scheme_details as $scheme_detail) {
                CourseAllocation::create([
                    'semester_id' => $request->semester_id,
                    'shift_id' => $request->shift_id,
                    'section_id' => $request->section_id,
                    'scheme_detail_id' => $scheme_detail->id,
                    'course_id' => $scheme_detail->course_id,
                ]);
            }
            DB::commit();
            $course_allocations = CourseAllocation::where('semester_id', $request->semester_id)
                ->where('shift_id', $request->shift_id)
                ->where('section_id', $request->section_id)
                ->get();

            session([

                'course_allocations_scheme' => $scheme,
                'course_allocations' => $course_allocations,
            ]);

            return redirect()->route('course-allocations.index')->with('msg', "data has been called");
            // return redirect()->route('course-allocations.index', ['course_allocations' => $course_allocations]);
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }


        // return view('hod.course_allocations.index', compact('scheme'));
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
        $scheme_detail = SchemeDetail::find($id);
        session([
            'scheme_detail' => $scheme_detail,
        ]);
        $teachers = Teacher::all();
        return view('hod.course_allocations.choices.teacher', compact('teachers'));
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
        CourseAllocation::create([
            'semester_id' => session('semester')->id,
            'shift_id' => session('shift_id'),
            'section_id' => session('section')->id,
            'scheme_detail_id' => session('scheme_detail')->id,
            'teacher_id' => $request->teacher_id,

        ]);
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
