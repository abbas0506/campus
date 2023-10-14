<?php

namespace App\Http\Controllers\hod;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Clas;
use App\Models\Program;
use App\Models\Scheme;
use App\Models\Section;
use App\Models\Semester;
use App\Models\Session;
use App\Models\Shift;
use Exception;
use Illuminate\Contracts\Session\Session as SessionSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Svg\Tag\Rect;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
            'clas_id' => 'required|numeric',
        ]);

        try {

            $letters = config('global.letters');
            $clas = Clas::find($request->clas_id);

            //if section exists, assign next letter
            if ($clas->lastSection()) {
                $last = $clas->lastSection()->name;
                $index = array_search($last, $letters);
                Section::create([
                    'name' => $letters[$index + 1],
                    'clas_id' => $request->clas_id,
                ]);
            } else {
                //else start naming from A
                Section::create([
                    'name' => $letters[0],
                    'clas_id' => $request->clas_id,
                ]);
            }

            return redirect()->route('hod.clases.index')->with(['shift_id' => $clas->shift_id, 'success' => 'Successfully created']);
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //

        $section = Section::find($id);
        // session([
        //     'section_id' => $id,
        // ]);
        $students = $section->students;
        return view('hod.clases.sections.show', compact('section', 'students'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function edit(Section $section)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Section $section)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(Section $section)
    {
        //
        $shift_id = $section->clas->shift_id;
        try {
            $section->delete();
            return redirect()->route('hod.clases.index')->with(['shift_id' => $shift_id, 'success' => 'Successfully removed']);
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    // public function append($program_id, $shift_id)
    // {
    //     if (session('semester_id')) {
    //         $semester = Semester::find(session('semester_id'));
    //         return view('hod.sections.append', compact('semester', 'program_id', 'shift_id'));
    //     } else {
    //         echo 'session or program variable not set... probably you have tried direct access to this page';
    //         //send to error page showing direct access
    //     }
    // }

    // public function fetchSectionsByClas(Request $request)
    // {
    //     $clas = Clas::find($request->clas_id);
    //     $sections = $clas->sections;


    //     //prepare courses list
    //     $section_options = "";
    //     foreach ($sections as $section) {
    //         $section_options .= "<option value='" . $section->id . "'>" . $section->name . "</option>";
    //     }

    //     return response()->json([
    //         'section_options' => $section_options,
    //     ]);
    // }
}
