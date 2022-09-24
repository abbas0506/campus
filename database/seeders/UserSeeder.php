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
        $user1 = User::create([
            'name' => 'Vice Chancellor',
            'email' => 'admin@uo.edu.pk',
            'password' => Hash::make('password'),

        ]);
        $user1->assignRole('admin');

        $user2 = User::create([
            'name' => 'Dr Sajjad',
            'email' => 'controller@uo.edu.pk',
            'password' => Hash::make('password'),

        ]);
        $user2->assignRole('controller');

        $user3 = User::create([
            'name' => 'Head',
            'email' => 'hod@uo.edu.pk',
            'password' => Hash::make('password'),

        ]);
        $user3->assignRole('hod');
    }
}
