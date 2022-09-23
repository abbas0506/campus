<?php

namespace Database\Seeders;

use App\Models\District;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        District::create(['name' => 'Okara']);
        District::create(['name' => 'Sahiwal']);
        District::create(['name' => 'Pakpattan']);
        District::create(['name' => 'Lahore']);
        District::create(['name' => 'Multan']);
        District::create(['name' => 'Burewala']);
        District::create(['name' => 'Faisalabad']);
        District::create(['name' => 'Islamabad']);
        District::create(['name' => 'Rawalpindi']);
        District::create(['name' => 'Taxilla']);
        District::create(['name' => 'Peshawar']);
        District::create(['name' => 'Abottabad']);
        District::create(['name' => 'Hyederabad']);
        District::create(['name' => 'Karachi']);
        District::create(['name' => 'Gilgit']);
    }
}
