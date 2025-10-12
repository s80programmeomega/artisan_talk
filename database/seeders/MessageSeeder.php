<?php

namespace Database\Seeders;

use App\Models\Chat;
use App\Models\Group;
use App\Models\Message;
use Illuminate\Database\Seeder;
use App\Models\Contact;
use App\Models\GroupMember;

class MessageSeeder extends Seeder
{
    public function run(): void
    {
        // Chat messages
        Chat::all()->each(function ($chat) {
            $contacts = $chat->contacts;

            foreach (range(1, rand(5, 20)) as $i) {
                $contact = $contacts->random();
                Message::factory()->create([
                    'conversation_id' => $chat->id,
                    'conversation_type' => Chat::class,
                    'sender_id' => $contact->id,
                    'sender_type' => Contact::class,
                ]);
            }
        });

        // Group messages
        Group::all()->each(function ($group) {
            foreach (range(1, rand(10, 30)) as $i) {
                $member = $group->members->random();
                Message::factory()->create([
                    'conversation_id' => $group->id,
                    'conversation_type' => Group::class,
                    'sender_id' => $member->id,
                    'sender_type' => GroupMember::class,
                ]);
            }
        });
    }
}
