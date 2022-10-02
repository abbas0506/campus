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
        Role::create(['name' => 'superadmin']);
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'controller']);
        Role::create(['name' => 'kpo']);
        Role::create(['name' => 'hod']);
        Role::create(['name' => 'examiner']);
        Role::create(['name' => 'internal']);
        Role::create(['name' => 'student']);
    }
}
