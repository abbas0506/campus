<?php

namespace Database\Seeders;

use App\Models\Qualification;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QualificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Qualification::create(['name' => 'Inter',]);
        Qualification::create(['name' => 'Graduation',]);
        Qualification::create(['name' => 'Master',]);
        Qualification::create(['name' => 'MS/Mphil',]);
        Qualification::create(['name' => 'Ph.D',]);
    }
}
