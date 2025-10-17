<div class="mb-2">
    {{-- Render your message bubble UI here, using $message --}}
    <div class="@if($message->sender_id === auth()->id()) text-right @else text-left @endif">
        <span class="inline-block px-3 py-2 rounded bg-base-200">
            {{ $message->body }}
        </span>
    </div>
</div>
