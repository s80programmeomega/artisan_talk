{{-- Main Container - Derived from template structure --}}
<div class="drawer lg:drawer-open h-full">
    {{-- Drawer Toggle for mobile --}}
    <input id="sidebar-toggle" type="checkbox" class="drawer-toggle" />

    {{-- Main Content Area --}}
    <div class="drawer-content flex flex-col h-full">
        {{-- Chat Header Component --}}
        @livewire('chat.chat-header', ['contact' => $activeContact])

        {{-- Chat Messages Area --}}
        @if($activeChatId)
            @livewire('chat.chat-window', ['chatId' => $activeChatId], key($activeChatId))
        @else
            {{-- Welcome screen when no chat is selected --}}
            <div class="flex-1 flex items-center justify-center bg-base-100">
                <div class="text-center">
                    <h2 class="text-2xl font-semibold mb-2">Welcome to Artisan Talk</h2>
                    <p class="text-base-content/70">Select a chat to start messaging</p>
                </div>
            </div>
        @endif

        {{-- Message Input Component --}}
        @if($activeChatId)
            @livewire('chat.message-input', ['chatId' => $activeChatId])
        @endif
    </div>

    {{-- Sidebar --}}
    <div class="drawer-side">
        <label for="sidebar-toggle" class="drawer-overlay"></label>
        <aside class="w-80 min-h-full bg-base-200 border-r border-base-300">
            {{-- Chat List Component --}}
            @livewire('chat.chat-list')
        </aside>
    </div>
</div>
