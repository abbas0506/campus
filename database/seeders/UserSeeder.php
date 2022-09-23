<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\UserRole;

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
            'name' => 'Vice Chancellor',
            'email' => 'admin@uo.edu.pk',
            'password' => Hash::make('password'),
            'cnic' => '35301-1234567-1',
        ]);


        User::create([
            'name' => 'Dr Sajjad',
            'email' => 'controller@uo.edu.pk',
            'password' => Hash::make('password'),
            'cnic' => '36402-1234567-2',
        ]);

        User::create([
            'name' => 'Head',
            'email' => 'hod@uo.edu.pk',
            'password' => Hash::make('password'),
            'cnic' => '36402-1234577-2',
        ]);
    }
}
