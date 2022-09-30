<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Section::create(['name' => 'A']);
        Section::create(['name' => 'B']);
        Section::create(['name' => 'C']);
        Section::create(['name' => 'D']);
        Section::create(['name' => 'E']);
        Section::create(['name' => 'F']);
        Section::create(['name' => 'G']);
        Section::create(['name' => 'H']);
    }
}
