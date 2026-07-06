<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Tiket Teknisi</h2>
            <svg class="w-8 h-8 text-purple-600 dark:text-purple-400 opacity-30" fill="currentColor" viewBox="0 0 24 24">
                <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zm-5.04-6.71l-2.75 3.54-2.29-2.59c-.49-.53-1.3-.53-1.79 0-.51.58-.47 1.45.1 1.97l3.21 3.65c.39.42.92.65 1.5.65.48 0 .95-.17 1.34-.52l4.2-5.35c.45-.59.35-1.45-.25-1.89-.59-.45-1.45-.35-1.89.25l-3.18 4.06z"/>
            </svg>
        </div>
    </x-slot>

    <div class="max-w-6xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-4 p-4 rounded bg-green-50 border border-green-200 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow-sm rounded-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Daftar Tiket</h3>
                <p class="text-xs text-gray-500">Sedang ditangani teknisi</p><span>{{ $tickets->total() }} tiket ditemukan</span>
            </div>
            
            <!-- Filter Bar -->
            <div class="mb-6 p-4 bg-gray-50 rounded-xl border border-gray-200">
                <form method="GET" action="{{ route('support.tickets') }}" id="filterForm">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-3 items-end">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Status</label>
                            <select name="status" onchange="document.getElementById('filterForm').submit()" class="w-full px-3 py-1.5 text-xs border border-gray-300 rounded-lg bg-white text-gray-900 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">-- Pilih Teknisi --</option>
                                <option value="support" @selected(auth()->user()->role === 'support')>Teknisi</option>
                                <option value="progress" @selected($filterStatus === 'progress')>Diproses</option>
                                <option value="resolved" @selected($filterStatus === 'resolved')>Diselesaikan</option>
                                <option value="closed" @selected($filterStatus === 'closed')>Ditutup</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Prioritas</label>
                            <select name="priority" onchange="document.getElementById('filterForm').submit()" class="w-full px-3 py-1.5 text-xs border border-gray-300 rounded-lg bg-white text-gray-900 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Semua Prioritas</option>
                                <option value="high" @selected($filterPriority === 'high')>Tinggi</option>
                                <option value="medium" @selected($filterPriority === 'medium')>Sedang</option>
                                <option value="low" @selected($filterPriority === 'low')>Rendah</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Kategori</label>
                            <select name="category" onchange="document.getElementById('filterForm').submit()" class="w-full px-3 py-1.5 text-xs border border-gray-300 rounded-lg bg-white text-gray-900 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat }}" @selected($filterCategory === $cat)>{{ $cat }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Dari Tanggal</label>
                            <input type="date" name="date_from" value="{{ $filterDateFrom }}" onchange="document.getElementById('filterForm').submit()" class="w-full px-3 py-1.5 text-xs border border-gray-300 rounded-lg bg-white text-gray-900 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Sampai Tanggal</label>
                            <input type="date" name="date_to" value="{{ $filterDateTo }}" onchange="document.getElementById('filterForm').submit()" class="w-full px-3 py-1.5 text-xs border border-gray-300 rounded-lg bg-white text-gray-900 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                    @if($filterStatus || $filterPriority || $filterCategory || $filterDateFrom || $filterDateTo)
                        <div class="mt-3 flex justify-end">
                            <a href="{{ route('support.tickets') }}" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs text-red-600 hover:text-red-800 border border-red-300 rounded-lg hover:bg-red-50 transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                Reset Filter
                            </a>
                        </div>
                    @endif
                </form>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Judul</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Prioritas</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($tickets as $ticket)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $ticket->user ? $ticket->user->name : 'Dihapus' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900 font-medium">{{ Str::limit($ticket->subject, 35) }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">
                                <span class="px-2 py-0.5 bg-gray-100 text-gray-700 rounded text-xs">{{ $ticket->category }}</span>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                @if($ticket->priority === 'high')
                                    <span class="px-2 py-0.5 bg-red-100 text-red-700 rounded text-xs font-semibold">Tinggi</span>
                                @elseif($ticket->priority === 'medium')
                                    <span class="px-2 py-0.5 bg-orange-100 text-orange-700 rounded text-xs font-semibold">Sedang</span>
                                @else
                                    <span class="px-2 py-0.5 bg-green-100 text-green-700 rounded text-xs font-semibold">Rendah</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <span class="inline-flex items-center rounded text-xs font-medium ">
                                    @if($ticket->assigned_to && $ticket->status === 'open')
                                        <span class="bg-purple-100 text-purple-800 px-2 py-0.5 rounded">Ditangani</span>
                                    @elseif($ticket->status === 'open')
                                        <span class="bg-green-100 text-green-800 px-2 py-0.5 rounded">Dibuka</span>
                                    @elseif($ticket->status === 'progress')
                                        <span class="bg-yellow-100 text-yellow-800 px-2 py-0.5 rounded">Sedang Diproses</span>
                                    @elseif($ticket->status === 'resolved')
                                        <span class="bg-blue-100 text-blue-800 px-2 py-0.5 rounded">Diselesaikan</span>
                                    @else
                                        <span class="bg-gray-100 text-gray-800 px-2 py-0.5 rounded">Ditutup</span>
                                    @endif
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $ticket->created_at->format('d-m-Y') }}</td>
                            <td class="px-4 py-3 text-right space-x-2 flex justify-end items-center">
                                <a href="{{ route('tickets.show', $ticket->id) }}" class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-xs font-semibold transition">Lihat</a>
                                @if(!$ticket->assigned_to)
                                    <a href="{{ route('tickets.assign.form', $ticket->id) }}" class="inline-flex items-center px-3 py-1.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 text-xs font-semibold transition">Ambil</a>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td class="px-4 py-6 text-center text-sm text-gray-500" colspan="7">Tidak ada tiket yang sesuai filter.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($tickets->hasPages())
                <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-4">
                    {{ $tickets->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
