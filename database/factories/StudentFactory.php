<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'student_id' => $this->faker->unique()->numerify('2025-####'), // e.g. 2025-1234
            'name'       => $this->faker->name(),
            'course'     => $this->faker->randomElement(['BSIT', 'BSCS', 'BSA', 'BSEd']),
            'year_level' => $this->faker->numberBetween(1, 4),
            'campus'     => $this->faker->randomElement(['Main', 'North', 'East', 'West']),
        ];
    }
}
