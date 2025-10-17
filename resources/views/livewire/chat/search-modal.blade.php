<div>
    @if($showModal)
        <div class="modal modal-open">
            <div class="modal-box">
                <h3 class="font-bold text-lg mb-4">Search Messages</h3>

                <input
                    type="text"
                    class="input input-bordered w-full mb-4"
                    placeholder="Search messages..."
                    wire:model.live="searchQuery"
                    wire:keyup="search"
                >

                <div class="max-h-60 overflow-y-auto">
                    @foreach($searchResults as $result)
                        <div class="p-2 hover:bg-base-200 rounded cursor-pointer">
                            <p class="text-sm">{{ Str::limit($result->content, 50) }}</p>
                            <span class="text-xs text-base-content/70">
                                {{ $result->created_at->format('M j, H:i') }}
                            </span>
                        </div>
                    @endforeach
                </div>

                <div class="modal-action">
                    <button class="btn" wire:click="closeModal">Close</button>
                </div>
            </div>
        </div>
    @endif
</div>
