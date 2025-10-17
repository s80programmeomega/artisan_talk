<?php

namespace App\Livewire\Chat;

use App\Models\Chat;
use App\Models\Contact;
use Livewire\Component;
use Livewire\Attributes\Layout;

/**
 * Main chat page component that orchestrates the entire chat interface
 * This component manages the overall state and coordinates between child components
 */

#[Layout('layouts.chat')]
class ChatPage extends Component
{
    // Current active chat ID
    public ?int $activeChatId = null;

    // Current active contact for chat header
    public ?Contact $activeContact = null;

    /**
     * Set the active chat and load contact information
     * This method is called when user selects a chat from the sidebar
     */
    public function setActiveChat(int $chatId): void
    {
        $this->activeChatId = $chatId;

        // Load the contact for this chat
        $chat = Chat::with('contacts')->find($chatId);
        $this->activeContact = $chat?->contacts->first();

        // Dispatch event to refresh chat window
        $this->dispatch('chatSelected', chatId: $chatId);
    }

    public function render()
    {
        // dd("This is the chat page");
        return view('livewire.chat.chat-page');
    }
}
