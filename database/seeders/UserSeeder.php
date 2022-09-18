<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@uo.edu.pk',
            'password' => Hash::make('password'),
            'role' => 'superadmin',
        ]);
        User::create([
            'name' => 'Dr Sajjad',
            'email' => 'controller@uo.edu.pk',
            'password' => Hash::make('password'),
            'role' => 'controller',
        ]);
    }
}
