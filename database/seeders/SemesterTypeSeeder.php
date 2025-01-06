<?php

namespace Database\Seeders;

use App\Models\SemesterType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SemesterTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        SemesterType::create(['name' => 'Spring', 'short' => 'S']);
        SemesterType::create(['name' => 'Fall', 'short' => 'F']);
    }
}
