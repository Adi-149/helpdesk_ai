<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dasbor Saya</h2>
            <svg class="w-8 h-8 text-blue-600 opacity-20" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z"/>
            </svg>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <!-- Top Stats Grid -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 mb-6">
            <div class="bg-white border border-gray-200 border-l-4 border-l-blue-600 rounded-lg p-6 shadow-sm">
                <div class="flex flex-col">
                    <p class="text-blue-700 text-xs font-semibold uppercase tracking-wider">Total Tiket</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalTickets }}</p>
                </div>
            </div>

            <div class="bg-white border border-gray-200 border-l-4 border-l-green-600 rounded-lg p-6 shadow-sm">
                <div class="flex flex-col">
                    <p class="text-green-700 text-xs font-semibold uppercase tracking-wider">Dibuka</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $ticketsByStatus['open'] }}</p>
                </div>
            </div>

            <div class="bg-white border border-gray-200 border-l-4 border-l-amber-500 rounded-lg p-6 shadow-sm">
                <div class="flex flex-col">
                    <p class="text-amber-700 text-xs font-semibold uppercase tracking-wider">Diproses</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $ticketsByStatus['progress'] }}</p>
                </div>
            </div>

            <div class="bg-white border border-gray-200 border-l-4 border-l-sky-500 rounded-lg p-6 shadow-sm">
                <div class="flex flex-col">
                    <p class="text-sky-700 text-xs font-semibold uppercase tracking-wider">Selesai</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $ticketsByStatus['resolved'] }}</p>
                </div>
            </div>

            <div class="col-span-2 lg:col-span-1 bg-white border border-gray-200 border-l-4 border-l-gray-500 rounded-lg p-6 shadow-sm">
                <div class="flex flex-col">
                    <p class="text-gray-700 text-xs font-semibold uppercase tracking-wider">Ditutup</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $ticketsByStatus['closed'] }}</p>
                </div>
            </div>
        </div>

        <!-- Status Box -->
        <div class="mb-6">
            <!-- Status Breakdown -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Status Tiket Saya</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                    <!-- Dibuka -->
                    <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg border border-green-200 border-l-4 border-l-green-500">
                        <div>
                            <p class="text-sm font-semibold text-gray-700">Dibuka</p>
                            <p class="text-xs text-gray-600">Menunggu ditangani</p>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-bold text-green-600">{{ $ticketsByStatus['open'] }}</p>
                            <p class="text-xs text-gray-600">{{ $totalTickets > 0 ? round(($ticketsByStatus['open'] / $totalTickets) * 100) : 0 }}%</p>
                        </div>
                    </div>

                    <!-- Diproses -->
                    <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-lg border border-yellow-200 border-l-4 border-l-yellow-500">
                        <div>
                            <p class="text-sm font-semibold text-gray-700">Sedang Diproses</p>
                            <p class="text-xs text-gray-600">Sedang ditangani support</p>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-bold text-yellow-600">{{ $ticketsByStatus['progress'] }}</p>
                            <p class="text-xs text-gray-600">{{ $totalTickets > 0 ? round(($ticketsByStatus['progress'] / $totalTickets) * 100) : 0 }}%</p>
                        </div>
                    </div>

                    <!-- Diselesaikan -->
                    <div class="flex items-center justify-between p-3 bg-sky-50 rounded-lg border border-sky-200 border-l-4 border-l-sky-500">
                        <div>
                            <p class="text-sm font-semibold text-gray-700">Diselesaikan</p>
                            <p class="text-xs text-gray-600">Terselesaikan dengan baik</p>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-bold text-sky-600">{{ $ticketsByStatus['resolved'] }}</p>
                            <p class="text-xs text-gray-600">{{ $totalTickets > 0 ? round(($ticketsByStatus['resolved'] / $totalTickets) * 100) : 0 }}%</p>
                        </div>
                    </div>

                    <!-- Ditutup -->
                    <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg border border-slate-200 border-l-4 border-l-slate-500">
                        <div>
                            <p class="text-sm font-semibold text-gray-700">Ditutup</p>
                            <p class="text-xs text-gray-600">Kendala selesai & ditutup</p>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-bold text-slate-600">{{ $ticketsByStatus['closed'] }}</p>
                            <p class="text-xs text-gray-600">{{ $totalTickets > 0 ? round(($ticketsByStatus['closed'] / $totalTickets) * 100) : 0 }}%</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Tickets Table -->
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Tiket Terbaru Saya</h3>
                <a href="{{ route('tickets.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">Lihat Semua →</a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Judul</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kategori</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Penangani</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($recentTickets as $ticket)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 text-sm text-gray-900 font-medium">{{ Str::limit($ticket->subject, 25) }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ Str::limit($ticket->category, 15) }}</td>
                            <td class="px-4 py-3 text-sm">
                                @if($ticket->status === 'open')
                                    <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-semibold">Dibuka</span>
                                @elseif($ticket->status === 'progress')
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded text-xs font-semibold">Sedang Diproses</span>
                                @elseif($ticket->status === 'resolved')
                                    <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs font-semibold">Diselesaikan</span>
                                @else
                                    <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded text-xs font-semibold">Ditutup</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-700">
                                @if($ticket->assigned_to)
                                    <span class="px-2 py-1 bg-blue-50 text-blue-700 rounded text-xs font-medium">{{ $ticket->assignedSupport->name }}</span>
                                @else
                                    <span class="px-2 py-1 bg-gray-100 text-gray-500 rounded text-xs italic">Belum ditangani</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('tickets.show', $ticket->id) }}" class="text-blue-600 hover:text-blue-700 font-medium text-sm">Lihat</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td class="px-4 py-6 text-center text-sm text-gray-500" colspan="5">Anda belum membuat tiket.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
