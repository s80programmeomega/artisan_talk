<?php

namespace App\Livewire\Chat;

use Livewire\Component;
use App\Models\Contact;

class ChatHeader extends Component
{
    public ?Contact $contact = null;

    public function mount($contact = null): void
    {
        // Make sure we handle null values properly
        if ($contact instanceof Contact) {
            $this->contact = $contact;
        } else {
            $this->contact = null;
        }
    }

    public function render()
    {
        return view('livewire.chat.chat-header');
    }
}
