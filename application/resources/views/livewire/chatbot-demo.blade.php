<div class="@if(!$isEmbedded) flex items-center justify-center min-h-screen bg-gray-100 p-5 @endif" @if($isEmbedded)
    x-data="{ chatOpen: true }" @endif>
    <div class="w-96 h-[600px] bg-white rounded-2xl shadow-xl overflow-hidden flex flex-col relative font-sans"
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
        <div class="flex-1 p-5 flex flex-col gap-4 overflow-y-auto max-h-96" id="chatContainer"
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

            <!-- Quick Actions (only show if minimal messages) -->
            @if(count($messages) <= 1) <div class="flex flex-col gap-2 mt-auto">
                <button
                    class="text-white border-none py-3 px-4 rounded-full cursor-pointer text-sm transition-all text-left hover:opacity-90 hover:-translate-y-0.5"
                    style="background: {{ $chatbot->primary_color ?? '#FF6B9D' }};"
                    wire:click="sendQuickAction('What can this assistant do?')">
                    What can this assistant do?
                </button>
                <button
                    class="text-white border-none py-3 px-4 rounded-full cursor-pointer text-sm transition-all text-left hover:opacity-90 hover:-translate-y-0.5"
                    style="background: {{ $chatbot->primary_color ?? '#FF6B9D' }};"
                    wire:click="sendQuickAction('Tell me about your widgets')">
                    Tell me about your widgets
                </button>
                <button
                    class="text-white border-none py-3 px-4 rounded-full cursor-pointer text-sm transition-all text-left hover:opacity-90 hover:-translate-y-0.5"
                    style="background: {{ $chatbot->primary_color ?? '#FF6B9D' }};"
                    wire:click="sendQuickAction('I have an issue with my widget')">
                    I have an issue with my widget
                </button>
                <button
                    class="text-white border-none py-3 px-4 rounded-full cursor-pointer text-sm transition-all text-left hover:opacity-90 hover:-translate-y-0.5"
                    style="background: {{ $chatbot->primary_color ?? '#FF6B9D' }};"
                    wire:click="sendQuickAction('I want to leave a review')">
                    I want to leave a review
                </button>
        </div>
        @endif
    </div>

    <!-- Message Input -->
    <div class="p-5 border-t border-gray-200 flex gap-3 items-center">
        <input type="text"
            class="flex-1 py-3 px-4 border border-gray-200 rounded-full text-sm outline-none transition-colors focus:border-pink-400"
            placeholder="Write your message..." wire:model="newMessage" wire:keydown.enter="sendMessage">
        <button
            class="text-white border-none w-10 h-10 rounded-full cursor-pointer flex items-center justify-center text-base transition-all hover:opacity-90 hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none"
            style="background: {{ $chatbot->primary_color ?? '#FF6B9D' }};" wire:click="sendMessage"
            wire:loading.attr="disabled">
            <span wire:loading.remove>▶</span>
            <span wire:loading>...</span>
        </button>
    </div>
</div>

@if($isEmbedded)
<!-- Floating chat button for embedded version -->
<button
    class="fixed bottom-8 right-8 w-16 h-16 rounded-full border-none text-white text-2xl cursor-pointer flex items-center justify-center z-50"
    style="background: {{ $chatbot->primary_color ?? '#FF6B9D' }}; box-shadow: 0 4px 20px rgba(255, 107, 157, 0.3);"
    x-show="!chatOpen" x-on:click="chatOpen = true" x-transition.opacity.duration.300ms>
    💬
    <div
        class="absolute -top-1 -right-1 bg-red-500 text-white w-5 h-5 rounded-full flex items-center justify-center text-xs font-bold">
        1</div>
</button>
@endif

<script>
    // Auto-scroll to bottom function
        function scrollToBottom() {
            const chatContainer = document.getElementById('chatContainer');
            if (chatContainer) {
                chatContainer.scrollTop = chatContainer.scrollHeight;
            }
        }

        // Scroll to bottom on page load
        document.addEventListener('DOMContentLoaded', function() {
            scrollToBottom();
        });

        // Listen for messageSent event from Livewire
        document.addEventListener('livewire:initialized', function() {
            Livewire.on('messageSent', function() {
                setTimeout(scrollToBottom, 150); // Delay for message rendering
            });
        });
</script>
</div>