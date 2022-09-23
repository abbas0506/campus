<?php

namespace Database\Seeders;

use App\Models\Faculty;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Faculty::create([
            'name' => 'Teaching',
        ]);
        Faculty::create([
            'name' => 'Non Teaching',
        ]);
    }
}
