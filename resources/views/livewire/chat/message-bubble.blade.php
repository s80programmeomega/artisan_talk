{{-- Message Bubble with different styles for sent/received --}}
<div class="mb-4 {{ $isSentByCurrentUser ? 'flex justify-end' : 'flex justify-start' }}">
    <div class="max-w-xs lg:max-w-md">
        {{-- Message Content --}}
        <div class="
            {{ $isSentByCurrentUser
                ? 'bg-primary text-primary-content rounded-l-lg rounded-tr-xl'
                : 'bg-base-200 text-base-content rounded-r-lg rounded-tl-xl'
            }}
            px-4 py-2 shadow-sm
        ">
            <p class="text-sm">{{ $message->content }}</p>
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
