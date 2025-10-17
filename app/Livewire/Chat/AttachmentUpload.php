<?php

namespace App\Livewire\Chat;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Attachment;
use App\Models\Message;

class AttachmentUpload extends Component
{
    use WithFileUploads;

    public $file;
    public int $messageId;

    public function mount(int $messageId): void
    {
        $this->messageId = $messageId;
    }

    public function uploadFile(): void
    {
        $this->validate(['file' => 'required|file|max:10240']); // 10MB max

        $path = $this->file->store('attachments', 'public');

        Attachment::create([
            'message_id' => $this->messageId,
            'file_name' => $this->file->getClientOriginalName(),
            'file_path' => $path,
            'file_size' => $this->file->getSize(),
            'mime_type' => $this->file->getMimeType(),
        ]);

        $this->dispatch('attachmentUploaded');
        $this->file = null;
    }

    public function render()
    {
        return view('livewire.chat.attachment-upload');
    }
}
