{{-- Message Bubble with different styles for sent/received --}}
@use('Illuminate\Support\Facades\Storage')

<div class="mb-4 {{ $isSentByCurrentUser ? 'flex justify-end' : 'flex justify-start' }}"
    id="message-{{ $message->id }}">
    <div class="max-w-xs lg:max-w-md">
        {{-- Message Content --}}
        <div class="
            {{ $isSentByCurrentUser
                ? 'bg-primary text-primary-content rounded-l-lg rounded-tr-xl'
                : 'bg-base-200 text-base-content rounded-r-lg rounded-tl-xl'
            }}
            px-4 py-2 shadow-sm
        ">

            {{-- Attachments --}}
            @foreach($message->attachments as $attachment)
            <div class="mt-2">
                @if($attachment->type === 'photo')
                <img src="{{ Storage::url($attachment->path) }}" alt="{{ $attachment->filename }}"
                    class="max-w-full rounded cursor-pointer"
                    onclick="window.open('{{ Storage::url($attachment->path) }}', '_blank')">
                @elseif($attachment->type === 'video')
                <video controls class="max-w-full rounded">
                    <source src="{{ Storage::url($attachment->path) }}" type="{{ $attachment->mime_type }}">
                </video>
                @else
                <a href="{{ Storage::url($attachment->path) }}" target="_blank"
                    class="flex items-center gap-2 p-2 bg-base-100/20 rounded">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm0 2h12v8H4V6z" />
                    </svg>
                    <span class="text-xs">{{ $attachment->filename }}</span>
                </a>
                @endif
            </div>
            @endforeach
            @if($message->content)
            <p class="text-sm py-4">{{ $message->content }}</p>
            @endif
        </div>

        {{-- Message Timestamp --}}
        <div class="mt-1 {{ $isSentByCurrentUser ? 'text-right' : 'text-left' }}">
            <span class="text-xs text-base-content/50">
                {{ $message->created_at->format('H:i') }}
            </span>

            {{-- Message Status for sent messages --}}
            @if($isSentByCurrentUser)
            <span class="text-xs text-base-content/50 ml-1">
                @switch($message->status ?? 'sent')
                @case('sent')
                <span title="Sent">✓</span>
                @break
                @case('delivered')
                <span title="Delivered">✓✓</span>
                @break
                @case('read')
                <span title="Read" class="text-primary">✓✓</span>
                @break
                @endswitch
            </span>
            @endif
        </div>
    </div>
</div>
