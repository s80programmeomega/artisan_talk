<?php

namespace Database\Factories;

use App\Models\Contact;
use App\Models\Group;
use Illuminate\Database\Eloquent\Factories\Factory;

class GroupMemberFactory extends Factory
{
    public function definition(): array
    {
        return [
            'group_id' => Group::factory(),
            'contact_id' => Contact::factory(),
            'role' => fake()->randomElement(['admin', 'member', 'guest']),
            'joined_at' => fake()->dateTimeBetween('-1 year', 'now'),
        ];
    }
}