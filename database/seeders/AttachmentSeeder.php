<?php

namespace Database\Seeders;

use App\Models\Attachment;
use App\Models\Message;
use Illuminate\Database\Seeder;

class AttachmentSeeder extends Seeder
{
    public function run(): void
    {
        Message::inRandomOrder()->limit(20)->get()->each(function ($message) {
            if (rand(0, 1)) {
                Attachment::factory()->create([
                    'message_id' => $message->id,
                ]);
            }
        });
    }
}