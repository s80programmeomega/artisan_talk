<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'conversation_id',
        'conversation_type',
        'sendable_id',
        'sendable_type',
        'read_at',
    ];

    protected function casts(): array
    {
        return [
            'read_at' => 'datetime',
        ];
    }


    public function conversation()
    {
        return $this->morphTo();
    }

    public function sender()
    {
        return $this->morphTo();  // Contact or GroupMember
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }
}