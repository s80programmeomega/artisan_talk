{{-- Message Input Area - Derived from template --}}
<div class="bg-base-200 p-4 border-t border-base-300">
    <form wire:submit="sendMessage">
        <div class="flex gap-3 items-end">
            {{-- Attachment Button --}}
            {{-- <button type="button" class="btn btn-ghost btn-circle" title="Attach File">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13">
                    </path>
                </svg>
            </button> --}}

                <button
                    type="button"
                    class="btn btn-ghost btn-circle"
                    title="Attach File"
                    onclick="document.getElementById('file-input').click()"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13">
                        </path>
                    </svg>
                </button>

                <input
                    type="file"
                    id="file-input"
                    class="hidden"
                    wire:model="attachment"
                    accept="image/*,application/pdf,.doc,.docx"
                >



            {{-- Message Input --}}
            <div class="flex-1">
                <textarea
                    class="textarea textarea-bordered w-full resize-none"
                    rows="1"
                    placeholder="Type a message..."
                    wire:model="messageContent"
                    wire:keydown.enter="handleKeydown('Enter')"
                    x-data="{
                        autoResize() {
                            this.$el.style.height = 'auto';
                            this.$el.style.height = this.$el.scrollHeight + 'px';
                        }
                    }"
                    x-init="autoResize()"
                    @input="autoResize()"
                ></textarea>

                {{-- Validation Error --}}
                @error('messageContent')
                    <span class="text-error text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            {{-- Send Button --}}
            {{-- <button
                type="submit"
                class="btn btn-primary btn-circle"
                x-data="{ content: @entangle('messageContent') }"
                :disabled="!content || !content.trim()"
                title="Send Message"
            > --}}
            <button
                type="submit"
                class="btn btn-primary btn-circle"
                wire:loading.attr="disabled"
                title="Send Message"
            >

                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                </svg>
            </button>
        </div>
    </form>
</div>
