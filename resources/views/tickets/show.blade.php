<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detail Tiket</h2>
    </x-slot>

    <div class="{{ auth()->user()->role === 'user' ? 'max-w-4xl' : 'max-w-7xl' }} mx-auto py-6 px-4 sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-4 p-4 rounded bg-green-50 border border-green-200 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 p-4 rounded bg-red-50 border border-red-200 text-red-700">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 {{ auth()->user()->role === 'user' ? '' : 'lg:grid-cols-3' }} gap-6">
            <!-- Left/Main Column -->
            <div class="{{ auth()->user()->role === 'user' ? '' : 'lg:col-span-2' }} space-y-6">

                <div class="bg-white border border-gray-200 shadow-sm rounded-lg p-6">
                    <div class="border-b pb-6 mb-6">
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">{{ $ticket->subject }}</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="text-xs font-medium text-gray-500 uppercase">Pengguna</label>
                                <p class="text-gray-900 font-medium">{{ $ticket->user ? $ticket->user->name : 'Pengguna Dihapus' }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-medium text-gray-500 uppercase">Kategori</label>
                                <p class="text-gray-900 font-medium">{{ $ticket->category }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-medium text-gray-500 uppercase">Prioritas</label>
                                <p class="text-gray-900 font-medium">{{ ucfirst($ticket->priority) }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-medium text-gray-500 uppercase">Dibuat pada</label>
                                <p class="text-gray-900 font-medium">{{ $ticket->created_at->format('d-m-Y H:i') }}</p>
                            </div>
                        </div>

                        <div>
                            <label class="text-xs font-medium text-gray-500 uppercase">Status</label>
                            <p class="text-gray-900 mt-1">
                                <span class="inline-flex items-center rounded text-sm font-medium">
                                    @if($ticket->status === 'closed')
                                        <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded font-semibold">Ditutup</span>
                                    @elseif($ticket->status === 'resolved')
                                        <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded font-semibold">Diselesaikan</span>
                                    @elseif($ticket->assigned_to)
                                        <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded font-semibold">Ditangani</span>
                                    @elseif($ticket->status === 'open')
                                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded font-semibold">Dibuka</span>
                                    @elseif($ticket->status === 'progress')
                                        <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded font-semibold">Sedang Diproses</span>
                                    @else
                                        <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded font-semibold">{{ ucfirst($ticket->status) }}</span>
                                    @endif
                                </span>
                            </p>
                        </div>

                        @if($ticket->assigned_to)
                            <div class="mt-4">
                                <label class="text-xs font-medium text-gray-500 uppercase">Ditangani oleh</label>
                                <p class="text-gray-900 font-medium">{{ $ticket->assignedSupport->name }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- AI Resolution Summary -->
                    @if($ticket->resolution_summary)
                        <div class="mb-6 p-5 rounded-lg border border-green-200 bg-green-50/30">
                            <div class="flex items-center space-x-2 mb-3 text-green-800 font-bold text-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>Ringkasan Penyelesaian AI (Knowledge Base)</span>
                            </div>
                            <div class="text-sm text-gray-700 whitespace-pre-line leading-relaxed">
                                {{ $ticket->resolution_summary }}
                            </div>
                        </div>
                    @endif

                    <div class="mb-6">
                        <h4 class="text-lg font-medium text-gray-900 mb-2">Deskripsi</h4>
                        <p class="text-gray-700 whitespace-pre-line leading-relaxed">{{ $ticket->description }}</p>
                    </div>

                    @if($ticket->attachment)
                        <div class="mb-6 border-t pt-6">
                            <h4 class="text-lg font-medium text-gray-900 mb-2">Lampiran Foto</h4>
                            <div class="max-w-md rounded overflow-hidden shadow-sm border border-gray-200 bg-gray-50 p-2">
                                @php
                                    // Path relatif agar aman dari kesalahan konfigurasi APP_URL di .env
                                    $attachmentUrl = '/uploads/' . $ticket->attachment;
                                @endphp
                                <img src="{{ $attachmentUrl }}" alt="Lampiran Foto Tiket" class="w-full h-auto rounded object-cover max-h-[400px]">
                            </div>
                        </div>
                    @endif

                    @if($ticket->status === 'resolved' && auth()->id() === $ticket->user_id)
                        <div class="mb-6 p-4 rounded-lg bg-blue-50 border border-blue-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                            <div>
                                <h4 class="text-sm font-semibold text-blue-800">Konfirmasi Penyelesaian Tiket</h4>
                                <p class="text-xs text-blue-600 mt-1">Teknisi telah menyelesaikan kendala Anda. Silakan klik tombol di samping untuk menutup tiket ini jika kendala sudah benar-benar selesai.</p>
                            </div>
                            <form method="POST" action="{{ route('tickets.close', $ticket->id) }}">
                                @csrf
                                <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-semibold transition-colors">
                                    Konfirmasi Selesai
                                </button>
                            </form>
                        </div>
                    @endif

                    @if($ticket->status === 'closed' && (auth()->id() === $ticket->user_id || auth()->user()->role === 'admin'))
                        @php
                            $closedHistory = $ticket->histories()->where('new_status', 'closed')->latest()->first();
                            $closedTime = $closedHistory ? $closedHistory->created_at : $ticket->updated_at;
                            $canReopen = now()->diffInHours($closedTime) <= 48;
                        @endphp

                        @if($canReopen)
                            <div class="mb-6 p-4 rounded-lg bg-amber-50 border border-amber-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                                <div>
                                    <h4 class="text-sm font-semibold text-amber-800">Apakah kendala muncul kembali?</h4>
                                    <p class="text-xs text-amber-600 mt-1">
                                        Tiket ini telah ditutup. Namun, jika masalah yang sama muncul kembali, Anda dapat membuka kembali tiket ini. 
                                        Fitur ini hanya tersedia dalam waktu 48 jam setelah tiket ditutup (Tutup pada: {{ $closedTime->format('d-m-Y H:i') }}).
                                    </p>
                                </div>
                                <form method="POST" action="{{ route('tickets.reopen', $ticket->id) }}">
                                    @csrf
                                    <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-lg text-sm font-semibold transition-colors whitespace-nowrap">
                                        Buka Kembali Tiket
                                    </button>
                                </form>
                            </div>
                        @endif
                    @endif

                    @if(auth()->user()->role === 'support')
                        <div class="border-t pt-6">
                            <h4 class="text-lg font-medium text-gray-900 mb-4">Perbarui Status</h4>

                            <form method="POST" action="{{ route('tickets.update', $ticket->id) }}">
                                @csrf
                                @method('PATCH')

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Status Baru</label>
                                    <select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 bg-white">
                                        <option value="open" {{ $ticket->status === 'open' ? 'selected' : '' }}>Dibuka</option>
                                        <option value="progress" {{ $ticket->status === 'progress' ? 'selected' : '' }}>Sedang Diproses</option>
                                        <option value="resolved" {{ $ticket->status === 'resolved' ? 'selected' : '' }}>Diselesaikan</option>
                                        <option value="closed" {{ $ticket->status === 'closed' ? 'selected' : '' }}>Ditutup</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Prioritas</label>
                                    <select name="priority" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 bg-white">
                                        <option value="low" {{ $ticket->priority === 'low' ? 'selected' : '' }}>Rendah</option>
                                        <option value="medium" {{ $ticket->priority === 'medium' ? 'selected' : '' }}>Sedang</option>
                                        <option value="high" {{ $ticket->priority === 'high' ? 'selected' : '' }}>Tinggi</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Ditangani oleh</label>
                                    <select name="assigned_to" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 bg-white">
                                        <option value="">-- Pilih Support Staff --</option>
                                        <option value="{{ auth()->id() }}" {{ $ticket->assigned_to === auth()->id() ? 'selected' : '' }}>{{ auth()->user()->name }} (Saya)</option>
                                        @if($ticket->assigned_to && $ticket->assigned_to !== auth()->id() && $ticket->assignedSupport)
                                            <option value="{{ $ticket->assigned_to }}" selected>{{ $ticket->assignedSupport->name }}</option>
                                        @endif
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Catatan (Opsional)</label>
                                    <textarea name="notes" class="w-full border border-gray-300 rounded-lg px-3 py-2 h-20 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500" placeholder="Tambahkan catatan tentang update ini..."></textarea>
                                </div>

                                <div class="flex justify-end">
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Perbarui Status</button>
                                </div>
                            </form>
                        </div>
                    @endif

                    <div class="border-t pt-6 mt-6">
                        <h4 class="text-lg font-medium text-gray-900 mb-4">Riwayat Status</h4>

                        @if($ticket->histories->count() > 0)
                            <div class="space-y-3">
                                @foreach($ticket->histories->sortByDesc('created_at') as $history)
                                    <div class="border border-gray-300 border-l-4 border-l-blue-500 bg-gray-100/80 p-4 rounded-lg">
                                        <div class="flex items-center justify-between mb-2">
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">
                                                    {{ $history->user->name }}
                                                </p>
                                                <p class="text-xs text-gray-650 font-semibold">{{ $history->created_at->format('d-m-Y H:i') }}</p>
                                            </div>
                                            <div class="flex items-center space-x-2">
                                                @if($history->old_status)
                                                    <span class="text-xs bg-white text-gray-800 border border-gray-250 px-2 py-1 rounded font-semibold">{{ $history->old_status === 'open' ? 'Dibuka' : ($history->old_status === 'progress' ? 'Sedang Diproses' : ($history->old_status === 'resolved' ? 'Diselesaikan' : 'Ditutup')) }}</span>
                                                @endif
                                                <span class="text-xs text-gray-400">→</span>
                                                <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded font-semibold">{{ $history->new_status === 'open' && $ticket->assigned_to ? 'Ditangani' : ($history->new_status === 'open' ? 'Dibuka' : ($history->new_status === 'progress' ? 'Sedang Diproses' : ($history->new_status === 'resolved' ? 'Diselesaikan' : 'Ditutup'))) }}</span>
                                            </div>
                                        </div>
                                        @if($history->notes)
                                            <p class="text-sm text-gray-700 mt-2 font-medium">{{ $history->notes }}</p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 text-sm font-medium">Belum ada riwayat perubahan status.</p>
                        @endif
                    </div>
                </div>

                <!-- Area Diskusi / Chat Tiket -->
                <div class="bg-white border border-gray-200 shadow-sm rounded-lg p-6 mt-6">
                    <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                        Diskusi Tiket
                    </h4>

                    <!-- Box Pesan Chat -->
                    <div id="chat-box" class="border border-gray-200 rounded-lg bg-gray-100/50 p-4 mb-4 max-h-[400px] overflow-y-auto space-y-4">
                        @forelse($ticket->messages->sortBy('created_at') as $message)
                            @php
                                $isOwnMessage = $message->user_id === auth()->id();
                                $senderRole = $message->user->role;
                                
                                // Set style untuk role badge
                                $roleBadgeColor = 'bg-gray-100 text-gray-800';
                                if ($senderRole === 'support') {
                                    $roleBadgeColor = 'bg-blue-100 text-blue-800';
                                } elseif ($senderRole === 'admin') {
                                    $roleBadgeColor = 'bg-red-100 text-red-800';
                                }
                            @endphp

                            <div class="flex {{ $isOwnMessage ? 'justify-end' : 'justify-start' }}">
                                <div class="max-w-[75%] rounded-lg px-4 py-2 {{ $isOwnMessage ? 'bg-blue-600 text-white rounded-br-none' : 'bg-white text-gray-800 border border-gray-200 rounded-bl-none shadow-sm' }}">
                                    @if(!$isOwnMessage)
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="text-xs font-semibold text-gray-900">{{ $message->user->name }}</span>
                                            <span class="px-1.5 py-0.5 rounded text-[10px] font-bold {{ $roleBadgeColor }} uppercase">
                                                {{ $senderRole === 'support' ? 'Teknisi' : ($senderRole === 'admin' ? 'Admin' : 'User') }}
                                            </span>
                                        </div>
                                    @endif

                                    <p class="text-sm whitespace-pre-line leading-relaxed font-medium">{{ $message->message }}</p>
                                    
                                    <div class="text-[10px] mt-1 text-right {{ $isOwnMessage ? 'text-blue-200' : 'text-gray-400' }}">
                                        {{ $message->created_at->format('d-m-Y H:i') }}
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8 text-gray-500 text-sm">
                                <svg class="w-12 h-12 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path>
                                </svg>
                                Belum ada diskusi untuk tiket ini. Silakan mulai percakapan di bawah.
                            </div>
                        @endforelse
                    </div>

                    <!-- Form Kirim Pesan -->
                    <form id="chat-form" action="{{ route('tickets.messages.store', $ticket->id) }}" method="POST" class="mt-4">
                        @csrf
                        <div class="flex gap-2">
                            <textarea 
                                id="chat-message-input"
                                name="message" 
                                rows="2" 
                                class="flex-1 border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm resize-none" 
                                placeholder="Tulis pesan... (Enter untuk kirim, Shift+Enter untuk baris baru)" 
                                required></textarea>
                            <button 
                                type="submit" 
                                class="px-4 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-semibold flex items-center justify-center gap-1 transition-colors">
                                <svg class="w-4 h-4 transform rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                </svg>
                                Kirim
                            </button>
                        </div>
                    </form>

                    <script>
                        const chatForm = document.getElementById('chat-form');
                        const chatBox = document.getElementById('chat-box');
                        
                        // Scroll to bottom on load
                        if (chatBox) {
                            chatBox.scrollTop = chatBox.scrollHeight;
                        }
                        // Initialize with latest known message ID to avoid duplicates
                        let lastMessageId = {{ $ticket->messages->max('id') ?? 0 }};

                        // Submit message via AJAX
                        chatForm.addEventListener('submit', async function(e) {
                            e.preventDefault();
                            const formData = new FormData(chatForm);
                            try {
                                const response = await fetch(chatForm.action, {
                                    method: 'POST',
                                    headers: {
                                        'X-Requested-With': 'XMLHttpRequest',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        'Accept': 'application/json'
                                    },
                                    body: formData
                                });
                                if (!response.ok) {
                                    console.error('Failed to send message');
                                    return;
                                }
                                const data = await response.json();
                                // Append the new message to chat box and update lastMessageId
                                appendMessage(data);
                                lastMessageId = Math.max(lastMessageId, data.id);
                                chatForm.message.value = '';
                            } catch (err) {
                                // console.error(err);
                            }
                        });

                        // Enter kirim pesan, Shift+Enter buat baris baru
                        document.getElementById('chat-message-input').addEventListener('keydown', function(e) {
                            if (e.key === 'Enter' && !e.shiftKey) {
                                e.preventDefault();
                                chatForm.dispatchEvent(new Event('submit', { bubbles: true, cancelable: true }));
                            }
                        });

                        // Poll for new messages
                        async function pollMessages() {
                            try {
                                const resp = await fetch('{{ route('tickets.messages.index', $ticket->id) }}?after=' + lastMessageId, {
                                    headers: { 'Accept': 'application/json' }
                                });
                                if (!resp.ok) return;
                                const msgs = await resp.json();
                                msgs.forEach(msg => {
                                    if (msg.id > lastMessageId) {
                                        appendMessage(msg);
                                        lastMessageId = msg.id;
                                    }
                                });
                            } catch (e) { // console.error(e); 
                            }
                            setTimeout(pollMessages, 3000);
                        }

                        function appendMessage(msg) {
                            const isOwn = msg.user_id == {{ auth()->id() }};
                            const roleBadge = {
                                'admin': 'bg-red-100 text-red-800',
                                'support': 'bg-blue-100 text-blue-800',
                                'user': 'bg-gray-100 text-gray-800'
                            }[msg.user_role] || 'bg-gray-100 text-gray-800';
                            const container = document.createElement('div');
                            container.className = `flex ${isOwn ? 'justify-end' : 'justify-start'}`;
                            const bubble = document.createElement('div');
                            bubble.className = `max-w-[75%] rounded-lg px-4 py-2 ${isOwn ? 'bg-blue-600 text-white rounded-br-none' : 'bg-white text-gray-800 border border-gray-200 rounded-bl-none shadow-sm'}`;
                            if (!isOwn) {
                                const header = document.createElement('div');
                                header.className = 'flex items-center gap-2 mb-1';
                                const nameSpan = document.createElement('span');
                                nameSpan.className = 'text-xs font-semibold text-gray-900';
                                nameSpan.textContent = msg.user_name;
                                const roleSpan = document.createElement('span');
                                roleSpan.className = `px-1.5 py-0.5 rounded text-[10px] font-bold ${roleBadge} uppercase`;
                                roleSpan.textContent = msg.user_role === 'support' ? 'Teknisi' : (msg.user_role === 'admin' ? 'Admin' : 'User');
                                header.appendChild(nameSpan);
                                header.appendChild(roleSpan);
                                bubble.appendChild(header);
                            }
                            const p = document.createElement('p');
                            p.className = 'text-sm whitespace-pre-line leading-relaxed font-medium';
                            p.textContent = msg.message;
                            bubble.appendChild(p);
                            const timeDiv = document.createElement('div');
                            timeDiv.className = `text-[10px] mt-1 text-right ${isOwn ? 'text-blue-200' : 'text-gray-400'}`;
                            timeDiv.textContent = msg.created_at;
                            bubble.appendChild(timeDiv);
                            container.appendChild(bubble);
                            chatBox.appendChild(container);
                            // Scroll to bottom
                            chatBox.scrollTop = chatBox.scrollHeight;
                        }

                        // Initialize polling
                        pollMessages();
                    </script>
                </div>

            </div> <!-- end left column -->

            <!-- Right Column: AI Assistant & Similar Cases -->
            @if(auth()->user()->role === 'support' || auth()->user()->role === 'admin')
                <div class="space-y-6">
                    <!-- AI Assistant Card -->
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm text-gray-800 p-6 relative overflow-hidden">
                        <div class="flex items-center space-x-2 mb-4">
                            <span class="flex h-2.5 w-2.5 relative">
                                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-blue-600"></span>
                            </span>
                            <h3 class="text-xs font-extrabold uppercase tracking-widest text-blue-800">Asisten AI Teknisi</h3>
                        </div>

                        <div class="space-y-4">
                            <!-- Summary -->
                            <div>
                                <span class="text-[9px] uppercase tracking-wider text-blue-600 font-bold block">Ringkasan Masalah</span>
                                <p class="text-xs text-gray-700 mt-1 leading-relaxed font-medium">{{ $ticket->ai_summary }}</p>
                            </div>

                            <!-- Causes -->
                            @if($ticket->ai_causes)
                                <div>
                                    <span class="text-[9px] uppercase tracking-wider text-blue-600 font-bold block">Analisis Penyebab</span>
                                    <div class="text-xs text-gray-700 mt-1 space-y-1 leading-relaxed whitespace-pre-line font-medium">
                                        {{ $ticket->ai_causes }}
                                    </div>
                                </div>
                            @endif

                            <!-- Recommendations -->
                            @if($ticket->ai_recommendations)
                                <div>
                                    <span class="text-[9px] uppercase tracking-wider text-blue-600 font-bold block">Rekomendasi Tindakan</span>
                                    <div class="text-xs text-gray-700 mt-1 space-y-1 leading-relaxed whitespace-pre-line font-medium">
                                        {{ $ticket->ai_recommendations }}
                                    </div>
                                </div>
                            @endif

                            <!-- Confidence & Priority -->
                            <div class="grid grid-cols-2 gap-3 pt-3 border-t border-gray-200">
                                <div>
                                    <span class="text-[9px] uppercase tracking-wider text-blue-600 font-bold block">Keyakinan AI</span>
                                    <span class="text-xs font-bold text-green-600 mt-0.5 block">{{ $ticket->ai_confidence ?: '85%' }}</span>
                                </div>
                                <div>
                                    <span class="text-[9px] uppercase tracking-wider text-blue-600 font-bold block">Prioritas</span>
                                    <span class="text-xs font-bold mt-0.5 block uppercase {{ $ticket->priority === 'high' ? 'text-red-655' : ($ticket->priority === 'medium' ? 'text-orange-655' : 'text-green-655') }}">{{ $ticket->priority }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Similar Cases Card -->
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
                        <div class="flex items-center space-x-2 mb-4 pb-3 border-b border-gray-200">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                            </svg>
                            <h3 class="text-sm font-bold text-gray-900">Kasus Serupa</h3>
                        </div>

                        <div class="space-y-4">
                            @forelse($similarTickets as $match)
                                <div class="p-3 bg-gray-100 rounded-lg border border-gray-200 space-y-2">
                                    <div class="flex items-start justify-between gap-2">
                                        <a href="{{ route('tickets.show', $match['ticket']->id) }}" class="text-xs font-bold text-blue-600 hover:underline leading-tight">
                                            #TK-0{{ $match['ticket']->id }} : {{ \Illuminate\Support\Str::limit($match['ticket']->subject, 30) }}
                                        </a>
                                        <span class="px-1.5 py-0.5 rounded text-[9px] font-extrabold uppercase {{ $match['similarity'] === 'Tinggi' ? 'bg-red-100 text-red-800' : 'bg-orange-100 text-orange-800' }}">
                                            {{ $match['similarity'] }}
                                        </span>
                                    </div>
                                    <p class="text-[10px] text-gray-600 leading-normal font-medium">
                                        <strong>Relevansi:</strong> {{ $match['reason'] }}
                                    </p>
                                    @if($match['ticket']->resolution_summary)
                                        <div class="bg-white p-2 rounded text-[10px] border border-gray-200 text-gray-700">
                                            <strong>Solusi Terbukti:</strong>
                                            <p class="mt-0.5 italic whitespace-pre-line">{{ \Illuminate\Support\Str::limit($match['ticket']->resolution_summary, 120) }}</p>
                                        </div>
                                    @endif
                                </div>
                            @empty
                                <p class="text-xs text-gray-500 text-center py-4 italic font-medium">Belum menemukan kasus serupa.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            @endif
        </div> <!-- end grid -->

        <div class="mt-4">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 text-sm font-semibold">← Kembali</a>
        </div>
    </div>
</x-app-layout>
