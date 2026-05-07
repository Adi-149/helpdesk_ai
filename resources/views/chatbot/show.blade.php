<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ $conversation->title }}</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Dibuat: {{ $conversation->created_at->format('d M Y H:i') }}</p>
            </div>
            <a href="{{ route('chatbot.index') }}" class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 font-semibold">
                ← Kembali
            </a>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden flex flex-col" style="height: 600px;">
            <!-- Messages Container -->
            <div id="messagesContainer" class="flex-1 overflow-y-auto p-6 bg-gray-50 dark:bg-gray-900">
                @foreach($messages as $message)
                    @if($message->sender_type === 'user')
                        <div class="flex justify-end mb-4">
                            <div class="bg-indigo-600 text-white rounded-lg rounded-tr-none px-4 py-2 max-w-xs lg:max-w-md">
                                <p class="break-words">{{ $message->message }}</p>
                                <p class="text-xs text-indigo-200 mt-1">{{ $message->created_at->format('H:i') }}</p>
                            </div>
                        </div>
                    @else
                        <div class="flex justify-start mb-4">
                            <div class="bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-100 rounded-lg rounded-tl-none px-4 py-2 max-w-xs lg:max-w-md">
                                <p class="break-words">{{ $message->response ?? 'Loading...' }}</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">{{ $message->created_at->format('H:i') }}</p>
                            </div>
                        </div>
                    @endif
                @endforeach
                @if($messages->count() === 0)
                    <div class="flex items-center justify-center h-full text-center">
                        <div>
                            <svg class="w-16 h-16 mx-auto text-gray-400 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                            <p class="text-gray-600 dark:text-gray-400">Mulai percakapan dengan mengetik pesan di bawah</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Input Area -->
            <div class="border-t dark:border-gray-700 p-4 bg-white dark:bg-gray-800">
                <form id="messageForm" class="flex space-x-2">
                    @csrf
                    <input 
                        type="text" 
                        id="messageInput" 
                        name="message" 
                        class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-100" 
                        placeholder="Ketik pesan Anda..." 
                        autocomplete="off"
                    >
                    <button 
                        type="submit" 
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg transition duration-200 ease-in-out flex items-center space-x-2"
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
            <button onclick="sendQuickMessage('Apa jam kerja support?')" class="px-3 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-100 rounded-lg text-sm hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                Jam kerja
            </button>
            <button onclick="sendQuickMessage('Bagaimana cara membuat tiket?')" class="px-3 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-100 rounded-lg text-sm hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                Cara membuat tiket
            </button>
            <button onclick="sendQuickMessage('Saya butuh bantuan')" class="px-3 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-100 rounded-lg text-sm hover:bg-gray-300 dark:hover:bg-gray-600 transition">
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
        function scrollToBottom() {
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
                <div class="bg-indigo-600 text-white rounded-lg rounded-tr-none px-4 py-2 max-w-xs lg:max-w-md">
                    <p class="break-words">${message}</p>
                    <p class="text-xs text-indigo-200 mt-1">${new Date().toLocaleTimeString('id-ID', {hour: '2-digit', minute:'2-digit'})}</p>
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
                <div class="bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-100 rounded-lg rounded-tl-none px-4 py-2">
                    <div class="flex space-x-2">
                        <div class="w-2 h-2 bg-gray-600 dark:bg-gray-400 rounded-full animate-bounce"></div>
                        <div class="w-2 h-2 bg-gray-600 dark:bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                        <div class="w-2 h-2 bg-gray-600 dark:bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
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
                document.getElementById('typingIndicator').remove();

                if (data.success) {
                    // Add bot response
                    const botMessageDiv = document.createElement('div');
                    botMessageDiv.className = 'flex justify-start mb-4';
                    botMessageDiv.innerHTML = `
                        <div class="bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-100 rounded-lg rounded-tl-none px-4 py-2 max-w-xs lg:max-w-md">
                            <p class="break-words">${data.bot_response}</p>
                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">${new Date().toLocaleTimeString('id-ID', {hour: '2-digit', minute:'2-digit'})}</p>
                        </div>
                    `;
                    messagesContainer.appendChild(botMessageDiv);
                    scrollToBottom();
                } else {
                    alert('Gagal mengirim pesan');
                }
            } catch (error) {
                console.error('Error:', error);
                document.getElementById('typingIndicator').remove();
                alert('Terjadi kesalahan');
            }
        });

        function sendQuickMessage(message) {
            messageInput.value = message;
            messageForm.dispatchEvent(new Event('submit'));
        }

        // Focus input on load
        messageInput.focus();
    </script>
</x-app-layout>
