<?php

namespace Database\Seeders;

use App\Models\Jobtype;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobtypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Jobtype::create(['name' => 'Regular',]);
        Jobtype::create(['name' => 'Contract',]);
        Jobtype::create(['name' => 'Daily Wages',]);
    }
}
