<?php

namespace Database\Seeders;

use App\Models\Prefix;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PrefixSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Prefix::create(['name' => 'Dr',]);
        Prefix::create(['name' => 'Mr',]);
        Prefix::create(['name' => 'Mrs',]);
        Prefix::create(['name' => 'Miss',]);
        Prefix::create(['name' => 'Mam',]);
    }
}
