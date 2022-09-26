<?php

namespace Database\Seeders;

use App\Models\Domicile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DomicileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Domicile::create(['name' => 'Okara']);
        Domicile::create(['name' => 'Sahiwal']);
        Domicile::create(['name' => 'Pakpattan']);
        Domicile::create(['name' => 'Lahore']);
        Domicile::create(['name' => 'Multan']);
        Domicile::create(['name' => 'Burewala']);
        Domicile::create(['name' => 'Faisalabad']);
        Domicile::create(['name' => 'Islamabad']);
        Domicile::create(['name' => 'Rawalpindi']);
        Domicile::create(['name' => 'Taxilla']);
        Domicile::create(['name' => 'Peshawar']);
        Domicile::create(['name' => 'Abottabad']);
        Domicile::create(['name' => 'Hyederabad']);
        Domicile::create(['name' => 'Karachi']);
        Domicile::create(['name' => 'Gilgit']);
    }
}
