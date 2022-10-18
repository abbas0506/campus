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
            'code' => 'P-01',
            'duration' => 2,
            'department_id' => 1,
        ]);

        Program::create([
            'name' => 'Bachelor of Science in Computer Science',
            'short' => 'BSCS',
            'code' => 'P-02',
            'duration' => 4,
            'department_id' => 1,
        ]);

        Program::create([
            'name' => 'Associate Degree Program in Computer Science',
            'short' => 'ADPCS',
            'code' => 'P-03',
            'duration' => 4,
            'department_id' => 1,
        ]);
    }
}
