<?php

namespace Database\Seeders;

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
        $user = User::create([
            'name' => 'Vice Chancellor',
            'email' => 'admin@uo.edu.pk',
            'password' => Hash::make('password'),

        ]);
        $user->assignRole('admin');

        $user = User::create([
            'name' => 'Head',
            'email' => 'hod@uo.edu.pk',
            'password' => Hash::make('password'),

        ]);
        $user->assignRole('hod');
        $user->assignRole('examiner');

        $user = User::create([
            'name' => 'Dr Sajjad',
            'email' => 'controller@uo.edu.pk',
            'password' => Hash::make('password'),

        ]);
        $user->assignRole('controller');
    }
}
