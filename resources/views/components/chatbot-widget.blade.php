@php
    $messages = session()->get('chatbot_messages', []);
@endphp

<div id="chatbot-widget" class="fixed bottom-6 right-6 z-[9999] flex flex-col items-end">
    <!-- Chat Window -->
    <div id="chatWindow" class="hidden mb-4 w-[350px] sm:w-[400px] bg-white dark:bg-gray-800 rounded-2xl shadow-2xl overflow-hidden flex flex-col border border-gray-200 dark:border-gray-700 transition-all duration-300 ease-in-out transform scale-95 opacity-0 origin-bottom-right">
        <!-- Header -->
        <div class="bg-indigo-600 p-4 flex items-center justify-between text-white">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-sm">IT Helpdesk AI</h3>
                    <div class="flex items-center space-x-1">
                        <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                        <span class="text-[10px] text-indigo-100 uppercase tracking-wider font-semibold">Online</span>
                    </div>
                </div>
            </div>
            <div class="flex items-center space-x-1">
                <button onclick="clearChatWidget()" class="p-2 hover:bg-white/10 rounded-lg transition-colors" title="Hapus Chat">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </button>
                <button onclick="toggleChat()" class="p-2 hover:bg-white/10 rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Messages Area -->
        <div id="widgetMessagesContainer" class="h-[400px] overflow-y-auto p-4 bg-gray-50 dark:bg-gray-900 space-y-4">
            @if(empty($messages))
                <div class="flex flex-col items-center justify-center h-full text-center space-y-3 opacity-60">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    <p class="text-xs font-medium text-gray-500">Ada kendala IT? Tanyakan pada saya!</p>
                </div>
            @else
                @foreach($messages as $message)
                    @if($message['sender_type'] === 'user')
                        <div class="flex justify-end">
                            <div class="bg-indigo-600 text-white rounded-2xl rounded-tr-none px-4 py-2 max-w-[85%] shadow-sm">
                                <p class="text-sm leading-relaxed">{{ $message['message'] }}</p>
                                <span class="text-[10px] text-indigo-200 mt-1 block text-right">{{ $message['timestamp'] }}</span>
                            </div>
                        </div>
                    @else
                        <div class="flex justify-start">
                            <div class="bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100 rounded-2xl rounded-tl-none px-4 py-2 max-w-[85%] shadow-sm border border-gray-100 dark:border-gray-600">
                                <p class="text-sm leading-relaxed whitespace-pre-wrap">{!! nl2br(e($message['message'])) !!}</p>
                                <span class="text-[10px] text-gray-500 dark:text-gray-400 mt-1 block">{{ $message['timestamp'] }}</span>
                            </div>
                        </div>
                    @endif
                @endforeach
            @endif
        </div>



        <!-- Input -->
        <div class="p-4 bg-white dark:bg-gray-800 border-t border-gray-100 dark:border-gray-700">
            <form id="widgetMessageForm" class="flex items-center space-x-2">
                <input 
                    type="text" 
                    id="widgetMessageInput" 
                    class="flex-1 bg-gray-100 dark:bg-gray-700 border-none rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-indigo-500 dark:text-white" 
                    placeholder="Tanya sesuatu..."
                    autocomplete="off"
                >
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white p-2 rounded-xl transition-all active:scale-95 shadow-lg shadow-indigo-500/30">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5.951-2.976 5.951 2.976a1 1 0 001.169-1.409l-7-14z"/>
                    </svg>
                </button>
            </form>
        </div>
    </div>

    <!-- Toggle Button -->
    <button id="toggleChatBtn" onclick="toggleChat()" class="group bg-indigo-600 hover:bg-indigo-700 text-white p-4 rounded-full shadow-2xl transition-all duration-300 active:scale-90 flex items-center justify-center relative overflow-hidden">
        <span class="absolute inset-0 bg-white/20 opacity-0 group-hover:opacity-100 transition-opacity"></span>
        <svg id="chatIcon" class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
        </svg>
        <svg id="closeIcon" class="hidden w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>
</div>

<style>
    .chat-window-active {
        display: flex !important;
        transform: scale(1) !important;
        opacity: 1 !important;
    }
    #widgetMessagesContainer::-webkit-scrollbar {
        width: 4px;
    }
    #widgetMessagesContainer::-webkit-scrollbar-thumb {
        background: #e2e8f0;
        border-radius: 10px;
    }
    .dark #widgetMessagesContainer::-webkit-scrollbar-thumb {
        background: #334155;
    }
</style>

<script>
    const widgetWindow = document.getElementById('chatWindow');
    const widgetBtn = document.getElementById('toggleChatBtn');
    const chatIcon = document.getElementById('chatIcon');
    const closeIcon = document.getElementById('closeIcon');
    const widgetForm = document.getElementById('widgetMessageForm');
    const widgetInput = document.getElementById('widgetMessageInput');
    const widgetMessages = document.getElementById('widgetMessagesContainer');

    function toggleChat() {
        const isOpen = widgetWindow.classList.toggle('chat-window-active');
        chatIcon.classList.toggle('hidden', isOpen);
        closeIcon.classList.toggle('hidden', !isOpen);
        
        // Save state
        localStorage.setItem('chatbot_open', isOpen);
        
        if (isOpen) {
            scrollToWidgetBottom();
            setTimeout(() => widgetInput.focus(), 300);
        }
    }

    // Initialize state from localStorage
    if (localStorage.getItem('chatbot_open') === 'true') {
        toggleChat();
    }

    function scrollToWidgetBottom() {
        widgetMessages.scrollTop = widgetMessages.scrollHeight;
    }

    widgetForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const message = widgetInput.value.trim();
        if (!message) return;

        // Add user message
        const userDiv = document.createElement('div');
        userDiv.className = 'flex justify-end';
        userDiv.innerHTML = `
            <div class="bg-indigo-600 text-white rounded-2xl rounded-tr-none px-4 py-2 max-w-[85%] shadow-sm">
                <p class="text-sm leading-relaxed">${message}</p>
                <span class="text-[10px] text-indigo-200 mt-1 block text-right">${new Date().toLocaleTimeString('id-ID', {hour: '2-digit', minute:'2-digit'})}</span>
            </div>
        `;
        widgetMessages.appendChild(userDiv);
        widgetInput.value = '';
        scrollToWidgetBottom();

        // Typing indicator
        const typingDiv = document.createElement('div');
        typingDiv.id = 'widgetTyping';
        typingDiv.className = 'flex justify-start';
        typingDiv.innerHTML = `
            <div class="bg-white dark:bg-gray-700 rounded-2xl rounded-tl-none px-4 py-2 shadow-sm border border-gray-100 dark:border-gray-600">
                <div class="flex space-x-1">
                    <div class="w-1.5 h-1.5 bg-indigo-400 rounded-full animate-bounce"></div>
                    <div class="w-1.5 h-1.5 bg-indigo-400 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                    <div class="w-1.5 h-1.5 bg-indigo-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                </div>
            </div>
        `;
        widgetMessages.appendChild(typingDiv);
        scrollToWidgetBottom();

        try {
            const response = await fetch('{{ route("chatbot.send-message") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({ message: message })
            });

            const data = await response.json();
            document.getElementById('widgetTyping').remove();

            if (data.success) {
                const botDiv = document.createElement('div');
                botDiv.className = 'flex justify-start';
                const formatted = data.bot_message.message.replace(/\n/g, '<br>');
                botDiv.innerHTML = `
                    <div class="bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100 rounded-2xl rounded-tl-none px-4 py-2 max-w-[85%] shadow-sm border border-gray-100 dark:border-gray-600">
                        <p class="text-sm leading-relaxed">${formatted}</p>
                        <span class="text-[10px] text-gray-500 dark:text-gray-400 mt-1 block">${data.bot_message.timestamp}</span>
                    </div>
                `;
                widgetMessages.appendChild(botDiv);
                scrollToWidgetBottom();
            }
        } catch (error) {
            document.getElementById('widgetTyping').remove();
            console.error(error);
        }
    });

    function sendQuickWidgetMessage(msg) {
        widgetInput.value = msg;
        widgetForm.dispatchEvent(new Event('submit'));
    }

    function clearChatWidget() {
        if (confirm('Hapus riwayat obrolan?')) {
            fetch('{{ route("chatbot.clear") }}', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            }).then(() => location.reload());
        }
    }

    scrollToWidgetBottom();
</script>
