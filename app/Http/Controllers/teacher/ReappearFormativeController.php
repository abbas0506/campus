<?php

namespace App\Http\Controllers\teacher;

use App\Http\Controllers\Controller;
use App\Models\Reappear;
use Exception;
use Illuminate\Http\Request;

class ReappearFormativeController extends Controller
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
            'id' => 'required',
            'assignment' => 'required',
            'presentation' => 'required',
            'midterm' => 'required',
        ]);

        $ids = $request->id;
        $assignment = $request->assignment;
        $presentation = $request->presentation;
        $midterm = $request->midterm;
        try {
            foreach ($ids as $key => $id) {

                $first_attempt = Reappear::find($id);
                $first_attempt->assignment = $assignment[$key];
                $first_attempt->presentation = $presentation[$key];
                $first_attempt->midterm = $midterm[$key];

                $first_attempt->update();
            }
            return redirect()->back()->with('success', "Successfully added");
        } catch (Exception $ex) {
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
    }
}
