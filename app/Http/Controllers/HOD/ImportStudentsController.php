<?php

namespace App\Http\Controllers\hod;

use App\Http\Controllers\Controller;
use App\Imports\ImportStudent;
use App\Models\Section;
use Maatwebsite\Excel\Facades\Excel;
use Exception;
use Illuminate\Http\Request;

class ImportStudentsController extends Controller
{
    //
    public function view($id)

    {
        $section = Section::find($id);
        return view('hod.students.import', compact('section'));
    }
    public function import(Request $request)
    {
        try {
            Excel::import(
                new ImportStudent,
                $request->file('file')

            );

            return redirect()->route('sections.show', session('section_id'))->with('success', 'Student imported successfully');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
