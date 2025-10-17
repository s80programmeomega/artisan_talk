<?php

namespace App\Livewire\Chat;

use Livewire\Component;
use App\Models\Message;

class SearchModal extends Component
{
    public bool $showModal = false;
    public string $searchQuery = '';
    public $searchResults = [];

    public function openModal(): void
    {
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->searchQuery = '';
        $this->searchResults = [];
    }

    public function search(): void
    {
        if (strlen($this->searchQuery) < 3) return;

        $this->searchResults = Message::where('content', 'like', '%' . $this->searchQuery . '%')
            ->with(['sender', 'conversation'])
            ->latest()
            ->limit(20)
            ->get();
    }

    public function render()
    {
        return view('livewire.chat.search-modal');
    }
}
