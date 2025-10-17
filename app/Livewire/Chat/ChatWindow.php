<?php

namespace App\Livewire\Chat;

use App\Models\Chat;
use App\Models\Message;
use Livewire\Attributes\On;
use Livewire\Component;

class ChatWindow extends Component
{
    public ?int $chatId = null;
    public $messages = [];

    public function mount(?int $chatId = null): void
    {
        $this->chatId = $chatId;
        $this->loadMessages();
    }

    #[On('chatSelected')]
    public function updateChat(int $chatId): void
    {
        $this->chatId = $chatId;
        $this->loadMessages();
        $this->dispatch('scrollToBottom');
    }

    public function loadMessages(): void
    {
        if (!$this->chatId)
            return;

        $this->messages = Message::where('conversation_type', Chat::class)
            ->where('conversation_id', $this->chatId)
            ->with(['sender'])
            ->orderBy('created_at', 'asc')
            ->get();
    }

    #[On('messageAdded')]
    public function refreshMessages(): void
    {
        $this->loadMessages();
        $this->dispatch('scrollToBottom');
    }

    public function render()
    {
        return view('livewire.chat.chat-window');
    }
}
