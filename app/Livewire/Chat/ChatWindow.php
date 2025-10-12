<?php

namespace App\Livewire\Chat;

use Livewire\Component;
use App\Models\Chat;
use App\Models\Message;
use Livewire\Attributes\On;

/**
 * Chat Window Component - Displays messages for the active chat
 * Handles real-time message updates and scrolling
 */
class ChatWindow extends Component
{
    public int $chatId;
    public $messages;

    public function mount(int $chatId): void
    {
        $this->chatId = $chatId;
        $this->loadMessages();
    }

    /**
     * Load messages for the current chat
     */
    public function loadMessages(): void
    {
        $this->messages = Message::where('conversation_type', Chat::class)
            ->where('conversation_id', $this->chatId)
            ->with(['sender'])
            ->orderBy('created_at', 'asc')
            ->get();
    }

    /**
     * Listen for new messages and refresh the chat
     */
    #[On('messageAdded')]
    public function refreshMessages(): void
    {
        $this->loadMessages();

        // Dispatch event to scroll to bottom
        $this->dispatch('scrollToBottom');
    }

    /**
     * Listen for chat selection to reload messages
     */
    #[On('chatSelected')]
    public function handleChatSelected(int $chatId): void
    {
        if ($this->chatId === $chatId) {
            $this->loadMessages();
        }
    }

    public function render()
    {
        return view('livewire.chat.chat-window');
    }
}
