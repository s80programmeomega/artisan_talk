<?php

namespace App\Livewire\Chat;

use Livewire\Component;
use Livewire\Attributes\On;

class TypingIndicator extends Component
{
    public array $typingUsers = [];
    public ?int $chatId = null;

    #[On('chatSelected')]
    public function updateChatId(int $chatId): void
    {
        $this->chatId = $chatId;
        $this->typingUsers = []; // Clear typing users when switching chats
    }

    #[On('userTyping')]
    public function handleUserTyping(string $userName, bool $isTyping): void
    {
        if ($isTyping) {
            $this->typingUsers[$userName] = true;
        } else {
            unset($this->typingUsers[$userName]);
        }
    }

    public function render()
    {
        return view('livewire.chat.typing-indicator');
    }
}
