<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@email.com',
        ]);

        User::factory(9)->create();

        $this->call([
            ContactSeeder::class,
            GroupSeeder::class,
            ChatSeeder::class,
            MessageSeeder::class,
            AttachmentSeeder::class,
        ]);
    }
}
