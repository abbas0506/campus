<?php

namespace App\Http\Controllers\hod;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\SchemeDetail;
use App\Models\SchemeMeta;
use Exception;
use Illuminate\Http\Request;

class SchemeDetailController extends Controller
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
            'course_id' => 'required|numeric',
        ]);

        try {
            //should be HOD department id
            $scheme_detail = SchemeDetail::create([
                'scheme_id' => session('scheme')->id,
                'semester_no' => session('semester_no'),
                'course_id' => $request->course_id,
            ]);

            $scheme_detail->save();
            return redirect()->route('schemes.show', session('scheme'))->with('success', 'Successfully added');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SchemeDetail  $schemeDetail
     * @return \Illuminate\Http\Response
     */
    public function show(SchemeDetail $schemeDetail)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SchemeDetail  $schemeDetail
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        $scheme_meta = SchemeMeta::find($id);
        $scheme_id = $scheme_meta->scheme_id;
        $semester_no = $scheme_meta->semester_no;
        $slot = $scheme_meta->slot;
        $course_type_id = $scheme_meta->course_type_id;

        $course_ids = SchemeDetail::where('scheme_id', $scheme_id)
            ->where('semester_no', $semester_no)
            ->where('slot', 0)
            ->distinct()->get('course_id')->toArray();

        $courses = Course::whereIn('id', $course_ids)
            ->where('course_type_id', $course_type_id)
            ->get();

        return view('hod.scheme_details.edit_meta', compact('courses', 'scheme_meta'));
    }

    // public function edit($semester_no)
    // {
    //     //skip those course which have already been added to this scheme in any semester
    //     session(['semester_no' => $semester_no]);

    //     $course_ids = SchemeDetail::where('scheme_id', session('scheme')->id)->distinct()->get('course_id')->toArray();
    //     $courses = Course::whereNotIn('id', $course_ids)
    //         // ->where('department_id', session('department_id'))
    //         ->get();
    //     return view('hod.scheme_details.edit', compact('courses'));
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SchemeDetail  $schemeDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

        $request->validate([
            'course_id' => 'required|numeric',
        ]);

        $scheme_meta = SchemeMeta::find($id);
        $scheme_id = $scheme_meta->scheme_id;
        $semester_no = $scheme_meta->semester_no;
        $slot = $scheme_meta->slot;
        $course_type_id = $scheme_meta->course_type_id;

        try {
            $scheme_detail = SchemeDetail::where('scheme_id', $scheme_id)
                ->where('semester_no', $semester_no)
                ->where('course_id', $request->course_id)
                ->first();

            $scheme_detail->slot = $slot;
            $scheme_detail->update();

            // echo $scheme_detail->toJson();
            return redirect()->route('schemes.show', session('scheme'))->with('success', 'Successfully added');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SchemeDetail  $schemeDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(SchemeDetail $schemeDetail)
    {
        //
        try {
            $schemeDetail->delete();
            return redirect()->back()->with('success', 'Successfully removed');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
