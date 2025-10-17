<?php

namespace App\Livewire\Chat;

use App\Models\Chat;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

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
        $this->activeContact = $chat?->contacts
            ->where('user_id', '!=', Auth::id())
            ->first();
    }

    #[On('chatSelected')]
    public function handleSetActiveChat(int $chatId): void
    {
        $this->setActiveChat($chatId);
        $this->js('window.dispatchEvent(new CustomEvent("chat-selected"))');
    }


    public function openSearch(): void
    {
        $this->showSearchModal = true;
    }

    public function closeSearch(): void
    {
        $this->showSearchModal = false;
    }

    public function render()
    {
        return view('livewire.chat.chat-page');
    }
}


// namespace App\Livewire\Chat;

// use App\Models\Chat;
// use App\Models\Contact;
// use Illuminate\Support\Facades\Auth;
// use Livewire\Component;
// use Livewire\Attributes\Layout;
// use Livewire\Attributes\On;

// #[Layout('layouts.chat')]
// class ChatPage extends Component
// {
//     public ?int $activeChatId = null;
//     public ?Contact $activeContact = null;
//     public bool $showSearchModal = false;

//     /**
//      * Set the active chat and load contact information
//      */
//     public function setActiveChat(int $chatId): void
//     {
//         $this->activeChatId = $chatId;

//         $chat = Chat::with('contacts')->find($chatId);
//         // $this->activeContact = $chat?->contacts->first();
//         $this->activeContact = $chat?->contacts
//         ->where('user_id', '!=', Auth::id())
//         ->first();

//         // dd('The active contact is : '.$this->activeContact);

//         $this->dispatch('chatSelected', chatId: $chatId);
//     }

//     /**
//      * Listen for chat selection from chat list
//      */
//     #[On('chatSelected')]
//     public function handleChatSelected(int $chatId): void
//     {
//         $this->setActiveChat($chatId);
//     }

//     /**
//      * Open search modal
//      */
//     public function openSearch(): void
//     {
//         $this->showSearchModal = true;
//         $this->dispatch('openSearchModal');
//     }

//     /**
//      * Close search modal
//      */
//     #[On('closeSearchModal')]
//     public function closeSearch(): void
//     {
//         $this->showSearchModal = false;
//     }

//     /**
//      * Handle real-time message updates
//      */
//     #[On('messageReceived')]
//     public function handleMessageReceived(): void
//     {
//         // Refresh components when new message arrives
//         $this->dispatch('refreshChatList');
//         $this->dispatch('refreshMessages');
//     }

//     public function render()
//     {
//         return view('livewire.chat.chat-page');
//     }
// }
