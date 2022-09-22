<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'controller']); //controller examination
        Role::create(['name' => 'kpo']);
        Role::create(['name' => 'hod']);
        Role::create(['name' => 'internal']); //internal examiner
        Role::create(['name' => 'instructor']);
        Role::create(['name' => 'student']);
    }
}
