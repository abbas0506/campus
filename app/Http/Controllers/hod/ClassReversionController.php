<?php

namespace App\Http\Controllers\hod;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Clas;
use App\Models\Department;
use Exception;
use Illuminate\Http\Request;

class ClassReversionController extends Controller
{
    //
    public function index()
    {
        $department = Department::find(session('department_id'));
        $programs = $department->programs;
        return view('hod.clases.revert', compact('programs'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'ids_array' => 'required',
        ]);

        $ids = array();
        $ids = $request->ids_array;
        $clases = Clas::whereIn('id', $ids)->orderBy('program_id')->orderByDesc('semester_no', 'desc')->get();
        DB::beginTransaction();
        try {

            foreach ($clases as $clas) {
                //promote to next semester
                $clas->semester_no = $clas->semester_no - 1;
                $clas->update();
            }

            DB::commit();
            return response()->json(['msg' => "Successfull"]);
        } catch (Exception $ex) {
            DB::rollBack();
            return response()->json(['msg' => $ex->getMessage()]);
        }
    }
}
