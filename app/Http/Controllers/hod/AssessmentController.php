<?php

namespace App\Http\Controllers\hod;

use App\Http\Controllers\Controller;
use App\Models\CourseAllocation;
use App\Models\Department;
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
        $department = Department::find(session('department_id'));
        return view('hod.assessment.index', compact('department'));
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
                    'message' => 'Reminder: The result of ' . $course_allocation->course->code . ' entitled to ' . $course_allocation->course->name . ' (' . $course_allocation->section->title() . ') is still pending. Please submit it at earlier',
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

    public function submitted()
    {
        $department = Department::find(session('department_id'));
        return view('hod.assessment.submitted', compact('department'));
    }
    public function pending()
    {
        $department = Department::find(session('department_id'));
        return view('hod.assessment.pending', compact('department'));
    }
}
