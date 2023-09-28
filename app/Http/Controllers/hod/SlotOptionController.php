<?php

namespace App\Http\Controllers\hod;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Slot;
use App\Models\SlotOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class SlotOptionController extends Controller
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
            'slot_id' => 'required|numeric',
            'course_type_id' => 'required',
        ]);

        $slot = Slot::find($request->slot_id);

        $course_type_ids = array();
        $course_type_ids = $request->course_type_id;

        DB::beginTransaction();
        try {

            // foreach ($course_type_ids as $course_type_id) {
            SlotOption::create([
                'slot_id' => $request->slot_id,
                'course_type_id' => $request->course_type_id,
            ]);
            // }

            DB::commit();
            return redirect()->route('slots.edit', $slot)->with('success', 'Successfully added');
        } catch (Exception $ex) {
            DB::rollBack();
            return redirect()->back()->withErrors($ex->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SlotOption  $slotOption
     * @return \Illuminate\Http\Response
     */
    public function show(SlotOption $slotOption)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SlotOption  $slotOption
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $slot_option = SlotOption::find($id);
        if ($slot_option->course_id == '') {
            $courses = Course::where('course_type_id', $slot_option->course_type_id)
                ->where('department_id', session('department_id'))->get();
        } else {
            $courses = Course::where('course_type_id', $slot_option->course_type_id)
                ->where('id', '<>', $slot_option->course_id)
                ->where('department_id', session('department_id'))->get();
        }
        return view('hod.schemes.slot_options.edit', compact('slot_option', 'courses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SlotOption  $slotOption
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $slot_option = SlotOption::find($id);

        try {
            $slot_option->update($request->all());
            return redirect()->route('slots.edit', $slot_option->slot)->with('success', 'Successfully updated');
        } catch (Exception $ex) {
            return redirect()->back()->withErrors($ex->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SlotOption  $slotOption
     * @return \Illuminate\Http\Response
     */
    public function destroy(SlotOption $slotOption)
    {
        //
        try {
            $slotOption->delete();
            return redirect()->back()->with('success', 'Successfully deleted');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['deletion' => $e->getMessage()]);
            // something went wrong
        }
    }
}
