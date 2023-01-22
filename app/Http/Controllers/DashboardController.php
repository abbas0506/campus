<?php

namespace App\Http\Controllers;

use App\Models\Clas;
use App\Models\Department;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;


class DashboardController extends Controller
{
    //
    public function admin()
    {
        // create empty collections
        $labels = collect();
        $programs = collect();
        $courses = collect();
        $teachers = collect();
        $clases = collect();
        $sections = collect();
        $students = collect();

        $departments = Department::all();
        foreach ($departments as $department) {
            $labels->add($department->name);
            $programs->add($department->programs->count());
            $courses->add($department->courses->count());
            $teachers->add($department->teachers()->count());
            $clases->add($department->clases()->count());
            $sections->add($department->sections()->count());
            $students->add($department->students()->count());
        }
        return view('admin.index', compact('labels', 'programs', 'courses', 'teachers', 'clases', 'sections', 'students'));
    }

    public function hod()
    {
        $department = Department::find(session('department_id'));

        $labels = collect(['Programs', 'Courses', 'Teachers', 'Classes', 'Sections', 'Students']);

        $data = collect();
        $data->add($department->programs->count());
        $data->add($department->courses->count());
        $data->add($department->teachers()->count());
        $data->add($department->clases()->count());
        $data->add($department->sections()->count());
        $data->add($department->students()->count());

        return view('hod.index', compact('labels', 'data'));
    }
}
