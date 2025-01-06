<?php

namespace Database\Seeders;

use App\Models\Program;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Program::create([
            'name' => 'Master of Science in Computer Science',
            'short' => 'MSCS',
            'cr' => 32,
            'min_t' => 2,
            'max_t' => 3,
            'department_id' => 1,
        ]);

        Program::create([
            'name' => 'Bachelor of Science in Computer Science',
            'short' => 'BSCS',
            'cr' => 32,
            'min_t' => 4,
            'max_t' => 5,
            'department_id' => 1,
        ]);

        Program::create([
            'name' => 'Associate Degree Program in Computer Science',
            'short' => 'ADPCS',
            'cr' => 32,
            'min_t' => 4,
            'max_t' => 5,
            'department_id' => 1,
        ]);
    }
}
