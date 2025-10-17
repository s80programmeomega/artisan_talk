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

    // #[On('scrollToMessage')]
    // public function scrollToMessage(int $messageId): void
    // {
    //     $this->js("
    //         setTimeout(() => {
    //             const element = document.getElementById('message-{$messageId}');
    //             console.log('Looking for message-{$messageId}:', element);
    //             if (element) {
    //                 element.scrollIntoView({ behavior: 'smooth', block: 'center' });
    //                 element.style.backgroundColor = '#fef08a';
    //                 element.style.transition = 'background-color 0.3s';
    //                 setTimeout(() => {
    //                     element.style.backgroundColor = '';
    //                 }, 2000);
    //             } else {
    //                 console.log('Message element not found: message-{$messageId}');
    //             }
    //         }, 500);
    //     ");
    // }


    #[On('scrollToMessage')]
    public function scrollToMessage(int $messageId): void
    {
        $this->js("
            setTimeout(() => {
                const element = document.getElementById('message-{$messageId}');
                if (element) {
                    element.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    element.classList.add('bg-yellow-200');
                    setTimeout(() => element.classList.remove('bg-yellow-200'), 2000);
                }
            }, 100);
        ");
    }


    // #[On('scrollToMessage')]
    // public function scrollToMessage(int $messageId): void
    // {
    //     $this->js("
    //         setTimeout(() => {
    //             const element = document.getElementById('message-{$messageId}');
    //             if (element) {
    //                 element.scrollIntoView({ behavior: 'smooth', block: 'center' });
    //                 element.classList.add('bg-yellow-200');
    //                 setTimeout(() => element.classList.remove('bg-yellow-200'), 2000);
    //             }
    //         }, 100);
    //     ");
    // }


    public function render()
    {
        return view('livewire.chat.chat-window');
    }
}
