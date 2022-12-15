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

        Department::create(['name' => 'Department of Computer Science', 'title' => 'Department of Computer Science']);
        Department::create(['name' => 'Department of Fisheries', 'title' => 'Department of Zoology']);
    }
}
