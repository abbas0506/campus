<?php

namespace Database\Seeders;

use App\Models\Semester;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SemesterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Semester::create(['semester_type_id' => 2, 'year' => 2016]);
        Semester::create(['semester_type_id' => 1, 'year' => 2017]);
        Semester::create(['semester_type_id' => 2, 'year' => 2017]);

        Semester::create(['semester_type_id' => 1, 'year' => 2018]);
        Semester::create(['semester_type_id' => 2, 'year' => 2018]);

        Semester::create(['semester_type_id' => 1, 'year' => 2019]);
        Semester::create(['semester_type_id' => 2, 'year' => 2019]);

        Semester::create(['semester_type_id' => 1, 'year' => 2020]);
        Semester::create(['semester_type_id' => 2, 'year' => 2020]);

        Semester::create(['semester_type_id' => 1, 'year' => 2021]);
        Semester::create(['semester_type_id' => 2, 'year' => 2021]);

        Semester::create(['semester_type_id' => 1, 'year' => 2022]);
        Semester::create(['semester_type_id' => 2, 'year' => 2022, 'edit_till' => Carbon::parse('2022-10-20')]);

        Semester::create(['semester_type_id' => 1, 'year' => 2023]);
        Semester::create(['semester_type_id' => 2, 'year' => 2023]);

        Semester::create(['semester_type_id' => 1, 'year' => 2024]);
        Semester::create(['semester_type_id' => 2, 'year' => 2024]);

        Semester::create(['semester_type_id' => 1, 'year' => 2025]);
        Semester::create(['semester_type_id' => 2, 'year' => 2025]);

        Semester::create(['semester_type_id' => 1, 'year' => 2026]);
        Semester::create(['semester_type_id' => 2, 'year' => 2026]);

        Semester::create(['semester_type_id' => 1, 'year' => 2027]);
        Semester::create(['semester_type_id' => 2, 'year' => 2027]);

        Semester::create(['semester_type_id' => 1, 'year' => 2028]);
        Semester::create(['semester_type_id' => 2, 'year' => 2028]);

        Semester::create(['semester_type_id' => 1, 'year' => 2029]);
        Semester::create(['semester_type_id' => 2, 'year' => 2029]);

        Semester::create(['semester_type_id' => 1, 'year' => 2030]);
        Semester::create(['semester_type_id' => 2, 'year' => 2030]);
    }
}
