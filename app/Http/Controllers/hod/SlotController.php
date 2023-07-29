<?php

namespace App\Http\Controllers\hod;

use App\Http\Controllers\Controller;
use App\Models\CourseType;
use App\Models\Scheme;
use App\Models\Slot;
use App\Models\SlotOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;


class SlotController extends Controller
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
    public function create($scheme_id, $semester_no)
    {
        //
        $scheme = Scheme::find($scheme_id);
        $slot_no = Slot::where('scheme_id', $scheme_id)
            ->where('semester_no', $semester_no)
            ->max('slot_no');

        if ($slot_no)
            $slot_no++;
        else
            $slot_no = 1;   //default start

        $course_types = CourseType::all();

        return view('hod.schemes.slots.create', compact('scheme', 'semester_no', 'slot_no', 'course_types'));
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
            'scheme_id' => 'required|numeric',
            'semester_no' => 'required|numeric',
            'slot_no' => 'required|numeric',
            'course_type_id' => 'required',
            'cr' => 'required|numeric',
        ]);

        $course_type_ids = array();
        $course_type_ids = $request->course_type_id;

        DB::beginTransaction();
        try {

            $slot = Slot::create([
                'scheme_id' => $request->scheme_id,
                'semester_no' => $request->semester_no,
                'slot_no' => $request->slot_no,
                'cr' => $request->cr,
            ]);

            foreach ($course_type_ids as $course_type_id) {
                SlotOption::create([
                    'slot_id' => $slot->id,
                    'course_type_id' => $course_type_id,
                ]);
            }

            DB::commit();
            return redirect()->route('schemes.show', $request->scheme_id)->with('success', 'Successfully created');
        } catch (Exception $ex) {
            DB::rollBack();
            return redirect()->back()->withErrors($ex->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Slot  $slot
     * @return \Illuminate\Http\Response
     */
    public function show(Slot $slot)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Slot  $slot
     * @return \Illuminate\Http\Response
     */
    public function edit(Slot $slot)
    {
        //
        $course_type_ids = SlotOption::where('slot_id', $slot->id)->pluck('course_type_id')->toArray();

        $missing_course_types = CourseType::whereNotIn('id', $course_type_ids)->get();

        return view('hod.schemes.slots.edit', compact('slot', 'missing_course_types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Slot  $slot
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Slot $slot)
    {
        //
        $request->validate([
            'slot_no' => 'required|numeric',
        ]);
        DB::beginTransaction();

        try {

            $slot->update($request->all());

            DB::commit();
            return redirect()->back()->with('success', 'Successfully updated');
        } catch (Exception $ex) {
            DB::rollBack();
            return redirect()->back()->withErrors($ex->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Slot  $slot
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slot $slot)
    {
        //
        try {
            $slot->delete();
            return redirect()->back()->with('success', 'Successfully deleted');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['deletion' => $e->getMessage()]);
            // something went wrong
        }
    }
}
