<?php

namespace Database\Factories;

use App\Models\Chat;
use App\Models\Contact;
use App\Models\Group;
use App\Models\GroupMember;
use Illuminate\Database\Eloquent\Factories\Factory;

class MessageFactory extends Factory
{
    public function definition(): array
    {
        return [
            'content' => fake()->sentence(),
            'read_at' => fake()->optional()->dateTimeBetween('-1 week', 'now'),
        ];
    }

    public function forChat()
    {
        return $this->state(function (array $attributes) {
            $chat = Chat::factory()->create();
            $contact = $chat->contacts()->first() ?? Contact::factory()->create();

            return [
                'conversation_id' => $chat->id,
                'conversation_type' => Chat::class,
                'sendable_id' => $contact->id,
                'sendable_type' => Contact::class,
            ];
        });
    }

    public function forGroup()
    {
        return $this->state(function (array $attributes) {
            $groupMember = GroupMember::factory()->create();

            return [
                'conversation_id' => $groupMember->group_id,
                'conversation_type' => Group::class,
                'sendable_id' => $groupMember->id,
                'sendable_type' => GroupMember::class,
            ];
        });
    }
}