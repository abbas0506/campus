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
            'name' => 'Admin',
            'email' => 'admin@uo.edu.pk',
            'password' => Hash::make('password'),
            // 'department_id' => 1,

        ]);
        $user->assignRole('admin', 'controller');
    }
}
