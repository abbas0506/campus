<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Semester;
use App\Models\SemesterType;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class SemesterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        ///
        // $semesters = Semester::where('year', '<=', Carbon::now()->format('Y'))->get();
        $semesters = Semester::all();

        return view('admin.semesters.index', compact('semesters'));
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

        try {
            $semester = Semester::latest()->first();
            // increment year after fall
            $year = ($semester->semester_type_id == 2 ? $semester->year + 1 : $semester->year);
            $semester_type_id = ($semester->semester_type_id == 1 ? 2 : 1);
            Semester::create(
                [
                    'year' => $year,
                    'semester_type_id' => $semester_type_id,
                ]
            );
            return redirect('semesters')->with('success', 'Successfully created');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Semester  $semester
     * @return \Illuminate\Http\Response
     */
    public function show(Semester $semester)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Semester  $semester
     * @return \Illuminate\Http\Response
     */
    public function edit(Semester $semester)
    {
        //
        // $seemster=Semester::find($id);
        $semester_types = SemesterType::all();
        return view('admin.semesters.edit', compact('semester_types', 'semester'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Semester  $semester
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Semester $semester)
    {
        //toggle status
        try {
            $semester->status = ($semester->status == 1 ? 0 : 1);
            $semester->update($request->all());
            return redirect('semesters')->with('success', 'Successfully updated');
        } catch (Exception $ex) {
            return redirect()->back()->withErrors($ex->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Semester  $semester
     * @return \Illuminate\Http\Response
     */
    public function destroy(Semester $semester)
    {
        //
        // try {
        //     $semester->delete();
        //     return redirect()->back()->with('success', 'Successfully deleted');
        // } catch (Exception $e) {
        //     return redirect()->back()->withErrors($e->getMessage());
        // }
    }
}
