<?php

namespace Database\Seeders;

use App\Models\Chat;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Database\Seeder;

class ChatSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $processedPairs = [];

        foreach ($users as $user) {
            $userContacts = Contact::where('user_id', $user->id)->get();

            foreach ($userContacts->take(3) as $contact) {
                $otherUserContact = Contact::where('user_id', $contact->contact_user_id)
                    ->where('contact_user_id', $user->id)
                    ->first();

                if ($otherUserContact) {
                    // Create a unique key for this contact pair
                    $pairKey = collect([$contact->id, $otherUserContact->id])->sort()->implode('-');

                    // Skip if we've already processed this pair
                    if (in_array($pairKey, $processedPairs)) {
                        continue;
                    }

                    $chat = Chat::factory()->create();
                    $chat->contacts()->attach([$contact->id, $otherUserContact->id]);

                    $processedPairs[] = $pairKey;
                }
            }
        }
    }
}
