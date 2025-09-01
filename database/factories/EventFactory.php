<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title'       => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'location'    => $this->faker->city(),
            'date'  => $this->faker->dateTimeBetween('-1 month', '+6 months'),
        ];
    }
}
