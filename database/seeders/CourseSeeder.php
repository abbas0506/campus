<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Course::create([
            'name' => 'Fundamentals of Biology',
            'short' => 'Bio',
            'code' => 'B1234',
            'credit_hrs_theory' => 3,
            'max_marks_theory' => 100,
            'credit_hrs_practical' => 1,
            'max_marks_practical' => 100,
            'department_id' => 1,
        ]);
        Course::create([
            'name' => 'Fundamentals of Botany',
            'short' => 'Botany',
            'code' => 'B345',
            'credit_hrs_theory' => 4,
            'max_marks_theory' => 100,
            'credit_hrs_practical' => 0,
            'max_marks_practical' => 0,
            'department_id' => 1,
        ]);
    }
}
