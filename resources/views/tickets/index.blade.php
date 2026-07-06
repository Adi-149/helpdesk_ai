<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ auth()->user()->role === 'admin' ? 'Semua Tiket' : 'Tiket Saya' }}
        </h2>
    </x-slot>

    <div class="max-w-5xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-4 p-4 rounded bg-green-50 border border-green-200 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow-sm rounded-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">
                    {{ auth()->user()->role === 'admin' ? 'Daftar Semua Tiket' : 'Daftar Tiket Saya' }}
                </h3>
                <a href="{{ route('tickets.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">+ Buat Tiket</a>
            </div>

            <!-- Filter Bar -->
            <div class="mb-6 p-4 bg-gray-50 rounded-xl border border-gray-200">
                <form method="GET" action="{{ route('tickets.index') }}" id="filterForm">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-3 items-end">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Status</label>
                            <select name="status" onchange="document.getElementById('filterForm').submit()" class="w-full px-3 py-1.5 text-xs border border-gray-300 rounded-lg bg-white text-gray-900 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">-- Semua Status --</option>
                                <option value="open" @selected($filterStatus === 'open')>Dibuka</option>
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
                            <a href="{{ route('tickets.index') }}" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs text-red-600 hover:text-red-800 border border-red-300 rounded-lg hover:bg-red-50 transition">Reset Filter</a>
                        </div>
                    @endif
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            @if(auth()->user()->role === 'admin')
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                            @endif
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Judul</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Prioritas</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($tickets as $ticket)
                        <tr class="hover:bg-gray-50">
                            @if(auth()->user()->role === 'admin')
                                <td class="px-4 py-3 text-sm text-gray-900">{{ $ticket->user ? $ticket->user->name : 'Pengguna Dihapus' }}</td>
                            @endif
                            <td class="px-4 py-3 text-sm text-gray-900 font-medium">{{ Str::limit($ticket->subject, 30) }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">
                                @if($ticket->priority === 'high')
                                    <span class="px-2 py-0.5 bg-red-100 text-red-700 rounded text-xs font-semibold">Tinggi</span>
                                @elseif($ticket->priority === 'medium')
                                    <span class="px-2 py-0.5 bg-orange-100 text-orange-700 rounded text-xs font-semibold">Sedang</span>
                                @else
                                    <span class="px-2 py-0.5 bg-green-100 text-green-700 rounded text-xs font-semibold">Rendah</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium ">
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
                            <td class="px-4 py-3 text-right text-sm">
                                <a href="{{ route('tickets.show', $ticket->id) }}" class="inline-flex items-center px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-xs font-semibold">Lihat</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td class="px-4 py-6 text-center text-sm text-gray-500" colspan="{{ auth()->user()->role === 'admin' ? 6 : 5 }}">Belum ada tiket.</td>
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
