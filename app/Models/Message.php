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
        'sender_id',
        'sender_type',
        'read_at',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'read_at' => 'datetime',
            'status' => 'string'
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

    public function readByUsers()
    {
        return $this->belongsToMany(User::class, 'message_user_read')
                    ->withPivot('read_at')
                    ->withTimestamps();
    }

    public function isReadBy(User $user)
    {
        return $this->readByUsers()->where('user_id', $user->id)->exists();
    }

    // Mark message as read
    public function markAsRead(Message $message, User $user)
    {
        $message->readByUsers()->syncWithoutDetaching([
            $user->id => ['read_at' => now()]
        ]);
    }

}
