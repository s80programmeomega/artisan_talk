{{-- Chat Messages Area --}}
<div
    class="h-full overflow-y-auto bg-base-100 p-4"
    id="chat-messages"
    x-data="{
        scrollToBottom() {
            this.$el.scrollTop = this.$el.scrollHeight;
        }
    }"
    x-init="scrollToBottom()"
    @scroll-to-bottom.window="scrollToBottom()"
    @message-added.window="setTimeout(() => scrollToBottom(), 100)"
>
    @forelse($messages as $message)
        @livewire('chat.message-bubble', ['message' => $message], key($message->id))
    @empty
        <div class="flex items-center justify-center h-full">
            <div class="text-center text-base-content/50">
                <p>No messages yet. Start the conversation!</p>
            </div>
        </div>
    @endforelse
</div>

<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('scrollToBottom', () => {
            const chatMessages = document.getElementById('chat-messages');
            if (chatMessages) {
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }
            if (!window.Echo) {
                console.error('Echo not initialized');
                return;
            }
        });
    });
</script>
