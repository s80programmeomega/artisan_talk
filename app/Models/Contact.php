<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'contact_user_id',
        'name',
        'email',
        'phone',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function contactUser()
    {
        return $this->belongsTo(User::class, 'contact_user_id');
    }

    public function chats()
    {
        return $this->belongsToMany(Chat::class, 'chat_contacts');
    }

    public function groupMembers()
    {
        return $this->hasMany(GroupMember::class);
    }

    public function chatMessages()
    {
        return $this->hasMany(Message::class);
    }
}