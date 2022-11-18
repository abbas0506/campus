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

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $semester = Semester::find(session('semester_id'));

        $programs = Program::where('department_id', session('department_id'))
            ->whereHas(
                'sections',
                function ($q) {
                    $q->where('semester_id', session('semester_id'));
                }
            )->get();;
        // $program_ids = Section::where('semester_id', session('semester_id'))->distinct()->pluck('program_id')->toArray();

        // $programs = Program::whereIn('id', $program_ids)->get();
        $shifts = Shift::all();
        return view('hod.sections.index', compact('semester', 'programs', 'shifts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        if (session('semester_id')) {
            $semester = Semester::find(session('semester_id'));
            $programs = Program::where('department_id', session('department_id'))->get();
            $shifts = Shift::all();
            return view('hod.sections.create', compact('semester', 'programs', 'shifts'));
        } else {
            echo 'session or program variable not set... probably you have tried direct access to this page';
            //send to error page showing direct access
        }
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
            'program_id' => 'required|numeric',
            'shift_id' => 'required|numeric',
            'name' => 'required',
        ]);

        try {

            $sections = Section::where('name', $request->name)
                ->where('semester_id', session('semester_id'))
                ->where('program_id', $request->program_id)
                ->where('shift_id', $request->shift_id);

            if ($sections->count() > 0)   //session exists
                return redirect()->back()->with('error', 'Section already exists');
            else {
                Section::create([
                    'name' => $request->name,
                    'semester_id' => session('semester_id'),
                    'program_id' => $request->program_id,
                    'shift_id' => $request->shift_id,
                ]);
                return redirect('sections')->with('success', 'Successfully created');
            }
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
        session([
            'section_id' => $id,
        ]);
        $students = $section->students;
        return view('hod.sections.show', compact('section', 'students'));
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
    }

    public function append($program_id, $shift_id)
    {
        if (session('semester_id')) {
            $semester = Semester::find(session('semester_id'));
            return view('hod.sections.append', compact('semester', 'program_id', 'shift_id'));
        } else {
            echo 'session or program variable not set... probably you have tried direct access to this page';
            //send to error page showing direct access
        }
    }

    public function fetchSectionsByProgramId(Request $request)
    {
        $sections = Section::where('semester_id', session('semester_id'))
            ->where('program_id', $request->program_id)
            ->where('shift_id', $request->shift_id)->get();

        // $sections = Section::whereIn('clas_id', $clas_ids)->get();


        //prepare courses list
        $section_options = "";
        foreach ($sections as $section) {
            $section_options .= "<option value='" . $section->id . "'>" . $section->name . "</option>";
        }

        $program = Program::find($request->program_id);
        // $schemes = Scheme::where('program_id', $request->program_id)->get();
        $schemes = $program->schemes;
        $scheme_options = "";
        foreach ($schemes as $scheme) {
            $scheme_options .= "<option value='" . $scheme->id . "'>" . $scheme->semester->semester_type->name . " " . $scheme->semester->year . "</option>";
        }

        return response()->json([
            'section_options' => $section_options,
            'scheme_options' => $scheme_options,
        ]);
    }
}
