<?php

namespace App\Http\Controllers\hod;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseType;
use App\Models\Department;
use Illuminate\Http\Request;
use Exception;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $courses = Course::where('department_id', session('department_id'))->get();
        $course_types = CourseType::all();
        return view('hod.courses.index', compact('courses', 'course_types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $course_types = CourseType::all();
        $courses = Course::where('department_id', session('department_id'))->get();
        return view('hod.courses.create', compact('course_types', 'courses'));
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
        //append id of hod's current department
        $request->merge(['department_id' => session('department_id')]);
        $request->validate([
            'name' => 'required',
            'code' => 'nullable|required_if:course_type_id,1',
            'course_type_id' => 'required|numeric',
            // 'short' => 'required',
            'cr_theory' => 'required|numeric',
            'marks_theory' => 'required|numeric',
            'cr_practical' => 'required|numeric',
            'marks_practical' => 'required|numeric',
            'department_id' => 'required|numeric',
        ]);

        try {
            Course::create($request->all());

            return redirect()->route('hod.courses.index')->with('success', 'Successfully created');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
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
        $course = Course::findOrFail($id);
        $prerequisite_courses = Course::where('department_id', session('department_id'))
            ->where('id', '<>', $course->id)
            ->get();
        $course_types = CourseType::all();
        return view('hod.courses.edit', compact('course', 'course_types', 'prerequisite_courses'));
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
        $request->validate([
            'name' => 'required',
            'short' => 'required',
            'code' => 'nullable|required_if:course_type_id,1',
            'course_type_id' => 'required|numeric',
            'cr_theory' => 'required|numeric',
            'marks_theory' => 'required|numeric',
            'cr_practical' => 'required|numeric',
            'marks_practical' => 'required|numeric',

        ]);

        try {
            $course = Course::findOrFail($id);
            $course->update($request->all());
            return redirect()->route('hod.courses.index')->with('success', 'Successfully updated');;
        } catch (Exception $ex) {
            return redirect()->back()
                ->withErrors($ex->getMessage());
        }
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
        $course = Course::findOrFail($id);
        try {
            $course->delete();
            return redirect()->back()->with('success', 'Successfully deleted');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }
}
