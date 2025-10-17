<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        if ($users->count() < 2) {
            $users = User::factory(10)->create();
        }

        foreach ($users as $user) {
            $otherUsers = $users->where('id', '!=', $user->id)->random(rand(3, 5));

            foreach ($otherUsers as $contactUser) {
                Contact::factory()->create([
                    'user_id' => $user->id,
                    'contact_user_id' => $contactUser->id,
                    'name' => $contactUser->name,
                    'email' => $contactUser->email,
                ]);
            }
        }
    }
}
