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
        Semester::create([
            'semester_type_id' => 1,
            'year' => 2022,
            'edit_till' => Carbon::parse('2022-10-20')
        ]);
    }
}
