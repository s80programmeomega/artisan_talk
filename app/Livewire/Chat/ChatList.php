<?php

namespace App\Livewire\Chat;

use Livewire\Component;
use App\Models\Chat;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

/**
 * Chat List Component - Displays all user chats in the sidebar
 * Handles chat selection and search functionality
 */
class ChatList extends Component
{
    public string $search = '';

    /**
     * Listen for new messages to refresh the chat list
     * This ensures the list updates when new messages arrive
     */
    #[On('messageAdded')]
    public function refreshChatList(): void
    {
        // Component will re-render automatically
    }

    /**
     * Handle chat selection and notify parent component
     */
    public function selectChat(int $chatId): void
    {
        $this->dispatch('chatSelected', chatId: $chatId);
    }

    /**
     * Get filtered chats based on search query
     */
    public function getChatsProperty()
    {
        $userId = Auth::id();

        return Chat::with(['contacts', 'messages' => function($query) {
                $query->latest()->limit(1);
            }])
            ->whereHas('contacts', function($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->when($this->search, function($query) {
                $query->whereHas('contacts', function($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                });
            })
            // ->distinct()
            ->get()
            ->unique('id')
            ->map(function($chat) use ($userId) {
                $chat->unread_count = $chat->getUnreadCountForUser($userId);
                return $chat;
            })
            ->sortByDesc('last_message_at');
    }


    // public function getChatsProperty()
    // {
    //     return Chat::with(['contacts', 'messages' => function($query) {
    //             $query->latest()->limit(1);
    //         }])
    //         ->whereHas('contacts', function($query) {
    //             $query->where('user_id', Auth::id());
    //         })
    //         ->when($this->search, function($query) {
    //             $query->whereHas('contacts', function($q) {
    //                 $q->where('name', 'like', '%' . $this->search . '%');
    //             });
    //         })
    //         ->orderBy('last_message_at', 'desc')
    //         ->get();
    // }


    public function render()
    {
        return view('livewire.chat.chat-list');
    }
}
