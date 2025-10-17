<div>
    @if(count($typingUsers) > 0)
        <div class="px-4 py-2 text-sm text-base-content/70 italic">
            {{ implode(', ', array_keys($typingUsers)) }}
            {{ count($typingUsers) === 1 ? 'is' : 'are' }} typing...
        </div>
    @endif
</div>
