<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Auth;

class ContactFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'contact_user_id' => User::factory(),
            'name' => fake()->name(),
            'email' => fake()->email(),
            'phone' => fake()->phoneNumber(),
        ];
    }
}
