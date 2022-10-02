<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $this->call([
            RolesAndPermissionsSeeder::class, //spatie
            ReligionSeeder::class,
            NationalitySeeder::class,
            DomicileSeeder::class,
            ProvinceSeeder::class,
            QualificationSeeder::class,
            SemesterTypeSeeder::class,
            ExamTypeSeeder::class,
            CourseTypeSeeder::class,
            SessionSeeder::class,

            DepartmentSeeder::class,
            ProgramSeeder::class,
            SectionSeeder::class,
            CourseSeeder::class,
            FacultySeeder::class,
            DesginationSeeder::class,
            JobtypeSeeder::class,
            PrefixSeeder::class,

            UserSeeder::class,
            EmployeeSeeder::class,
            // StudentSeeder::class,

        ]);
    }
}
