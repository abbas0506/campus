<?php

namespace Database\Seeders;

use App\Models\Designation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DesginationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Designation::create(['name' => 'Lecturer',]);
        Designation::create(['name' => 'Assistant Professor',]);
        Designation::create(['name' => 'Associate Professor',]);
        Designation::create(['name' => 'Professor',]);
    }
}
