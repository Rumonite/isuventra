<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    public function definition(): array
    {
        // Generate a random date between 2020 and 2025
        $date = $this->faker->dateTimeBetween('2020-01-01', '2025-12-31');

        // Extract the year from that date for the title
        $year = $date->format('Y');

        return [
            'title' => $this->faker->randomElement([
                'Intramurals',
                'Student\'s Week',
                'Acquaintance Party',
                'Roadshow',
            ]) . ' ' . $year,

            'description' => $this->faker->paragraphs(3, true),

            'location' => $this->faker->randomElement([
                'De Venecia Hall',
                'Open Gym',
                'Amphitheater',
                'Grandstand',
                $this->faker->city() . ' Convention Center',
            ]),

            // Use the generated date as the actual event date
            'date' => $date,
        ];
    }
}
