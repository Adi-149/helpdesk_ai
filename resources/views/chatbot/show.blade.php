<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $conversation->title }}</h2>
                <p class="text-sm text-gray-500 mt-1 font-semibold">Dibuat: {{ $conversation->created_at->format('d M Y H:i') }}</p>
            </div>
            <a href="{{ route('chatbot.index') }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                ← Kembali
            </a>
        </div>
    </x-slot>

    <div class="max-w-xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden flex flex-col" style="height: 550px;">
            <!-- Messages Container -->
            <div id="messagesContainer" class="flex-1 overflow-y-auto p-6 bg-gray-100/50">
                @foreach($messages as $message)
                    @if($message->sender_type === 'user')
                        <div class="flex justify-end mb-4">
                            <div class="bg-blue-600 text-white rounded-lg rounded-tr-none px-4 py-2 max-w-xs lg:max-w-md shadow-sm">
                                <p class="break-words font-medium">{{ $message->message }}</p>
                                <p class="text-xs text-blue-200 mt-1 text-right">{{ $message->created_at->format('H:i') }}</p>
                            </div>
                        </div>
                    @else
                        @php
                            $msgText = $message->response ?? $message->message;
                            $source = null;
                            if (preg_match('/\[Sumber:\s*(.*?)\]/', $msgText, $matches)) {
                                $source = $matches[1];
                                $msgText = trim(str_replace($matches[0], '', $msgText));
                            }
                        @endphp
                        <div class="flex justify-start mb-4">
                            <div class="bg-white text-gray-800 border border-gray-300 rounded-lg rounded-tl-none px-4 py-2 max-w-xs lg:max-w-md shadow-sm">
                                <p class="break-words font-medium">{!! nl2br(e($msgText)) !!}</p>
                                @if($source)
                                    <div class="mt-2 flex items-center gap-1 text-[10px] font-bold text-blue-600 bg-blue-50 border border-blue-200 px-2 py-0.5 rounded-full w-fit">
                                        <svg class="w-3 h-3 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                        </svg>
                                        <span>Sumber: {{ $source }}</span>
                                    </div>
                                @endif
                                <p class="text-xs text-gray-500 mt-1">{{ $message->created_at->format('H:i') }}</p>
                            </div>
                        </div>
                    @endif
                @endforeach
                @if($messages->count() === 0)
                    <div class="flex items-center justify-center h-full text-center">
                        <div>
                            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                            <p class="text-gray-600 font-medium">Mulai percakapan dengan mengetik pesan di bawah</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Input Area -->
            <div class="border-t border-gray-200 p-4 bg-white">
                <form id="messageForm" class="flex space-x-2">
                    @csrf
                    <input 
                        type="text" 
                        id="messageInput" 
                        name="message" 
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white text-gray-900" 
                        placeholder="Ketik pesan Anda..." 
                        autocomplete="off"
                    >
                    <button 
                        type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition duration-200 ease-in-out flex items-center space-x-2 shadow-sm"
                    >
                        <span>Kirim</span>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5.951-2.976 5.951 2.976a1 1 0 001.169-1.409l-7-14z"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="mt-6 flex flex-wrap gap-2">
            <button onclick="sendQuickMessage('Apa jam kerja support?')" class="px-3 py-2 bg-gray-200 text-gray-800 rounded-lg text-sm hover:bg-gray-300 transition font-semibold">
                Jam kerja
            </button>
            <button onclick="sendQuickMessage('Bagaimana cara membuat tiket?')" class="px-3 py-2 bg-gray-200 text-gray-800 rounded-lg text-sm hover:bg-gray-300 transition font-semibold">
                Cara membuat tiket
            </button>
            <button onclick="sendQuickMessage('Saya butuh bantuan')" class="px-3 py-2 bg-gray-200 text-gray-800 rounded-lg text-sm hover:bg-gray-300 transition font-semibold">
                Minta bantuan
            </button>
        </div>
    </div>

    <script>
        const conversationId = {{ $conversation->id }};
        const messageForm = document.getElementById('messageForm');
        const messageInput = document.getElementById('messageInput');
        const messagesContainer = document.getElementById('messagesContainer');

        // Auto-scroll to bottom
        window.scrollToBottom = function() {
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }

        // Initial scroll
        setTimeout(scrollToBottom, 100);

        messageForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const message = messageInput.value.trim();
            if (!message) return;

            // Add user message to UI
            const userMessageDiv = document.createElement('div');
            userMessageDiv.className = 'flex justify-end mb-4';
            userMessageDiv.innerHTML = `
                <div class="bg-blue-600 text-white rounded-lg rounded-tr-none px-4 py-2 max-w-xs lg:max-w-md shadow-sm">
                    <p class="break-words font-medium">${message}</p>
                    <p class="text-xs text-blue-200 mt-1 text-right">${new Date().toLocaleTimeString('id-ID', {hour: '2-digit', minute:'2-digit'})}</p>
                </div>
            `;
            messagesContainer.appendChild(userMessageDiv);
            messageInput.value = '';
            scrollToBottom();

            // Show typing indicator
            const typingDiv = document.createElement('div');
            typingDiv.className = 'flex justify-start mb-4';
            typingDiv.id = 'typingIndicator';
            typingDiv.innerHTML = `
                <div class="bg-white border border-gray-300 rounded-lg rounded-tl-none px-4 py-2 shadow-sm">
                    <div class="flex space-x-2">
                        <div class="w-2 h-2 bg-blue-400 rounded-full animate-bounce"></div>
                        <div class="w-2 h-2 bg-blue-400 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                        <div class="w-2 h-2 bg-blue-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                    </div>
                </div>
            `;
            messagesContainer.appendChild(typingDiv);
            scrollToBottom();

            try {
                const response = await fetch(`/chatbot/${conversationId}/send-message`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify({ message: message })
                });

                const data = await response.json();

                // Remove typing indicator
                const indicator = document.getElementById('typingIndicator');
                if (indicator) indicator.remove();

                if (data.success) {
                    // Add bot response
                    const botMessageDiv = document.createElement('div');
                    botMessageDiv.className = 'flex justify-start mb-4';
                    
                    let rawMsg = (data.bot_message && data.bot_message.message) ? data.bot_message.message : (data.bot_response || '');
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
                    botMessageDiv.innerHTML = `
                        <div class="bg-white text-gray-800 border border-gray-300 rounded-lg rounded-tl-none px-4 py-2 max-w-xs lg:max-w-md shadow-sm">
                            <p class="break-words font-medium">${formatted}</p>
                            ${sourceBadge}
                            <p class="text-xs text-gray-500 mt-1">${new Date().toLocaleTimeString('id-ID', {hour: '2-digit', minute:'2-digit'})}</p>
                        </div>
                    `;
                    messagesContainer.appendChild(botMessageDiv);
                    scrollToBottom();
                } else {
                    alert('Gagal mengirim pesan');
                }
            } catch (error) {
                console.error('Error:', error);
                const indicator = document.getElementById('typingIndicator');
                if (indicator) indicator.remove();
                alert('Terjadi kesalahan');
            }
        });

        window.sendQuickMessage = function(message) {
            messageInput.value = message;
            messageForm.dispatchEvent(new Event('submit'));
        }

        // Focus input on load
        messageInput.focus();
    </script>
</x-app-layout>
