<?php

namespace Database\Seeders;

use App\Models\Teacher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class teacherSeeder extends Seeder
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
            'department_id' => 4,
            'cnic' => '35301-1232183-0'

        ]);
        Teacher::create([
            'user_id' => 2,
            'department_id' => 1,
            'cnic' => '35301-1232183-1'
        ]);
        Teacher::create([
            'user_id' => 3,
            'department_id' => 2,
            'cnic' => '36301-1232183-1'
        ]);
    }
}
