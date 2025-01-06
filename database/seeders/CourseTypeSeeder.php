<?php

namespace Database\Seeders;

use App\Models\CourseType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        CourseType::create(['name' => 'Compulsory']);
        CourseType::create(['name' => 'Elective']);
        CourseType::create(['name' => 'Special Paper']);
        CourseType::create(['name' => 'Thesis']);
    }
}
