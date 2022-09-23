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
            'credit_hrs' => 4,
            'max_marks' => 100,
        ]);
        Course::create([
            'name' => 'Fundamentals of Botany',
            'short' => 'Botany',
            'code' => 'B345',
            'credit_hrs' => 4,
            'max_marks' => 100,
        ]);
    }
}
