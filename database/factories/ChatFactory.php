<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ChatFactory extends Factory
{
    public function definition(): array
    {
        return [
            'last_message_at' => fake()->dateTimeBetween('-1 month', 'now'),
        ];
    }
}