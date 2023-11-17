<?php

namespace App\Http\Controllers\hod;

use App\Http\Controllers\Controller;
use App\Models\Clas;
use App\Models\CourseType;
use App\Models\Department;
use Illuminate\Http\Request;
use Exception;
use App\Models\Program;
use App\Models\Scheme;
use App\Models\Semester;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Svg\Tag\Rect;

class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $department = Department::find(session('department_id'));
        $programs = $department->programs;
        return view('hod.programs.index', compact('programs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $durations = [1, 1.5, 2, 2.5, 3, 3.5, 4, 4.5, 5, 5.5, 6, 6.5, 7, 7.5, 8];
        return view('hod.programs.create', compact('durations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //append id of hod's current department
        $request->merge(['department_id' => session('department_id')]);
        $request->validate([
            // 'name' => 'required|unique:programs',
            'name' => 'required',
            'short' => 'required',
            'level' => 'required',
            'cr' => 'required|numeric',
            'min_t' => 'required|numeric',
            'max_t' => 'required|numeric',
            'intake' => 'required|numeric',
            'department_id' => 'required|numeric',

        ]);

        try {
            $exists = Program::where('name', $request->name)
                ->where('department_id', $request->department_id)
                ->first();
            if ($exists) {
                return redirect()->back()->with('warning', 'Program ' . $exists->name . ' already exists!');
            } else {
                Program::create($request->all());
                return redirect()->route('hod.programs.index')->with('success', 'Successfully created');
            }
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['create' => $e->getMessage()]);
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
        $program = Program::findOrFail($id);
        return view('hod.programs.show', compact('program'));
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
        $program = Program::findOrFail($id);
        $durations = [1, 1.5, 2, 2.5, 3, 3.5, 4, 4.5, 5, 5.5, 6, 6.5, 7, 7.5, 8];
        return view('hod.programs.edit', compact('program', 'durations'));
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
        $request->merge(['department_id' => session('department_id')]);
        $request->validate([
            // 'name' => 'required|unique:programs,name,' . $id, 'id',
            'name' => 'required',
            'short' => 'required',
            'level' => 'required',
            'cr' => 'required|numeric',
            'min_t' => 'required|numeric',
            'max_t' => 'required|numeric',
            'intake' => 'required|numeric',
        ]);

        DB::beginTransaction();
        try {
            $exists = Program::where('name', $request->name)
                ->where('id', '<>', $id)
                ->where('department_id', $request->department_id)
                ->first();
            if ($exists) {
                return redirect()->back()->with('warning', 'Program ' . $exists->name . ' already exists!');
            } else {
                $program = Program::findOrFail($id);
                $program->update($request->all());

                //update all the related classes last-semester-id

                $programs = Program::all();
                foreach ($programs as $program) {
                    foreach ($program->clases as $clas) {
                        $clas->last_semester_id = $clas->first_semester_id + intval($program->min_t * 2) - 1;
                        $clas->update();
                    }
                }
                DB::commit();
                return redirect()->route('hod.programs.index')->with('success', 'Successfully updated');
            }
        } catch (Exception $ex) {
            DB::rollBack();
            return redirect()->back()->withErrors($ex->getMessage());
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
        $program = Program::findOrFail($id);
        try {
            $program->delete();
            return redirect()->back()->with('success', 'Successfully deleted!');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }
    public function scheme($id)
    {
        $program = Program::find($id);
        $semesters = Semester::active()->get();
        return view('hod.programs.schemes.add', compact('semesters', 'program',));
    }

    public function addScheme(Request $request)
    {
        $request->validate([
            'wef_semester_id' => 'required|numeric',
            'program_id' => 'required|numeric|unique:schemes,program_id,NULL,id,wef_semester_id,' . $request->wef_semester_id,
        ]);

        try {
            Scheme::create($request->all());
            return redirect()->route('hod.programs.show', $request->program_id)->with('success', 'Successfully created');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }

    public function internal($id)
    {
        $program = Program::find($id);
        $teachers = User::whereRelation('roles', 'name', 'teacher')
            ->where('id', '<>', $program->internal_id)->get();
        return view('hod.programs.internal', compact('program', 'teachers'));
    }
    public function updateInternal(Request $request, $id)
    {
        $request->validate([
            'internal_id' => 'required|numeric',
        ]);
        $user = User::find($request->internal_id);
        DB::beginTransaction();
        try {
            $program = Program::findOrFail($id);
            //update existing internal status
            //if he performs somewhere else as internal, keep him as internal
            if ($program->internal) {
                if ($program->internal->intern_programs->count() == 1)
                    $program->internal->removeRole('internal');
            }

            // replace by recently selected internal id
            $program->internal_id = $request->internal_id;
            $program->update();

            if (!$user->hasRole('internal')) {
                $user->assignRole('internal');
            }
            DB::commit();
            return redirect()->route('hod.programs.index')->with('success', 'Successfully updated');;
        } catch (Exception $ex) {
            DB::rollBack();
            return redirect()->back()->withErrors($ex->getMessage());
        }
    }

    public function coordinator($id)
    {
        $program = Program::find($id);
        $teachers = User::whereRelation('roles', 'name', 'teacher')
            ->where('id', '<>', $program->coordinator_id)->get();
        return view('hod.programs.coordinator', compact('program', 'teachers'));
    }
    public function updateCoordinator(Request $request, $id)
    {
        $request->validate([
            'coordinator_id' => 'required|numeric',
        ]);
        $user = User::find($request->coordinator_id);
        DB::beginTransaction();
        try {
            $program = Program::findOrFail($id);
            //update existing internal status
            //if he performs somewhere else as internal, keep him as internal
            if ($program->coordinator) {
                if ($program->coordinator->coordinated_programs->count() == 1)
                    $program->coordinator->removeRole('coordinator');
            }

            // replace by recently selected internal id
            $program->coordinator_id = $request->coordinator_id;
            $program->update();

            if (!$user->hasRole('coordinator')) {
                $user->assignRole('coordinator');
            }
            DB::commit();
            return redirect()->route('hod.programs.index')->with('success', 'Successfully updated');;
        } catch (Exception $ex) {
            DB::rollBack();
            return redirect()->back()->withErrors($ex->getMessage());
        }
    }
}
