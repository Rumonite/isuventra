<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Student;
use App\Models\Event;

class ParticipationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'student_id' => Student::inRandomOrder()->first()->id ?? Student::factory(),
            'event_id'   => Event::inRandomOrder()->first()->id ?? Event::factory(),
            'status'     => $this->faker->randomElement(['registered', 'attended', 'missed']),
        ];
    }
}
