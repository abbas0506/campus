<?php

namespace Database\Seeders;

use App\Models\UserDepartment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserDepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        UserDepartment::create([
            'user_id' => 1,
            'department_id' => 4, //admin
        ]);
        UserDepartment::create([
            'user_id' => 2,
            'department_id' => 4, //admin
        ]);
    }
}
