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
        $dataset = Department::selectRaw('departments.name as name, ifnull(pro.count,0) as programsCount, ifnull(crs.count,0) as coursesCount')
            ->leftjoin(DB::raw('(select department_id, count(*) as count from courses group by department_id) AS crs'), 'crs.department_id', 'departments.id')
            ->leftjoin(DB::raw('(select department_id, count(*) as count from programs group by department_id) AS pro'), 'pro.department_id', 'departments.id')
            ->orderBy('departments.id', 'asc');

        //find teachers count by department
        $departments = Department::all()->sortBy('deparment_id');
        $teachersCount = collect();

        foreach ($departments as $department) {
            $teachersCount->add($department->teachers()->count());
        }

        $labels = $dataset->pluck('name');
        $programsCount = $dataset->pluck('programsCount');
        $coursesCount = $dataset->pluck('coursesCount');
        return view('admin.index', compact('labels', 'programsCount', 'coursesCount', 'teachersCount'));
    }

    public function hod()
    {
        $labels = collect();
        $data = collect();

        $department = Department::find(session('department_id'));

        $labels->add('Programs');
        $data->add($department->programs->count());

        $labels->add('Courses');
        $data->add($department->courses->count());

        $labels->add('Teachers');
        $data->add($department->teachers()->count());


        $labels->add('Classes');
        $data->add($department->clases()->count());

        $labels->add('Sections');
        $data->add($department->sections()->count());



        return view('hod.index', compact('labels', 'data'));
    }
}
