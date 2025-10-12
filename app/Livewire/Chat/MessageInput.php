<?php

namespace App\Livewire\Chat;

use Livewire\Component;
use App\Models\Chat;
use App\Models\Message;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;

/**
 * Message Input Component - Handles message composition and sending
 * Manages the textarea and send functionality
 */
class MessageInput extends Component
{
    public int $chatId;
    public string $messageContent = '';

    public function mount(int $chatId): void
    {
        $this->chatId = $chatId;
    }

    /**
     * Send a new message
     */
    public function sendMessage(): void
    {
        // Validate message content
        $this->validate([
            'messageContent' => 'required|string|max:1000',
        ]);

        // Get current user's contact record for this chat
        $chat = Chat::with('contacts')->find($this->chatId);
        $currentUserContact = $chat->contacts()
            ->where('user_id', Auth::id())
            ->first();

        if (!$currentUserContact) {
            // Handle case where contact doesn't exist
            session()->flash('error', 'Unable to send message. Contact not found.');
            return;
        }

        // Create the message
        Message::create([
            'content' => $this->messageContent,
            'conversation_type' => Chat::class,
            'conversation_id' => $this->chatId,
            'sendable_type' => Contact::class,
            'sendable_id' => $currentUserContact->id,
        ]);

        // Update chat's last message timestamp
        $chat->update(['last_message_at' => now()]);

        // Clear the input
        $this->messageContent = '';

        // Dispatch events to refresh components
        $this->dispatch('messageAdded');
        $this->dispatch('scrollToBottom');
    }

    /**
     * Handle Enter key press to send message
     */
    public function handleKeydown($key): void
    {
        if ($key === 'Enter' && !empty(trim($this->messageContent))) {
            $this->sendMessage();
        }
    }

    public function render()
    {
        return view('livewire.chat.message-input');
    }
}