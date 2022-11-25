<?php

namespace App\Http\Controllers\hod;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Support\Facades\DB;
use App\Models\Student;
use Illuminate\Http\Request;

use Exception;

class StudentController extends Controller
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
        $section = Section::find(session('section_id'));
        return view('hod.students.create', compact('section'));
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
            'name' => 'required|string|max:100',
            'father' => 'required|string|max:100',
            'gender' => 'required|string|max:1',
            'rollno' => 'required|string|unique:students|max:20',
            'regno' => 'nullable|string|unique:students|max:20',

        ]);

        try {
            //should be HOD department id
            // $user = User::create([
            //     'name' => $request->name,
            //     'email' => $request->email,
            //     'password' => Hash::make('password'),
            // ]);

            // $user->save();
            // $user->assignRole('student');

            Student::create(
                [
                    // 'user_id' => $user->id,
                    'name' => $request->name,
                    'father' => $request->father,
                    'gender' => $request->gender,
                    'rollno' => $request->rollno,
                    'regno' => $request->regno,

                    'section_id' => session('section_id'),

                ]
            );

            DB::commit();
            return redirect()->route('sections.show', session('section_id'))->with('success', 'Successfully created');
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
        $student = Student::findOrFail($id);
        return view('hod.students.edit', compact('student'));
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
        $student = Student::find($id);
        $request->validate([
            'name' => 'required|string|max:100',
            'father' => 'required|string|max:100',
            'gender' => 'required|string|max:1',
        ]);

        try {

            // $student->name = $request->name;
            // $student->father = $request->father;
            // $student->gender = $request->gender;

            $student->update($request->all());


            return redirect()->route('sections.show', $student->section)->with('success', 'Successfully updated');;
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
        $student = Student::findOrFail($id);
        try {
            $student->delete();
            return redirect()->back()->with('success', 'Successfully deleted');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['deletion' => $e->getMessage()]);
            // something went wrong
        }
    }
}
