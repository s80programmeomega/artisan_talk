<?php

namespace App\Livewire\Chat;

use App\Events\MessageSent;
use App\Models\Attachment;
use App\Models\Chat;
use App\Models\Contact;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;

class MessageInput extends Component
{
    use WithFileUploads;

    public ?int $chatId = null;
    public string $messageContent = '';
    public $attachment;


    #[On('chatSelected')]
    public function updateChatId(int $chatId): void
    {
        $this->chatId = $chatId;
        $this->messageContent = '';
        $this->attachment = null;
    }

    private function getAttachmentType(string $mimeType): string
    {
        if (str_starts_with($mimeType, 'image/')) {
            return 'photo';
        }

        if (str_starts_with($mimeType, 'video/')) {
            return 'video';
        }

        return 'document';
    }

    public function sendMessage(): void
    {
        if (!$this->chatId) {
            session()->flash('error', 'Please select a chat first.');
            return;
        }

        $this->validate([
            'messageContent' => 'required_without:attachment|string|max:1000',
            'attachment' => 'nullable|file|max:10240', // 10MB max
        ]);

        $chat = Chat::with('contacts')->find($this->chatId);
        $currentUserContact = $chat
            ->contacts()
            ->where('user_id', Auth::id())
            ->first();

        if (!$currentUserContact) {
            session()->flash('error', 'Unable to send message. Contact not found.');
            return;
        }

        // Create the message
        $message = Message::create([
            'content' => $this->messageContent ?: '',
            'conversation_type' => Chat::class,
            'conversation_id' => $this->chatId,
            'sender_type' => Contact::class,  // Changed from 'sendable_type'
            'sender_id' => $currentUserContact->id,  // Changed from 'sendable_id'
        ]);

        // Handle attachment if present
        if ($this->attachment) {
            $path = $this->attachment->store('attachments', 'public');

            Attachment::create([
                'message_id' => $message->id,
                'type' => $this->getAttachmentType($this->attachment->getMimeType()),
                'filename' => $this->attachment->getClientOriginalName(),
                'path' => $path,
                'mime_type' => $this->attachment->getMimeType(),
                'size' => $this->attachment->getSize(),
            ]);
        }

        $chat->update(['last_message_at' => now()]);
        broadcast(new MessageSent($message));

        // Clear inputs
        $this->messageContent = '';
        $this->attachment = null;

        $this->dispatch('messageAdded');
        $this->dispatch('scrollToBottom');
    }

    public function handleKeydown($key): void
    {
        if ($key === 'Enter' && (!empty(trim($this->messageContent)) || $this->attachment)) {
            $this->sendMessage();
        }
    }

    public function startTyping(): void
    {
        $this->dispatch('userTyping', userName: Auth::user()->name, isTyping: true);
    }

    public function stopTyping(): void
    {
        $this->dispatch('userTyping', userName: Auth::user()->name, isTyping: false);
    }

    public function render()
    {
        return view('livewire.chat.message-input');
    }
}
