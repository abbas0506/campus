<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Department::create(['name' => 'Management']);
        Department::create(['name' => 'Examination Branch']);
        Department::create(['name' => 'Accounts']);
        Department::create(['name' => 'Department of Entamology', 'title' => 'Department of Zoology']);
        Department::create(['name' => 'Department of Biochemistry', 'title' => 'Department of Biology']);
        Department::create(['name' => 'Department of Bio-Technology', 'title' => 'Department of Biology']);
        Department::create(['name' => 'Department of Analytyical Chemistry', 'title' => 'Department of Chemistry']);
        Department::create(['name' => 'Department of Organic Chemistry', 'title' => 'Department of Chemistry']);
        Department::create(['name' => 'Department of Inorganic Chemistry', 'title' => 'Department of Chemistry']);
    }
}
