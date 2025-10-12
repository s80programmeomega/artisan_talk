<?php

namespace App\Livewire\Chat;

use Livewire\Component;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

/**
 * Message Bubble Component - Displays individual messages
 * Handles different styles for sent/received messages
 */
class MessageBubble extends Component
{
    public Message $message;
    public bool $isSentByCurrentUser;

    public function mount(Message $message): void
    {
        $this->message = $message;

        // Determine if message was sent by current user
        // This is a simplified check - you may need to adjust based on your sender relationship
        $this->isSentByCurrentUser = $message->sender?->user_id === Auth::id();
    }

    public function render()
    {
        return view('livewire.chat.message-bubble');
    }
}
