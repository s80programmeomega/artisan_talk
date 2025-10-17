<?php

namespace App\Livewire\Chat;

use Livewire\Component;
use App\Models\Contact;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;
use App\Models\Chat;

class ChatHeader extends Component
{
    public ?Contact $contact = null;
    public ?int $chatId = null;

    // public function mount(?Contact $contact = null): void
    // {
    //     $this->contact = $contact;
    // }


    #[On('chatSelected')]
    public function updateHeader(int $chatId): void
    {
        $this->chatId = $chatId;

        $chat = Chat::with('contacts')->find($chatId);
        $this->contact = $chat?->contacts
            ->where('user_id', '!=', Auth::id())
            ->first();
    }

    public function render()
    {
        return view('livewire.chat.chat-header');
    }
}
