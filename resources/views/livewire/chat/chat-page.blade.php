{{-- Main Container --}}
<div class="drawer lg:drawer-open h-screen"
     x-data="{ showSearch: @entangle('showSearchModal') }"
     @chat-selected.window="if (window.innerWidth < 1024) { $refs.sidebarToggle.checked = false; }">
    <input id="sidebar-toggle" type="checkbox" class="drawer-toggle" x-ref="sidebarToggle" />

    {{-- Main Content Area --}}
    <div class="drawer-content flex flex-col h-screen">
        {{-- Chat Header with Search Integration --}}
        <div class="flex-shrink-0">
            @livewire('chat.chat-header', ['chatId' => $activeChatId, 'key' => 'chat-header-' . ($activeChatId ?? 0)])
        </div>

        {{-- Chat Messages Area --}}
        @if($activeChatId)
            {{-- Typing Indicator --}}
            <div class="flex-shrink-0">
                @livewire('chat.typing-indicator', ['key' => 'typing-indicator-' . ($activeChatId ?? 0)])
            </div>

            {{-- Chat Window - Scrollable Messages --}}
            <div class="flex-1 min-h-0">
                <livewire:chat.chat-window :chatId="$activeChatId" :key="'chat-window-static'" />
            </div>

            {{-- Message Input - Fixed at Bottom --}}
            <div class="flex-shrink-0">
                @livewire('chat.message-input', ['chatId' => $activeChatId, 'key' => 'message-input-' . ($activeChatId ?? 0)])
            </div>
        @else
            {{-- Welcome Screen --}}
            <div class="flex-1 flex items-center justify-center bg-base-100">
                <div class="text-center">
                    <div class="mb-4">
                        <svg class="w-24 h-24 mx-auto text-base-content/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                            </path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-semibold mb-2">Welcome to Artisan Talk</h2>
                    <p class="text-base-content/70">Select a chat to start messaging</p>
                </div>
            </div>
        @endif
    </div>

    {{-- Sidebar --}}
    <div class="drawer-side">
        <label for="sidebar-toggle" class="drawer-overlay"></label>
        <aside class="w-80 min-h-full bg-base-200 border-r border-base-300">
            @livewire('chat.chat-list')
        </aside>
    </div>

    {{-- Search Modal --}}
    @livewire('chat.search-modal')

    {{-- Real-time Echo Integration --}}
    @if($activeChatId)
        <script>
        document.addEventListener('livewire:initialized', () => {
            // Join chat channel for real-time updates
            window.Echo?.join('chat.{{ $activeChatId }}')
                .here((users) => {
                    console.log('Users in chat:', users);
                })
                .joining((user) => {
                    console.log('User joined:', user.name);
                })
                .leaving((user) => {
                    console.log('User left:', user.name);
                })
                .listen('MessageSent', (e) => {
                    @this.dispatch('messageReceived');
                })
                .listenForWhisper('typing', (e) => {
                    @this.dispatch('userTyping', { userName: e.user.name, isTyping: e.typing });
                });
        });
        </script>
    @endif
</div>
