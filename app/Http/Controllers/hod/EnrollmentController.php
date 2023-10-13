<?php

namespace App\Http\Controllers\hod;

use App\Http\Controllers\Controller;
use App\Models\CourseAllocation;
use App\Models\FirstAttempt;
use App\Models\Student;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EnrollmentController extends Controller
{
    //
    public function fresh($id)
    {
        $course_allocation = CourseAllocation::find($id);

        $first_attempts = $course_allocation->first_attempts();
        $student_ids = $first_attempts->pluck('student_id')->toArray();

        $registered = Student::whereIn('id', $student_ids)
            ->where('section_id', $course_allocation->course_id)->get();

        //get not registered students
        $unregistered = Student::whereNotIn('id', $student_ids)
            ->where('section_id', $course_allocation->section_id)
            ->where('status_id', 1) //only active
            ->get();

        return view('hod.courseplan.enrollment.fresh', compact('course_allocation', 'unregistered'));
    }

    public function reappear($id)
    {
        $course_allocation = CourseAllocation::find($id);
        return view('hod.courseplan.enrollment.reappear', compact('course_allocation'));
    }

    public function searchReappearData(Request $request)
    {
        $request->validate([
            'rollno' => 'required',
            'course_allocation_id' => 'required|numeric',
        ]);
        // echo $request->rollno;
        $student = Student::where('rollno', $request->rollno)->first();
        // echo $student->name;
        return redirect()->back()->with(['student' => $student]);
    }

    public function  enrollFresh(Request $request)
    {
        $request->validate([
            'ids' => 'required',
            'course_allocation_id' => 'required|numeric',
        ]);

        $course_allocation = CourseAllocation::find($request->course_allocation_id);

        DB::beginTransaction();

        try {
            foreach ($request->ids as $id) {
                //register all selected students for this course
                FirstAttempt::create([
                    'student_id' => $id,
                    'semester_id' => $course_allocation->semester_id,
                    'course_allocation_id' => $course_allocation->id,
                ]);
            }
            DB::commit();
            return redirect()->route('hod.courseplan.edit', $course_allocation->id)->with('success', 'Successfully enrolled!');
        } catch (Exception $ex) {
            DB::rollBack();
            return response()->json(['msg' => $ex->getMessage()]);
        }
    }
}
