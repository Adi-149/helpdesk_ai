<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detail Tiket</h2>
    </x-slot>

    <div class="max-w-4xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-4 p-4 rounded bg-green-50 border border-green-200 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow-sm rounded-lg p-6">
            <div class="border-b pb-6 mb-6">
                <h3 class="text-2xl font-bold text-gray-900 mb-4">{{ $ticket->subject }}</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="text-xs font-medium text-gray-500 uppercase">Pengguna</label>
                        <p class="text-gray-900">{{ $ticket->user->name }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-medium text-gray-500 uppercase">Kategori</label>
                        <p class="text-gray-900">{{ $ticket->category }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-medium text-gray-500 uppercase">Prioritas</label>
                        <p class="text-gray-900">{{ ucfirst($ticket->priority) }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-medium text-gray-500 uppercase">Dibuat pada</label>
                        <p class="text-gray-900">{{ $ticket->created_at->format('d-m-Y H:i') }}</p>
                    </div>
                </div>

                <div>
                    <label class="text-xs font-medium text-gray-500 uppercase">Status</label>
                    <p class="text-gray-900 mt-1">
                        <span class="inline-flex items-center px-3 py-1 rounded text-sm font-medium">
                            @if($ticket->status === 'open')
                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded">Dibuka</span>
                            @elseif($ticket->status === 'progress')
                                <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded">Sedang Diproses</span>
                            @elseif($ticket->status === 'resolved')
                                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded">Diselesaikan</span>
                            @elseif($ticket->status === 'closed')
                                <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded">Ditutup</span>
                            @else
                                <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded">{{ ucfirst($ticket->status) }}</span>
                            @endif
                        </span>
                    </p>
                </div>

                @if($ticket->assigned_to)
                    <div class="mt-4">
                        <label class="text-xs font-medium text-gray-500 uppercase">Ditangani oleh</label>
                        <p class="text-gray-900">{{ $ticket->assignedSupport->name }}</p>
                    </div>
                @endif
            </div>

            <div class="mb-6">
                <h4 class="text-lg font-medium text-gray-900 mb-2">Deskripsi</h4>
                <p class="text-gray-700 whitespace-pre-line">{{ $ticket->description }}</p>
            </div>

            @if(auth()->user()->role === 'support')
                <div class="border-t pt-6">
                    <h4 class="text-lg font-medium text-gray-900 mb-4">Perbarui Status</h4>

                    <form method="POST" action="{{ route('tickets.update', $ticket->id) }}">
                        @csrf
                        @method('PATCH')

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status Baru</label>
                            <select name="status" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                                <option value="open" {{ $ticket->status === 'open' ? 'selected' : '' }}>Dibuka</option>
                                <option value="progress" {{ $ticket->status === 'progress' ? 'selected' : '' }}>Sedang Diproses</option>
                                <option value="resolved" {{ $ticket->status === 'resolved' ? 'selected' : '' }}>Diselesaikan</option>
                                <option value="closed" {{ $ticket->status === 'closed' ? 'selected' : '' }}>Ditutup</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Prioritas</label>
                            <select name="priority" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                                <option value="low" {{ $ticket->priority === 'low' ? 'selected' : '' }}>Rendah</option>
                                <option value="medium" {{ $ticket->priority === 'medium' ? 'selected' : '' }}>Sedang</option>
                                <option value="high" {{ $ticket->priority === 'high' ? 'selected' : '' }}>Tinggi</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Ditangani oleh</label>
                            <select name="assigned_to" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                                <option value="">-- Pilih Support Staff --</option>
                                @foreach($supports as $support)
                                    <option value="{{ $support->id }}" {{ $ticket->assigned_to === $support->id ? 'selected' : '' }}>{{ $support->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Catatan (Opsional)</label>
                            <textarea name="notes" class="w-full border border-gray-300 rounded px-3 py-2 h-20 focus:outline-none focus:ring-2 focus:ring-indigo-200" placeholder="Tambahkan catatan tentang update ini..."></textarea>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Perbarui Status</button>
                        </div>
                    </form>
                </div>
            @endif

            <div class="border-t pt-6 mt-6">
                <h4 class="text-lg font-medium text-gray-900 mb-4">Riwayat Status</h4>

                @if($ticket->histories->count() > 0)
                    <div class="space-y-3">
                        @foreach($ticket->histories->sortByDesc('created_at') as $history)
                            <div class="border-l-4 border-indigo-400 bg-indigo-50 p-4 rounded">
                                <div class="flex items-center justify-between mb-2">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ $history->user->name }}
                                        </p>
                                        <p class="text-xs text-gray-600">{{ $history->created_at->format('d-m-Y H:i') }}</p>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        @if($history->old_status)
                                            <span class="text-xs bg-gray-100 text-gray-800 px-2 py-1 rounded">{{ $history->old_status === 'open' ? 'Dibuka' : ($history->old_status === 'progress' ? 'Sedang Diproses' : ($history->old_status === 'resolved' ? 'Diselesaikan' : 'Ditutup')) }}</span>
                                        @endif
                                        <span class="text-xs text-gray-400">→</span>
                                        <span class="text-xs bg-indigo-100 text-indigo-800 px-2 py-1 rounded">{{ $history->new_status === 'open' ? 'Dibuka' : ($history->new_status === 'progress' ? 'Sedang Diproses' : ($history->new_status === 'resolved' ? 'Diselesaikan' : 'Ditutup')) }}</span>
                                    </div>
                                </div>
                                @if($history->notes)
                                    <p class="text-sm text-gray-700 mt-2">{{ $history->notes }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-sm">Belum ada riwayat perubahan status.</p>
                @endif
            </div>
        </div>

        <div class="mt-4">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">← Kembali</a>
        </div>
    </div>
</x-app-layout>
