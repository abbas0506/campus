<?php

namespace Database\Seeders;

use App\Models\Province;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Province::create(['name' => 'Punjab',]);
        Province::create(['name' => 'Sindh',]);
        Province::create(['name' => 'Balochistan',]);
        Province::create(['name' => 'KPK',]);
        Province::create(['name' => 'Gilgit Baltistan',]);
    }
}
