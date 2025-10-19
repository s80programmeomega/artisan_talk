<div class="flex flex-col h-full">
    {{-- Header --}}
    <div class="p-4 border-b border-base-300">
        <div class="flex justify-end lg:hidden">
            <label for="sidebar-toggle" class="btn btn-ghost btn-circle btn-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </label>
        </div>

        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="avatar">
                    <div class="w-10 rounded-full">
                        <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}" alt="Profile" />
                    </div>
                </div>
                <h2 class="font-semibold">{{ auth()->user()->name }}</h2>
            </div>
            <div class="flex gap-2">
                <button class="btn btn-ghost btn-circle btn-sm" title="New Chat">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Search Bar --}}
    <div class="p-4">
        <div class="input input-bordered flex items-center gap-2">
            <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            <input
            type="search"
            class="grow text-black"
            placeholder="Search or start new chat"
            wire:model.live="search"
            />
        </div>
    </div>

    {{-- Chat List --}}
    <div class="overflow-y-auto flex-1">
        @forelse($this->chats as $chat)
            @php
                $chat_contacts = $chat->contacts;
                $contact = null;
                foreach($chat_contacts as $c) {
                    if($c->contact_user_id !== auth()->id()) {
                        $contact = $c;
                        break;
                    }
                }
                $lastMessage = $chat->messages->sortByDesc('created_at')->first();
            @endphp

            <div
                class="flex items-center justify-center gap-3 p-4 hover:bg-base-300 cursor-pointer border-base-300/50 mx-4 hover:rounded-xl hover:shadow-sm hover:shadow-white"
                wire:click="selectChat({{ $chat->id }})"
            >
                <div class="avatar">
                    <div class="w-12 rounded-full">
                        <img src="https://ui-avatars.com/api/?name={{ $contact->name ?? 'Unknown' }}" alt="{{ $contact->name ?? 'Unknown' }}" />
                    </div>
                </div>

                <div class="flex-1 min-w-0">
                    <div class="flex justify-between items-start">
                        <h3 class="font-semibold truncate">{{ $contact->name ?? 'Unknown Contact' }}</h3>
                        <div class="flex items-center gap-2">
                            @if($lastMessage)
                                <span class="text-xs text-base-content/70">
                                    {{ $lastMessage->created_at->format('H:i') }}
                                </span>
                            @endif
                            @if($chat->unread_count > 0)
                                <div class="badge badge-primary badge-sm">
                                    {{ $chat->unread_count > 99 ? '99+' : $chat->unread_count }}
                                </div>
                            @endif
                        </div>
                    </div>

                    @if($lastMessage)
                        <p class="text-sm text-base-content/70 truncate">
                            {{ Str::limit($lastMessage->content, 30) }}
                        </p>
                    @else
                        <p class="text-sm text-base-content/50 italic">No messages yet</p>
                    @endif
                </div>
            </div>

        @empty
            <div class="p-4 text-center text-base-content/70">
                <p>No chats found</p>
            </div>
        @endforelse
    </div>
</div>
