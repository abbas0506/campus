<?php

namespace App\Http\Controllers\hod;

use App\Http\Controllers\Controller;
use App\Models\CourseAllocation;
use App\Models\Notification;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AssessmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // $course_allocations = CourseAllocation::Join('sections', 'section_id', 'sections.id')
        //     ->Join('clas', 'clas_id', 'clas.id')
        //     ->join('programs', 'program_id', 'programs.id')
        //     ->where('semester_id', session('semester_id'))
        //     ->whereNotNull('course_id')
        //     ->whereNotNull('teacher_id')
        //     ->orderBy('programs.id')
        //     ->orderBy('clas.id')
        //     ->orderBy('sections.name')
        //     // ->orderBy('course_allocations.submitted_at', 'desc')
        //     ->get();
        $course_allocations = CourseAllocation::where('semester_id', session('semester_id'))
            ->whereNotNull('course_id')
            ->whereNotNull('teacher_id')
            ->get();

        return view('hod.assessment.index', compact('course_allocations'));
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
        $course_allocation = CourseAllocation::find($id);
        return view('hod.assessment.show', compact('course_allocation'));
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
    public function notifyMissing(Request $request)
    {
        $missing_allocations = CourseAllocation::where('semester_id', session('semester_id'))
            ->whereNotNull('course_id')
            ->whereNotNull('teacher_id')
            ->whereNull('submitted_at')
            ->get();

        DB::beginTransaction();
        try {
            foreach ($missing_allocations as $course_allocation) {
                Notification::create([
                    'sender_id' => Auth::user()->id,
                    'sender_role' => 'hod',
                    'receiver_id' => $course_allocation->teacher->id,
                    'receiver_role' => 'teacher',
                    'message' => 'Reminder: The result of ' . $course_allocation->course->code . ' entitled to ' . $course_allocation->course->name . ' (' . $course_allocation->section->title() . ') is still pending. Please submit it as early as possible',
                ]);
            }

            DB::commit();

            return redirect()->route('hod.assessment.index')->with('success', 'Reminder successfully sent');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }
    public function unlock(Request $request, $id)
    {
        $course_allocation = CourseAllocation::findOrFail($id);
        try {
            $course_allocation->submitted_at = null;
            $course_allocation->update();
            return redirect()->back()->with('success', "Successfully unlocked");
        } catch (Exception $ex) {
            DB::rollBack();
            return redirect()->back()->withErrors($ex->getMessage());
        }
    }
}
