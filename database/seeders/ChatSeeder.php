<?php

namespace Database\Seeders;

use App\Models\Chat;
use App\Models\Contact;
use Illuminate\Database\Seeder;

class ChatSeeder extends Seeder
{
    public function run(): void
    {
        $contacts = Contact::all();

        // Create chats with exactly 2 contacts each
        for ($i = 0; $i < $contacts->count() - 1; $i += 2) {
            if (isset($contacts[$i + 1])) {
                $chat = Chat::factory()->create();

                $chat->contacts()->attach([
                    $contacts[$i]->id,
                    $contacts[$i + 1]->id
                ]);
            }
        }
    }
}
