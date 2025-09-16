<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title'       => $this->faker->randomElement([
                'Tech Conference',
                'Sports Meet',
                'Cultural Festival',
                'Hackathon',
                'Leadership Seminar',
                'Orientation Program',
                'Music Concert',
                'Science Fair',
            ]) . ' ' . $this->faker->year(),

            'description' => $this->faker->paragraphs(3, true),

            'location'    => $this->faker->randomElement([
                'Main Auditorium',
                'Campus Gymnasium',
                'Tech Park Hall',
                'Student Center',
                'Virtual (Zoom)',
                $this->faker->city() . ' Convention Center',
            ]),

            'date'        => $this->faker->dateTimeBetween('-1 month', '+6 months'),
        ];
    }
}
