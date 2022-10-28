<?php

namespace Database\Seeders;

use App\Models\Teacher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Teacher::create([
            'user_id' => 1,
            'department_id' => 2,
            'cnic' => '35301-1232183-0'

        ]);
        Teacher::create([
            'user_id' => 2,
            'department_id' => 2,
            'cnic' => '35301-1232183-1'
        ]);
        Teacher::create([
            'user_id' => 3,
            'department_id' => 1,
            'cnic' => '35301-1232183-2'
        ]);

        Teacher::create([
            'user_id' => 4,
            'department_id' => 2,
            'cnic' => '35301-1232183-3'
        ]);

        Teacher::create([
            'user_id' => 5,
            'department_id' => 1,
            'cnic' => '35301-1232183-4'
        ]);
        Teacher::create([
            'user_id' => 6,
            'department_id' => 1,
            'cnic' => '35301-1232183-5'
        ]);
        Teacher::create([
            'user_id' => 7,
            'department_id' => 1,
            'cnic' => '35301-1232183-6'
        ]);
        Teacher::create([
            'user_id' => 8,
            'department_id' => 2,
            'cnic' => '35301-1232183-7'
        ]);
        Teacher::create([
            'user_id' => 9,
            'department_id' => 2,
            'cnic' => '35301-1232183-8'
        ]);
        Teacher::create([
            'user_id' => 10,
            'department_id' => 2,
            'cnic' => '35301-1232183-9'
        ]);
    }
}
