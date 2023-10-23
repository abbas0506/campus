<?php

namespace App\Http\Controllers\internal;

use App\Http\Controllers\Controller;
use App\Models\CourseAllocation;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Exception;
use Illuminate\Support\Facades\DB;

class AssessmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function submitted()
    {
        //retrieve only internal related course allocations
        $internal = Auth::user();
        $course_allocations = $internal->intern_course_allocations()->get();
        return view('internal.assessment.submitted', compact('course_allocations'));
    }

    public function pending()
    {
        //retrieve only internal related course allocations
        $internal = Auth::user();
        $course_allocations = $internal->intern_course_allocations()->get();

        return view('internal.assessment.pending', compact('course_allocations'));
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
        return view('internal.assessment.show', compact('course_allocation'));
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
                    'sender_role' => 'internal',
                    'receiver_id' => $course_allocation->teacher->id,
                    'receiver_role' => 'teacher',
                    'message' => 'Reminder: The result of ' . $course_allocation->course->code . ' entitled to ' . $course_allocation->course->name . ' (' . $course_allocation->section->title() . ') is still pending. Please submit it earlier',
                ]);
            }

            DB::commit();

            return redirect()->back()->with('success', 'Reminder successfully sent');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }
    public function notifySingle(Request $request)
    {
        $request->validate([
            'course_allocation_id' => 'required|numeric',

        ]);

        $course_allocation = CourseAllocation::find($request->course_allocation_id);

        DB::beginTransaction();
        try {

            Notification::create([
                'sender_id' => Auth::user()->id,
                'sender_role' => 'hod',
                'receiver_id' => $course_allocation->teacher->id,
                'receiver_role' => 'teacher',
                'message' => 'Reminder: The result of ' . $course_allocation->course->code . ' entitled to ' . $course_allocation->course->name . ' (' . $course_allocation->section->title() . ') is still pending. Please submit it at earlier',
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Reminder successfully sent');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function pdf($id)
    {
        $course_allocation = CourseAllocation::find($id);
        $pdf = PDF::loadView('pdf.award', compact('course_allocation'))->setPaper('a4', 'portrait');

        $pdf->set_option("isPhpEnabled", true);

        return $pdf->stream();
    }
}
