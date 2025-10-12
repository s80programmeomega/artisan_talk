<?php

namespace Database\Factories;

use App\Models\Message;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttachmentFactory extends Factory
{
    public function definition(): array
    {
        $type = fake()->randomElement(['document', 'photo', 'video']);
        $extensions = [
            'document' => ['pdf', 'doc', 'docx', 'txt'],
            'photo' => ['jpg', 'jpeg', 'png', 'gif'],
            'video' => ['mp4', 'avi', 'mov', 'wmv'],
        ];

        $extension = fake()->randomElement($extensions[$type]);
        $filename = fake()->word() . '.' . $extension;

        return [
            'message_id' => Message::factory(),
            'type' => $type,
            'filename' => $filename,
            'path' => 'attachments/' . $filename,
            'mime_type' => $this->getMimeType($type, $extension),
            'size' => fake()->numberBetween(1024, 10485760), // 1KB to 10MB
        ];
    }

    private function getMimeType(string $type, string $extension): string
    {
        $mimeTypes = [
            'document' => [
                'pdf' => 'application/pdf',
                'doc' => 'application/msword',
                'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'txt' => 'text/plain',
            ],
            'photo' => [
                'jpg' => 'image/jpeg',
                'jpeg' => 'image/jpeg',
                'png' => 'image/png',
                'gif' => 'image/gif',
            ],
            'video' => [
                'mp4' => 'video/mp4',
                'avi' => 'video/x-msvideo',
                'mov' => 'video/quicktime',
                'wmv' => 'video/x-ms-wmv',
            ],
        ];

        return $mimeTypes[$type][$extension] ?? 'application/octet-stream';
    }
}
