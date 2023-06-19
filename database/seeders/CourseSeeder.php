<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Course::create([
            'name' => 'Fundamentals of Computer Science',
            'short' => 'Computer Science',
            'code' => 'C001',
            'credit_hrs_theory' => 3,
            'max_marks_theory' => 100,
            'credit_hrs_practical' => 1,
            'max_marks_practical' => 100,
            'department_id' => 1,
        ]);
        Course::create([
            'name' => 'Data Structures and Algoithms',
            'short' => 'DSA',
            'code' => 'C002',
            'credit_hrs_theory' => 4,
            'max_marks_theory' => 100,
            'credit_hrs_practical' => 0,
            'max_marks_practical' => 0,
            'department_id' => 1,
        ]);

        Course::create([
            'name' => 'Object Oriented and Programming',
            'short' => 'OOP',
            'code' => 'C003',
            'credit_hrs_theory' => 4,
            'max_marks_theory' => 100,
            'credit_hrs_practical' => 0,
            'max_marks_practical' => 0,
            'department_id' => 1,
        ]);

        Course::create([
            'name' => 'Database Systems',
            'short' => 'DBS',
            'code' => 'C004',
            'credit_hrs_theory' => 4,
            'max_marks_theory' => 100,
            'credit_hrs_practical' => 0,
            'max_marks_practical' => 0,
            'department_id' => 1,
        ]);
        Course::create([
            'name' => 'Distributed Database Systems',
            'short' => 'DDBS',
            'code' => 'C005',
            'credit_hrs_theory' => 4,
            'max_marks_theory' => 100,
            'credit_hrs_practical' => 0,
            'max_marks_practical' => 0,
            'department_id' => 1,
        ]);

        Course::create([
            'name' => 'Basics of Programming',
            'short' => 'C/C++',
            'code' => 'C006',
            'credit_hrs_theory' => 4,
            'max_marks_theory' => 100,
            'credit_hrs_practical' => 0,
            'max_marks_practical' => 0,
            'department_id' => 1,
        ]);
        Course::create([
            'name' => 'Computer Graphics',
            'short' => 'CFG',
            'code' => 'C007',
            'credit_hrs_theory' => 4,
            'max_marks_theory' => 100,
            'credit_hrs_practical' => 0,
            'max_marks_practical' => 0,
            'department_id' => 1,
        ]);
        Course::create([
            'name' => 'Computer Networks',
            'short' => 'Networking',
            'code' => 'C008',
            'credit_hrs_theory' => 4,
            'max_marks_theory' => 100,
            'credit_hrs_practical' => 0,
            'max_marks_practical' => 0,
            'department_id' => 1,
        ]);

        Course::create([
            'name' => 'Operating System',
            'short' => 'OS',
            'code' => 'C009',
            'credit_hrs_theory' => 4,
            'max_marks_theory' => 100,
            'credit_hrs_practical' => 0,
            'max_marks_practical' => 0,
            'department_id' => 1,
        ]);
        Course::create([
            'name' => 'Computer System Architecture',
            'short' => 'CSA',
            'code' => 'C010',
            'credit_hrs_theory' => 4,
            'max_marks_theory' => 100,
            'credit_hrs_practical' => 0,
            'max_marks_practical' => 0,
            'department_id' => 1,
        ]);

        Course::create([
            'name' => 'Elective I',
            'short' => 'E I',
            'code' => 'C011',
            'course_type_id' => 2,
            'credit_hrs_theory' => 3,
            'max_marks_theory' => 100,
            'credit_hrs_practical' => 0,
            'max_marks_practical' => 0,
            'department_id' => 1,
        ]);
        Course::create([
            'name' => 'Elective II',
            'short' => 'E II',
            'code' => 'C012',
            'course_type_id' => 2,
            'credit_hrs_theory' => 3,
            'max_marks_theory' => 100,
            'credit_hrs_practical' => 0,
            'max_marks_practical' => 0,
            'department_id' => 1,
        ]);

        Course::create([
            'name' => 'Special I',
            'short' => 'S I',
            'code' => 'C013',
            'course_type_id' => 3,
            'credit_hrs_theory' => 3,
            'max_marks_theory' => 100,
            'credit_hrs_practical' => 0,
            'max_marks_practical' => 0,
            'department_id' => 1,
        ]);

        Course::create([
            'name' => 'Special II',
            'short' => 'S I',
            'code' => 'C014',
            'course_type_id' => 3,
            'credit_hrs_theory' => 3,
            'max_marks_theory' => 100,
            'credit_hrs_practical' => 0,
            'max_marks_practical' => 0,
            'department_id' => 1,
        ]);

        Course::create([
            'name' => 'Thesis',
            'short' => 'Thesis',
            'code' => 'C015',
            'course_type_id' => 4,
            'credit_hrs_theory' => 6,
            'max_marks_theory' => 100,
            'credit_hrs_practical' => 0,
            'max_marks_practical' => 0,
            'department_id' => 1,
        ]);
    }
}
