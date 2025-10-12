<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = ['last_message_at'];

    protected function casts(): array
    {
        return [
            'last_message_at' => 'datetime',
        ];
    }

    public function contacts()
    {
        return $this->belongsToMany(Contact::class, 'chat_contacts');
    }

    public function messages()
    {
        return $this->morphMany(Message::class, 'conversation');
    }

}