<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::factory(10)->create();

        foreach ($users as $user) {
            Contact::factory(rand(3, 8))->create([
                'user_id' => $user->id,
            ]);
        }
    }
}