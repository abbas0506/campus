<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Employee::create([
            'user_id' => 1,
            'department_id' => 4,
            'cnic' => '35301-1232183-0'

        ]);
        Employee::create([
            'user_id' => 2,
            'department_id' => 4,
            'cnic' => '35301-1232183-1'
        ]);
        Employee::create([
            'user_id' => 3,
            'department_id' => 5,
            'cnic' => '36301-1232183-1'
        ]);
    }
}
