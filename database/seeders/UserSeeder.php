<?php

namespace Database\Seeders;

use App\Models\Hod;
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
            'name' => 'Dr Sajjad Sarwar',
            'email' => 'sajjad@uo.edu.pk',
            'password' => Hash::make('password'),
            'department_id' => 1,

        ]);
        $user->assignRole('teacher', 'admin', 'controller');

        $user = User::create([
            'name' => 'Prof. Rashid Hussain',
            'email' => 'hod1@uo.edu.pk',
            'password' => Hash::make('password'),
            'department_id' => 1,

        ]);
        $user->assignRole(['teacher']);

        $user = User::create([
            'name' => 'Prof. Nasir Mehmood',
            'email' => 'hod2@uo.edu.pk',
            'password' => Hash::make('password'),
            'department_id' => 1,

        ]);

        $user->assignRole(['teacher']);


        $user = User::create([
            'name' => 'Mr. Ahmad Ali',
            'email' => 'teacher1@uo.edu.pk',
            'password' => Hash::make('password'),
            'department_id' => 1,

        ]);
        $user->assignRole('teacher');

        $user = User::create([
            'name' => 'Prof. Muhammad Ahmad',
            'email' => 'teacher2@uo.edu.pk',
            'password' => Hash::make('password'),
            'department_id' => 1,

        ]);
        $user->assignRole('teacher');

        $user = User::create([
            'name' => 'Mr. Muhammad Ejaz',
            'email' => 'teacher3@uo.edu.pk',
            'password' => Hash::make('password'),
            'department_id' => 1,

        ]);
        $user->assignRole('teacher');

        $user = User::create([
            'name' => 'Assistant Prof. Muhammad Luqman',
            'email' => 'teacher4@uo.edu.pk',
            'password' => Hash::make('password'),
            'department_id' => 1,

        ]);
        $user->assignRole('teacher');

        $user = User::create([
            'name' => 'Prof. Shabbir Hussain',
            'email' => 'teacher5@uo.edu.pk',
            'password' => Hash::make('password'),
            'department_id' => 2,

        ]);
        $user->assignRole('teacher');

        $user = User::create([
            'name' => 'Prof. Nazir Hussain',
            'email' => 'teacher6@uo.edu.pk',
            'password' => Hash::make('password'),
            'department_id' => 2,

        ]);
        $user->assignRole('teacher');
    }
}
