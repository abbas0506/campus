<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\ExamType;
use App\Models\UserDepartment;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            RoleSeeder::class,
            GenderSeeder::class,
            ReligionSeeder::class,
            NationalitySeeder::class,
            DistrictSeeder::class,
            ProvinceSeeder::class,
            QualificationSeeder::class,
            SemesterTypeSeeder::class,
            ExamTypeSeeder::class,
            DepartmentSeeder::class,
            ProgramSeeder::class,
            CourseSeeder::class,
            FacultySeeder::class,
            JobtypeSeeder::class,


            UserSeeder::class,
            UserRoleSeeder::class,
            UserDepartmentSeeder::class,

        ]);
    }
}
