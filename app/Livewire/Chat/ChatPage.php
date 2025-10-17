<?php

namespace App\Livewire\Chat;

use App\Models\Chat;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('layouts.chat')]
class ChatPage extends Component
{
    public ?int $activeChatId = null;
    public ?Contact $activeContact = null;
    public bool $showSearchModal = false;

    public function setActiveChat(int $chatId): void
    {
        $this->activeChatId = $chatId;

        $chat = Chat::with('contacts')->find($chatId);
        $this->activeContact = $chat
            ?->contacts
            ->where('user_id', '!=', Auth::id())
            ->first();
    }

    #[On('chatSelected')]
    public function handleSetActiveChat(int $chatId): void
    {
        $this->setActiveChat($chatId);
        $this->js('window.dispatchEvent(new CustomEvent("chat-selected"))');
    }

    #[On('goToMessage')]
    public function goToMessage(int $messageId, int $chatId): void
    {
        $this->showSearchModal = false;

        // Skip render to prevent component destruction
        $this->skipRender();

        $this->setActiveChat($chatId);

        // Update chat list and header
        $this->dispatch(event: 'chatSelected', chatId: $chatId);

        // Scroll to message after components update
        $this->js("
            setTimeout(() => {
                \$wire.dispatch('scrollToMessage', {messageId: {$messageId}});
            }, 300);
        ");
    }


    // #[On('goToMessage')]
    // public function goToMessage(int $messageId, int $chatId): void
    // {
    //     $this->showSearchModal = false;
    //     $this->setActiveChat($chatId);

    //     $this->js("
    //         setTimeout(() => {
    //             \$wire.dispatch('scrollToMessage', {messageId: {$messageId}});
    //         }, 200);
    //     ");
    // }


    // #[On('goToMessage')]
    // public function goToMessage(int $messageId, int $chatId): void
    // {
    //     $this->showSearchModal = false;

    //     $this->js("
    //         setTimeout(() => {
    //             \$wire.setActiveChat({$chatId});
    //             \$wire.dispatch('scrollToMessage', {messageId: {$messageId}});
    //         }, 100);
    //     ");
    // }


    // #[On('goToMessage')]
    // public function goToMessage(int $messageId, int $chatId): void
    // {
    //     $this->setActiveChat($chatId);
    //     $this->showSearchModal = false; // Direct close instead of dispatch
    //     $this->dispatch('scrollToMessage', messageId: $messageId);
    // }


    public function render()
    {
        return view('livewire.chat.chat-page');
    }
}

