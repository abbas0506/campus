<?php

namespace Database\Seeders;

use App\Models\ExamType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExamTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        ExamType::create(['name' => 'Formative Assessment']);
        ExamType::create(['name' => 'Summative Assessment']);
    }
}
