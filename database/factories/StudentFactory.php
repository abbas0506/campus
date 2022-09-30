<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\Program;
use App\Models\SemesterType;
use App\Models\Session;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */


    public function definition()
    {
        return [
            // 'user_id' => $this->faker->unique()->numberBetween(1, 3),
            'user_id' => User::factory(),
            'cnic' => Str::random(10),
            'phone' => Str::random(10),
            'address' => $this->faker->city(),
            'semester_type_id' => SemesterType::all('id')->random(),
            'semester_no' => random_int(1, 4),
            'program_id' => Program::all('id')->random(),
            'session_id' => Session::all('id')->random()->id,
            'department_id' => Department::all('id')->random(),
        ];
    }
}
