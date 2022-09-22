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
        Department::create(['name' => 'Department of Zoology']);
        Department::create(['name' => 'Department of Botany']);
        Department::create(['name' => 'Department of Chemistry']);
        Department::create(['name' => 'Department of English']);
    }
}
