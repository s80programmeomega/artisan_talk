<?php

namespace App\Models;

use App\Models\Contact;
use App\Models\GroupMember;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public function getUnreadCountForUser($userId)
    {
        $user = User::find($userId);

        return $this
            ->messages
            ->reject(function ($message) use ($user) {
                return $message->isReadBy($user);
            })
            ->reject(function ($message) use ($userId) {
                $sender = $message->sender;
                if ($sender instanceof Contact) {
                    return $sender->user_id == $userId;
                }
                if ($sender instanceof GroupMember) {
                    return $sender->contact->user_id == $userId;
                }
                return true;
            })
            ->count();
    }

    // public function getUnreadCountForUser($userId)
    // {
    //     $unread_count = 0;
    //     $target_user = User::findOrFail($userId);
    //     foreach ($this->messages as $message) {
    //         if (!$message->isReadBy($target_user)) {
    //             // Check if the sender is not the user
    //             $sender = $message->sender;
    //             if ($sender instanceof Contact && $sender->user_id != $userId) {
    //                 $unread_count++;
    //             } elseif ($sender instanceof GroupMember) {
    //                 $contact = $sender->contact;
    //                 if ($contact && $contact->user_id != $userId) {
    //                     $unread_count++;
    //                 }
    //             }
    //         }
    //     }
    //     return $unread_count;
    // }
}
