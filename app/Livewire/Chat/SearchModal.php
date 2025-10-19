<?php

namespace App\Livewire\Chat;

use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use  App\Models\Chat;
use Livewire\WithPagination;

class SearchModal extends Component
{

    use WithPagination;

    public bool $showModal = false;
    public string $searchQuery = '';
    // public $searchResults = [];

    // protected $paginationTheme = 'bootstrap';

    public function updatingSearchQuery()
    {
        $this->resetPage();
    }


    #[On('openSearch')]
    public function openModal(): void
    {
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->searchQuery = '';
        // $this->searchResults = [];
    }

    public function search()
    {
        if (strlen($this->searchQuery) < 3) {
            return new \Illuminate\Pagination\LengthAwarePaginator([], 0, 10);
        }

        // Get all chats where current user is involved
        $userChatIds = Chat::whereHas('contacts', function($query) {
            $query->where('contact_user_id', Auth::id())
                  ->orWhere('user_id', Auth::id());
        })->pluck('id');

        // Search messages in those chats
        return Message::where('content', 'like', '%' . $this->searchQuery . '%')
            // ->where('conversation_type', 'App\Models\Chat')
            ->whereIn('conversation_id', $userChatIds)
            ->with(['sender', 'conversation'])
            ->latest()
            ->get();
            // ->paginate(2, ['*'], 'page');
    }


    public function render()
    {
        return view('livewire.chat.search-modal', ['searchResults' => $this->search()]);
    }
}
