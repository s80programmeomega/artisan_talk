<div>
    @if($showModal)
    {{-- <div class="modal modal-open" x-data x-init="$el.focus()" @keydown.escape.window="$wire.closeModal()"
        tabindex="0"> --}}
        <div class="modal modal-open">
            <div class="modal-box" x-data="{ isDragging: false, startX: 0, startY: 0, offsetX: 0, offsetY: 0 }"
                x-init="$el.style.transform = 'translate(0px, 0px)'; $el.focus()"
                @mousedown="isDragging = true; startX = $event.clientX - offsetX; startY = $event.clientY - offsetY"
                @mousemove.window="if (isDragging) {
                     offsetX = $event.clientX - startX;
                     offsetY = $event.clientY - startY;
                     $el.style.transform = `translate(${offsetX}px, ${offsetY}px)`
                 }" @mouseup.window="isDragging = false" @keydown.escape.window="$wire.closeModal()" tabindex="0"
                style="cursor: move;">

                {{-- <div class="modal-box"> --}}
                    <h3 class="font-bold text-lg mb-4">Search Messages</h3>

                    <input type="text" class="input input-bordered w-full mb-4" placeholder="Search messages..."
                        wire:model.live="searchQuery" wire:keyup="search" wire:keydown.escape="closeModal"
                        @mousedown.stop
                        >

                    <div class="max-h-60 overflow-y-auto">
                        @forelse($searchResults as $result)
                        <div class="p-2 hover:bg-base-200 rounded cursor-pointer"
                            wire:click="$dispatch('goToMessage', {messageId: {{ $result->id }}, chatId: {{ $result->conversation_id }}})">
                            <p class="text-sm">{{ Str::limit($result->content, 50) }}</p>
                            <span class="text-xs text-base-content/70">
                                {{ $result->sender->name }} • {{ $result->created_at->format('M j, H:i') }}
                            </span>
                        </div>
                        @empty
                        @if(strlen($searchQuery) >= 3)
                        <p class="text-center text-base-content/70 py-4">No messages found</p>
                        @endif
                        @endforelse
                    </div>


                    <div class="modal-action">
                        <button class="btn" wire:click="closeModal">Close</button>
                    </div>
                </div>
            </div>
            @endif
        </div>
