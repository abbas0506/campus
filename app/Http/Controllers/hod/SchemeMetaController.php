<?php

namespace App\Http\Controllers\hod;

use App\Http\Controllers\Controller;
use App\Models\CourseType;
use App\Models\Scheme;
use App\Models\SchemeMeta;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SchemeMetaController extends Controller
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
    public function create($scheme_id, $semester_no)
    {
        //
        $scheme = Scheme::find($scheme_id);
        $slot = SchemeMeta::where('scheme_id', $scheme_id)
            ->where('semester_no', $semester_no)
            ->max('slot');

        if ($slot)
            $slot++;
        else
            $slot = 1;   //default start

        $course_types = CourseType::all();

        return view('hod.schemes.meta.create', compact('scheme', 'semester_no', 'slot', 'course_types'));
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
            'semester_no' => 'required|numeric',
            'slot' => 'required|numeric',
            'course_type_id' => 'required|numeric',
            'cr' => 'required|numeric',
        ]);
        DB::beginTransaction();
        try {

            $meta = SchemeMeta::create($request->all());

            DB::commit();
            return redirect()->route('schemes.show', $request->scheme_id)->with('success', 'Successfully created');
        } catch (Exception $ex) {
            DB::rollBack();
            return redirect()->back()->withErrors($ex->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SchemeMeta  $schemeMeta
     * @return \Illuminate\Http\Response
     */
    public function show(SchemeMeta $schemeMeta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SchemeMeta  $schemeMeta
     * @return \Illuminate\Http\Response
     */
    public function edit(SchemeMeta $schemeMeta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SchemeMeta  $schemeMeta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SchemeMeta $schemeMeta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SchemeMeta  $schemeMeta
     * @return \Illuminate\Http\Response
     */
    public function destroy(SchemeMeta $schemeMeta)
    {
        //
    }
}
