<?php

namespace App\Http\Controllers\hod;

use App\Http\Controllers\Controller;
use App\Models\CourseAllocation;
use App\Models\FirstAttempt;
use App\Models\Reappear;
use App\Models\Student;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Svg\Tag\Rect;

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

        return view('hod.course-allocations.enrollment.fresh', compact('course_allocation', 'unregistered'));
    }

    public function reappear($id)
    {
        $course_allocation = CourseAllocation::find($id);
        return view('hod.course-allocations.enrollment.reappear', compact('course_allocation'));
    }

    // enroll fresh student
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
            return redirect()->route('hod.course-allocations.show', $course_allocation)->with('success', 'Successfully enrolled!');
        } catch (Exception $ex) {
            DB::rollBack();
            return redirect()->back()->withErrors($ex->getMessage());
        }
    }

    // enroll reappearin student
    public function  enrollReappear(Request $request)
    {
        $request->validate([
            'rollno' => 'required',
            'course_allocation_id' => 'required|numeric',
        ]);

        $student = Student::where('rollno', $request->rollno)->first();
        $requested_course_allocation = CourseAllocation::find($request->course_allocation_id);
        //search for an attempt in the course before current semester
        $basic_attempt_in_course = $student->first_attempts()
            ->course($requested_course_allocation->course_id)
            ->where('semester_id', '<', $requested_course_allocation->semester_id)
            ->first();

        // intitally reset eligiblity to reappear in the course
        $eligible_to_reappear = 0;

        if (!$basic_attempt_in_course)
            return redirect()->back()->with('warning', 'Student has never apeared in this course!');
        else {
            $last_attempt_in_course = $basic_attempt_in_course;
            foreach ($basic_attempt_in_course->reappears as $later_attempt)
                $last_attempt_in_course = $later_attempt;

            if ($last_attempt_in_course->obtained() < 50) {
                //failure case,  allow reeappear
                $eligible_to_reappear = 1;
            } elseif ($last_attempt_in_course->gpa() < 3.5) {
                //passed but low gp, eligible for improvement
                //improvement chances can also be tested here
                $eligible_to_reappear = 1;
            } else
                return redirect()->back()->with('warning', 'Student has already passed the course with GP >=3.5!');
        }

        if ($eligible_to_reappear) {
            // check if already enrolled in the same course during same semester
            $already_enrolled = Reappear::where('first_attempt_id', $basic_attempt_in_course->id)
                ->where('course_allocation_id', $requested_course_allocation->id)
                ->where('semester_id', $requested_course_allocation->semester_id)
                ->count();
            if ($already_enrolled) {
                return redirect()->back()->with('warning', 'Already enrolled in the same course!');
            } else {
                //previously not enrolled 
                try {
                    Reappear::create([
                        'first_attempt_id' => $basic_attempt_in_course->id,
                        'semester_id' => $requested_course_allocation->semester_id,
                        'course_allocation_id' => $requested_course_allocation->id,
                    ]);
                    return redirect()->back()->with('success', 'Successfully added');
                } catch (Exception $e) {
                    return redirect()->back()->withErrors($e->getMessage());
                    // something went wrong
                }
            }
        }
    }

    public function searchReappearData(Request $request)
    {
        $request->validate([
            'rollno' => 'required',
        ]);
        $student = Student::where('rollno', $request->rollno)->first();
        return redirect()->back()->with(['student' => $student]);
    }


    public function destroyFresh($attempt_id)
    {
        try {
            $attempt = FirstAttempt::find($attempt_id);
            $attempt->delete();
            return redirect()->back()->with('success', 'Successfully removed');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
    public function destroyReappear($attempt_id)
    {
        try {
            $attempt = Reappear::find($attempt_id);
            $attempt->delete();
            return redirect()->back()->with('success', 'Successfully removed');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
