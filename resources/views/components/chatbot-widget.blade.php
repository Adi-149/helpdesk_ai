@php
    $conversation = \App\Models\ChatbotConversation::where('user_id', auth()->id())
        ->where('status', 'active')
        ->first();
    $messages = $conversation ? $conversation->messages : collect();
    $userMessageCount = $conversation 
        ? $messages->where('sender_type', 'user')->count() 
        : 0;
    $maxMessages = 10;
@endphp

<div id="chatbot-widget" class="fixed bottom-6 right-6 z-[9999] flex flex-col items-end">
    <!-- Chat Window -->
    <div id="chatWindow" class="hidden mb-4 w-[350px] sm:w-[400px] bg-white rounded-xl shadow-lg overflow-hidden flex flex-col border border-gray-300 transition-all duration-300 ease-in-out transform scale-95 opacity-0 origin-bottom-right h-[500px] max-h-[calc(100vh-120px)]">
        <!-- Header -->
        <div class="bg-blue-600 p-4 flex items-center justify-between text-white">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-sm">IT Helpdesk AI</h3>
                    <div class="flex items-center space-x-1">
                        <span class="w-2 h-2 bg-green-400 rounded-full"></span>
                        <span class="text-[10px] text-blue-100 uppercase tracking-wider font-semibold">Online</span>
                        <span id="widgetMsgCounter" class="ml-2 text-[10px] bg-white/20 px-1.5 py-0.5 rounded-full font-bold {{ $userMessageCount >= $maxMessages ? 'bg-red-500/80 text-white' : '' }}">{{ $userMessageCount }}/{{ $maxMessages }}</span>
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
        <div id="widgetMessagesContainer" class="flex-1 overflow-y-auto p-4 bg-gray-100/60 space-y-4">
            @if($messages->isEmpty())
                <div class="flex flex-col items-center justify-center h-full text-center space-y-3 opacity-60">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    <p class="text-xs font-medium text-gray-500">Ada kendala IT? Tanyakan pada saya!</p>
                </div>
            @else
                @foreach($messages as $message)
                    @if($message->sender_type === 'user')
                        <div class="flex justify-end">
                            <div class="bg-blue-600 text-white rounded-xl rounded-tr-none px-4 py-2 max-w-[85%] shadow-sm">
                                <p class="text-sm leading-relaxed">{{ $message->message }}</p>
                                <span class="text-[10px] text-blue-200 mt-1 block text-right">{{ $message->created_at->format('H:i') }}</span>
                            </div>
                        </div>
                    @else
                        @php
                            $msgText = $message->message;
                            $source = null;
                            if (preg_match('/\[Sumber:\s*(.*?)\]/', $msgText, $matches)) {
                                $source = $matches[1];
                                $msgText = trim(str_replace($matches[0], '', $msgText));
                            }
                        @endphp
                        <div class="flex justify-start">
                            <div class="bg-white text-gray-800 rounded-xl rounded-tl-none px-4 py-2 max-w-[85%] shadow-sm border border-gray-300">
                                <p class="text-sm leading-relaxed whitespace-pre-wrap">{!! nl2br(e($msgText)) !!}</p>
                                @if($source)
                                    <div class="mt-2 flex items-center gap-1 text-[10px] font-bold text-blue-600 bg-blue-50 border border-blue-200 px-2 py-0.5 rounded-full w-fit">
                                        <svg class="w-3 h-3 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                        </svg>
                                        <span>Sumber: {{ $source }}</span>
                                    </div>
                                @endif
                                <span class="text-[10px] text-gray-500 mt-1 block">{{ $message->created_at->format('H:i') }}</span>
                            </div>
                        </div>
                    @endif
                @endforeach
            @endif
        </div>

        <!-- Helpdesk Ticket Link Banner -->
        <div class="px-4 py-2 bg-blue-50 border-t border-b border-blue-200 flex items-center justify-between">
            <span class="text-xs text-blue-700 font-medium">Solusi tidak membantu?</span>
            <a href="{{ route('tickets.create', ['analyze' => 1]) }}" class="text-xs font-bold text-blue-600 hover:text-blue-800 flex items-center space-x-1 transition-colors" id="ai-ticket-link">
                <span>Buat Tiket Otomatis (AI)</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>

        <!-- Limit Notification Banner -->
        <div id="widgetLimitBanner" class="{{ $userMessageCount >= $maxMessages ? '' : 'hidden' }} px-4 py-3 bg-amber-50 border-t border-amber-200">
            <div class="flex items-center space-x-2">
                <svg class="w-4 h-4 text-amber-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                </svg>
                <p class="text-xs font-medium text-amber-700">Anda telah mencapai batas <strong>{{ $maxMessages }} pesan</strong> untuk sesi ini. Hapus chat untuk memulai sesi baru.</p>
            </div>
        </div>

        <!-- Input -->
        <div class="p-4 bg-white border-t border-gray-300">
            <form id="widgetMessageForm" class="flex items-center space-x-2">
                <input 
                    type="text" 
                    id="widgetMessageInput" 
                    class="flex-1 bg-gray-100 border-none rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 text-gray-900 {{ $userMessageCount >= $maxMessages ? 'opacity-50 cursor-not-allowed' : '' }}" 
                    placeholder="{{ $userMessageCount >= $maxMessages ? 'Batas pesan tercapai' : 'Tanya sesuatu...' }}"
                    autocomplete="off"
                    {{ $userMessageCount >= $maxMessages ? 'disabled' : '' }}
                >
                <button type="submit" id="widgetSubmitBtn" class="bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-lg transition-all active:scale-95 shadow-sm {{ $userMessageCount >= $maxMessages ? 'opacity-50 cursor-not-allowed' : '' }}" {{ $userMessageCount >= $maxMessages ? 'disabled' : '' }}>
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5.951-2.976 5.951 2.976a1 1 0 001.169-1.409l-7-14z"/>
                    </svg>
                </button>
            </form>
        </div>
    </div>

    <!-- Toggle Button -->
    <button id="toggleChatBtn" onclick="toggleChat()" class="group bg-blue-600 hover:bg-blue-700 text-white p-4 rounded-full shadow-lg transition-all duration-300 active:scale-90 flex items-center justify-center relative overflow-hidden">
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
</style>

<script>
    const widgetWindow = document.getElementById('chatWindow');
    const widgetBtn = document.getElementById('toggleChatBtn');
    const chatIcon = document.getElementById('chatIcon');
    const closeIcon = document.getElementById('closeIcon');
    const widgetForm = document.getElementById('widgetMessageForm');
    const widgetInput = document.getElementById('widgetMessageInput');
    const widgetMessages = document.getElementById('widgetMessagesContainer');
    const widgetSubmitBtn = document.getElementById('widgetSubmitBtn');
    const widgetLimitBanner = document.getElementById('widgetLimitBanner');
    const widgetMsgCounter = document.getElementById('widgetMsgCounter');

    let widgetUserMsgCount = {{ $userMessageCount }};
    const widgetMaxMessages = {{ $maxMessages }};

    function updateWidgetCounter() {
        widgetMsgCounter.textContent = `${widgetUserMsgCount}/${widgetMaxMessages}`;
        if (widgetUserMsgCount >= widgetMaxMessages) {
            widgetMsgCounter.classList.add('bg-red-500/80', 'text-white');
        }
    }

    function disableWidgetInput() {
        widgetInput.disabled = true;
        widgetInput.placeholder = 'Batas pesan tercapai';
        widgetInput.classList.add('opacity-50', 'cursor-not-allowed');
        widgetSubmitBtn.disabled = true;
        widgetSubmitBtn.classList.add('opacity-50', 'cursor-not-allowed');
        widgetLimitBanner.classList.remove('hidden');
    }

    function toggleChat() {
        const isOpen = widgetWindow.classList.toggle('chat-window-active');
        chatIcon.classList.toggle('hidden', isOpen);
        closeIcon.classList.toggle('hidden', !isOpen);
        
        // Save state
        localStorage.setItem('chatbot_open', isOpen);
        
        if (isOpen) {
            scrollToWidgetBottom();
            if (!widgetInput.disabled) {
                setTimeout(() => widgetInput.focus(), 300);
            }
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

        // Cek limit di frontend
        if (widgetUserMsgCount >= widgetMaxMessages) {
            disableWidgetInput();
            return;
        }

        // Add user message
        const userDiv = document.createElement('div');
        userDiv.className = 'flex justify-end';
        userDiv.innerHTML = `
            <div class="bg-blue-600 text-white rounded-xl rounded-tr-none px-4 py-2 max-w-[85%] shadow-sm">
                <p class="text-sm leading-relaxed">${message}</p>
                <span class="text-[10px] text-blue-200 mt-1 block text-right">${new Date().toLocaleTimeString('id-ID', {hour: '2-digit', minute:'2-digit'})}</span>
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
            <div class="bg-white rounded-xl rounded-tl-none px-4 py-2 shadow-sm border border-gray-300">
                <div class="flex space-x-1">
                    <div class="w-1.5 h-1.5 bg-blue-400 rounded-full animate-bounce"></div>
                    <div class="w-1.5 h-1.5 bg-blue-400 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                    <div class="w-1.5 h-1.5 bg-blue-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
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
            const typingEl = document.getElementById('widgetTyping');
            if (typingEl) typingEl.remove();

            // Handle limit reached (429)
            if (response.status === 429 || data.limit_reached) {
                // Hapus pesan user yang baru ditambahkan (karena ditolak server)
                userDiv.remove();
                widgetUserMsgCount = data.user_message_count || widgetMaxMessages;
                updateWidgetCounter();
                disableWidgetInput();
                return;
            }

            if (data.success) {
                // Update counter
                widgetUserMsgCount = data.user_message_count;
                updateWidgetCounter();

                // Add bot response
                const botDiv = document.createElement('div');
                botDiv.className = 'flex justify-start';
                
                let rawMsg = data.bot_message.message;
                let sourceBadge = '';
                const match = rawMsg.match(/\[Sumber:\s*(.*?)\]/);
                if (match) {
                    rawMsg = rawMsg.replace(match[0], '').trim();
                    sourceBadge = `
                        <div class="mt-2 flex items-center gap-1 text-[10px] font-bold text-blue-600 bg-blue-50 border border-blue-200 px-2 py-0.5 rounded-full w-fit">
                            <svg class="w-3 h-3 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            <span>Sumber: ${match[1]}</span>
                        </div>
                    `;
                }

                const formatted = rawMsg.replace(/\n/g, '<br>');
                botDiv.innerHTML = `
                    <div class="bg-white text-gray-800 rounded-xl rounded-tl-none px-4 py-2 max-w-[85%] shadow-sm border border-gray-300">
                        <p class="text-sm leading-relaxed">${formatted}</p>
                        ${sourceBadge}
                        <span class="text-[10px] text-gray-500 mt-1 block">${data.bot_message.timestamp}</span>
                    </div>
                `;
                widgetMessages.appendChild(botDiv);
                scrollToWidgetBottom();

                // Cek apakah sudah capai limit setelah kirim
                if (widgetUserMsgCount >= widgetMaxMessages) {
                    disableWidgetInput();
                }
            }
        } catch (error) {
            const typingEl = document.getElementById('widgetTyping');
            if (typingEl) typingEl.remove();
            console.error(error);
        }
    });

    function sendQuickWidgetMessage(msg) {
        if (widgetUserMsgCount >= widgetMaxMessages) {
            disableWidgetInput();
            return;
        }
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
