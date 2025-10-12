<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\Contact;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    public function run(): void
    {
        Group::factory(5)->create()->each(function ($group) {
            $contacts = Contact::inRandomOrder()->limit(rand(3, 8))->get();

            foreach ($contacts as $index => $contact) {
                $group->members()->create([
                    'contact_id' => $contact->id,
                    'role' => $index === 0 ? 'admin' : fake()->randomElement(['member', 'guest']),
                ]);
            }
        });
    }
}
