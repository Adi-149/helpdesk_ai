<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Chatbot Helpdesk</h2>
            <button onclick="clearChatSession()" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200 ease-in-out text-sm">
                <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                Hapus Pesan
            </button>
        </div>
    </x-slot>

    <div class="max-w-2xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden flex flex-col" style="height: 600px;">
            <!-- Messages Container -->
            <div id="messagesContainer" class="flex-1 overflow-y-auto p-6 bg-gray-50 dark:bg-gray-900">
                @if(empty($messages))
                    <div class="flex items-center justify-center h-full text-center">
                        <div>
                            <svg class="w-16 h-16 mx-auto text-gray-400 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                            <p class="text-gray-600 dark:text-gray-400 text-lg">Mulai percakapan di bawah</p>
                            <p class="text-gray-500 dark:text-gray-500 text-sm mt-2">Tanya apa saja kepada chatbot kami</p>
                        </div>
                    </div>
                @else
                    @foreach($messages as $message)
                        @if($message['sender_type'] === 'user')
                            <div class="flex justify-end mb-4">
                                <div class="bg-indigo-600 text-white rounded-lg rounded-tr-none px-4 py-2 max-w-xs lg:max-w-md">
                                    <p class="break-words">{{ $message['message'] }}</p>
                                    <p class="text-xs text-indigo-200 mt-1">{{ $message['timestamp'] }}</p>
                                </div>
                            </div>
                        @else
                            <div class="flex justify-start mb-4">
                                <div class="bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-100 rounded-lg rounded-tl-none px-4 py-2 max-w-xs lg:max-w-md">
                                    <p class="break-words">{{ $message['message'] }}</p>
                                    <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">{{ $message['timestamp'] }}</p>
                                </div>
                            </div>
                        @endif
                    @endforeach
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
                        placeholder="Ketik pertanyaan Anda..." 
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
            <button onclick="sendQuickMessage('Halo')" class="px-3 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-100 rounded-lg text-sm hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                Halo
            </button>
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
                const response = await fetch('{{ route("chatbot.send-message") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify({ message: message })
                });

                const data = await response.json();

                // Remove typing indicator
                const typingIndicator = document.getElementById('typingIndicator');
                if (typingIndicator) {
                    typingIndicator.remove();
                }

                if (data.success) {
                    // Add bot response
                    const botMessageDiv = document.createElement('div');
                    botMessageDiv.className = 'flex justify-start mb-4';
                    botMessageDiv.innerHTML = `
                        <div class="bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-100 rounded-lg rounded-tl-none px-4 py-2 max-w-xs lg:max-w-md">
                            <p class="break-words">${data.bot_message.message}</p>
                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">${data.bot_message.timestamp}</p>
                        </div>
                    `;
                    messagesContainer.appendChild(botMessageDiv);
                    scrollToBottom();
                } else {
                    alert('Gagal mengirim pesan');
                }
            } catch (error) {
                console.error('Error:', error);
                const typingIndicator = document.getElementById('typingIndicator');
                if (typingIndicator) {
                    typingIndicator.remove();
                }
                alert('Terjadi kesalahan');
            }
        });

        function sendQuickMessage(message) {
            messageInput.value = message;
            messageForm.dispatchEvent(new Event('submit'));
        }

        function clearChatSession() {
            if (confirm('Hapus semua pesan di session chat ini?')) {
                fetch('{{ route("chatbot.clear") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    }
                })
                .then(() => location.reload())
                .catch(error => {
                    console.error('Error:', error);
                    alert('Gagal menghapus pesan');
                });
            }
        }

        // Focus input on load
        messageInput.focus();

        // Clear chat session when page is about to unload
        window.addEventListener('beforeunload', () => {
            // Send beacon to clear session on page leave (optional)
            // navigator.sendBeacon('{{ route("chatbot.clear") }}');
        });
    </script>
</x-app-layout>
