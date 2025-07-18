<div x-data="chat" x-cloak
    class="@if(!$isEmbedded) flex items-center justify-center min-h-screen bg-gray-100 p-5 @endif" @if($isEmbedded)
    @endif>

    @if($isEmbedded)
    <!-- Floating Chat Button -->
    <div x-show="!chatOpen" class="fixed bottom-6 right-6 z-50 cursor-pointer" x-on:click="chatOpen = true">
        <div class="w-16 h-16 rounded-full shadow-lg flex items-center justify-center text-white text-2xl transition-all hover:scale-110 hover:shadow-xl"
            style="background: {{ $chatbot->primary_color ?? '#FF6B9D' }};">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                <path
                    d="M20 2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h4l4 4 4-4h4c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-2 12H6v-2h12v2zm0-3H6V9h12v2zm0-3H6V6h12v2z" />
            </svg>
        </div>
    </div>
    @endif

    <div class="@if(!$isEmbedded) w-96 @endif h-[600px] bg-white rounded-2xl shadow-xl overflow-hidden flex flex-col relative font-sans"
        @if($isEmbedded) x-show="chatOpen" x-transition.opacity.duration.300ms @endif>
        <!-- Header -->
        <div class="text-white p-4 px-5 flex items-center justify-between"
            style="background: linear-gradient(135deg, {{ $chatbot->primary_color ?? '#FF6B9D' }}, {{ $chatbot->primary_color ?? '#FF6B9D' }}dd);">
            <div class="flex items-center gap-2 font-semibold">
                <div class="w-6 h-6 bg-white rounded-full flex items-center justify-center text-xs">✨</div>
                {{ $chatbot->headline ?? 'Virtual Assistant' }}
            </div>
            <div class="bg-white/20 px-3 py-2 rounded-xl text-xs ml-auto">
                ID: {{ $chatbotId }}
            </div>
            @if(!$isEmbedded)
            <button class="bg-transparent border-none text-white text-xl cursor-pointer p-1 leading-none ml-2"
                onclick="window.history.back()">×</button>
            @else
            <button
                class="bg-transparent border-none text-white text-xl cursor-pointer p-1 leading-none ml-2 hover:bg-white/20 rounded"
                x-on:click="chatOpen = false">×</button>
            @endif
        </div>

        <!-- Chat Body -->
        <div class="flex-1 p-5 flex flex-col gap-4 overflow-y-auto max-h-96" x-ref="chatContainer"
            wire:updated="scrollToBottom">
            @foreach($messages as $message)
            <div class="flex flex-col mb-3 max-w-[85%] {{ $message['sender'] === 'user' ? 'ml-auto' : '' }}">
                <div class="p-3.5 rounded-xl text-sm leading-relaxed break-words
                        {{ $message['sender'] === 'user' 
                            ? 'text-white ml-auto' 
                            : 'bg-gray-50 text-gray-800' }}" @if($message['sender']==='user' )
                    style="background: {{ $chatbot->primary_color ?? '#FF6B9D' }};" @endif>
                    {!! $message['text'] !!}
                </div>
                <div class="text-gray-400 text-xs text-right mt-2">{{ $message['timestamp'] }}</div>
            </div>
            @endforeach

            <div wire:loading wire:target="sendMessage" class="flex flex-col mb-3 max-w-[85%]  ml-auto">
                <div x-text="$wire.newMessage"
                    class="p-3.5 rounded-xl text-sm leading-relaxed break-words text-white ml-auto"
                    style="background: {{ $chatbot->primary_color ?? '#FF6B9D' }};">
                </div>
            </div>
            @if ($isThinking)
            <div class="flex flex-col mb-3 max-w-[85%]">
                <div class="p-3.5 rounded-xl text-sm leading-relaxed break-words bg-gray-50 text-gray-800">
                    bot thinking ...
                </div>
            </div>
            @endif

            <!-- Quick Actions (only show if minimal messages) -->
            @if(count($messages) <= 1) <div wire:loading.remove class="flex flex-col gap-2 mt-auto">
                @foreach ($questions as $question)
                <button
                    class="text-white border-none py-3 px-4 rounded-full cursor-pointer text-sm transition-all text-left hover:opacity-90 hover:-translate-y-0.5"
                    style="background: {{ $chatbot->primary_color ?? '#FF6B9D' }};" wire:click="
                    $set('newMessage','{{ $question }}');
                    $wire.sendMessage()">
                    {{ $question }}
                </button>
                @endforeach
        </div>
        @endif
    </div>

    <!-- Message Input -->
    <div class="border-t border-gray-100 p-5">
        <form @submit.prevent="sendMessage">
            <div class="flex gap-3 items-center">
                <input wire:model="newMessage" x-model="newMessage" type="text" placeholder="Type a message..."
                    class="flex-1 text-black! border border-gray-200 rounded-full py-3 px-5 text-sm outline-none focus:border-gray-300 focus:ring-0"
                    x-ref="messageInput" />
                <button type="submit"
                    class="w-12 h-12 text-white border-none rounded-full cursor-pointer flex items-center justify-center transition-all hover:opacity-90 hover:scale-105"
                    style="background: {{ $chatbot->primary_color ?? '#FF6B9D' }};">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z" />
                    </svg>
                </button>
            </div>
        </form>
    </div>
</div>
</div>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('chat', () => ({
            newMessage: '',
            chatOpen: <?php echo $isEmbedded ? 'true' : 'false'; ?>,
            init() {
                Livewire.on('messageSent', () => {
                    this.newMessage = '';
                    setTimeout(() => this.scrollToBottom(), 50);
                });
            },
            scrollToBottom() {
                this.$refs.chatContainer.scrollTo({
                    top: this.$refs.chatContainer.scrollHeight - this.$refs.chatContainer.clientHeight,
                    behavior: 'smooth'
                });
            },
            sendMessage() {
                if (this.newMessage.trim() === '') {
                    return;
                }
                this.newMessage = '';
                this.$wire.sendMessage();
                setTimeout(() => this.scrollToBottom(), 10);
            }
        }))
    })
</script>