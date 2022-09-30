<?php

namespace Database\Seeders;

use App\Models\Session;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Session::create(['name' => 'Session 2022-24', 'start_year' => 2022, 'end_year' => 2024]);
        Session::create(['name' => 'Session 2022-26', 'start_year' => 2022, 'end_year' => 2026]);
    }
}
