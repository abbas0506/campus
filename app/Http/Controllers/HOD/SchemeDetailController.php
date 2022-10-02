<?php

namespace App\Http\Controllers\hod;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\SchemeDetail;
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
    public function edit($semester_no)
    {
        //skip those course which have already been added to this scheme in any semester
        session(['semester_no' => $semester_no]);

        $course_ids = SchemeDetail::where('scheme_id', session('scheme')->id)->distinct()->get('course_id')->toArray();
        $courses = Course::whereNotIn('id', $course_ids)->get();
        return view('hod.scheme_details.edit', compact('courses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SchemeDetail  $schemeDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SchemeDetail $schemeDetail)
    {
        //


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
