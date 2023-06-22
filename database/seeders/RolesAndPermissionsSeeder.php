<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Role::create(['name' => 'super']);
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'controller']);
        Role::create(['name' => 'hod']);
        Role::create(['name' => 'teacher']);

        Role::create(['name' => 'internal']);
        Role::create(['name' => 'kpo']);
        Role::create(['name' => 'student']);
    }
}
