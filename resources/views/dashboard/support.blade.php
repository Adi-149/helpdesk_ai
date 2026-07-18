<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dasbor IT Teknisi</h2>
            <svg class="w-8 h-8 text-blue-600 opacity-20" fill="currentColor" viewBox="0 0 24 24">
                <path d="M18 8C18 5.24 15.76 3 13 3H11C8.24 3 6 5.24 6 8V12C6 14.76 8.24 17 11 17H12V20C12 21.1 11.1 22 10 22C8.9 22 8 21.1 8 20V18H16V20C16 21.1 15.1 22 14 22C12.9 22 12 21.1 12 20V17H13C15.76 17 18 14.76 18 12V8Z"/>
            </svg>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <!-- Top Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <!-- Total Tiket -->
            <div class="bg-white border border-gray-200 border-l-4 border-l-purple-600 rounded-lg p-6 shadow-sm">
                <div class="flex flex-col">
                    <p class="text-purple-700 text-xs font-semibold uppercase tracking-wider">Total Tiket</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalTickets }}</p>
                </div>
            </div>

            <!-- Belum Ditangani -->
            <div class="bg-white border border-gray-200 border-l-4 border-l-red-600 rounded-lg p-6 shadow-sm">
                <div class="flex flex-col">
                    <p class="text-red-700 text-xs font-semibold uppercase tracking-wider">Belum Ditangani</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $unassignedTickets }}</p>
                </div>
            </div>

            <!-- Sedang Diproses -->
            <div class="bg-white border border-gray-200 border-l-4 border-l-amber-500 rounded-lg p-6 shadow-sm">
                <div class="flex flex-col">
                    <p class="text-amber-700 text-xs font-semibold uppercase tracking-wider">Sedang Diproses</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $ticketsByStatus['progress'] }}</p>
                </div>
            </div>

            <!-- Selesai (Resolved) -->
            <div class="bg-white border border-gray-200 border-l-4 border-l-green-600 rounded-lg p-6 shadow-sm">
                <div class="flex flex-col">
                    <p class="text-green-700 text-xs font-semibold uppercase tracking-wider">Selesai</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $ticketsByStatus['resolved'] }}</p>
                </div>
            </div>
        </div>

        <!-- Status & Priority & Category Box -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
            <!-- Status Breakdown -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Status Tiket</h3>
                <div class="space-y-4">
                    <!-- Open -->
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

                    <!-- In Progress -->
                    <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-lg border border-yellow-200 border-l-4 border-l-yellow-500">
                        <div>
                            <p class="text-sm font-semibold text-gray-700">Sedang Diproses</p>
                            <p class="text-xs text-gray-600">Sedang ditangani teknisi</p>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-bold text-yellow-600">{{ $ticketsByStatus['progress'] }}</p>
                            <p class="text-xs text-gray-600">{{ $totalTickets > 0 ? round(($ticketsByStatus['progress'] / $totalTickets) * 100) : 0 }}%</p>
                        </div>
                    </div>

                    <!-- Resolved -->
                    <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg border border-blue-200 border-l-4 border-l-blue-500">
                        <div>
                            <p class="text-sm font-semibold text-gray-700">Diselesaikan</p>
                            <p class="text-xs text-gray-600">Terselesaikan dengan baik</p>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-bold text-blue-600">{{ $ticketsByStatus['resolved'] }}</p>
                            <p class="text-xs text-gray-600">{{ $totalTickets > 0 ? round(($ticketsByStatus['resolved'] / $totalTickets) * 100) : 0 }}%</p>
                        </div>
                    </div>

                    <!-- Closed -->
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-200 border-l-4 border-l-gray-500">
                        <div>
                            <p class="text-sm font-semibold text-gray-700">Ditutup</p>
                            <p class="text-xs text-gray-600">Selesai dan ditutup</p>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-bold text-gray-600">{{ $ticketsByStatus['closed'] }}</p>
                            <p class="text-xs text-gray-600">{{ $totalTickets > 0 ? round(($ticketsByStatus['closed'] / $totalTickets) * 100) : 0 }}%</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Priority Breakdown -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Prioritas Tiket</h3>
                <div class="space-y-4">
                    <!-- High -->
                    <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg border border-red-200 border-l-4 border-l-red-500">
                        <div>
                            <p class="text-sm font-semibold text-gray-700">Prioritas Tinggi</p>
                            <p class="text-xs text-gray-600">Urgen dan kritis</p>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-bold text-red-600">{{ $ticketsByPriority['high'] }}</p>
                            <p class="text-xs text-gray-600">{{ $totalTickets > 0 ? round(($ticketsByPriority['high'] / $totalTickets) * 100) : 0 }}%</p>
                        </div>
                    </div>

                    <!-- Medium -->
                    <div class="flex items-center justify-between p-3 bg-orange-50 rounded-lg border border-orange-200 border-l-4 border-l-orange-500">
                        <div>
                            <p class="text-sm font-semibold text-gray-700">Prioritas Sedang</p>
                            <p class="text-xs text-gray-600">Penting namun tidak segera</p>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-bold text-orange-600">{{ $ticketsByPriority['medium'] }}</p>
                            <p class="text-xs text-gray-600">{{ $totalTickets > 0 ? round(($ticketsByPriority['medium'] / $totalTickets) * 100) : 0 }}%</p>
                        </div>
                    </div>

                    <!-- Low -->
                    <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg border border-green-200 border-l-4 border-l-green-500">
                        <div>
                            <p class="text-sm font-semibold text-gray-700">Prioritas Rendah</p>
                            <p class="text-xs text-gray-600">Bisa ditangani kemudian</p>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-bold text-green-600">{{ $ticketsByPriority['low'] }}</p>
                            <p class="text-xs text-gray-600">{{ $totalTickets > 0 ? round(($ticketsByPriority['low'] / $totalTickets) * 100) : 0 }}%</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Category Breakdown -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Kategori Tiket</h3>
                <div class="space-y-4">
                    @php
                        $categoryStyles = [
                            'Hardware POS' => ['bg' => 'bg-blue-50', 'border' => 'border-blue-500', 'border-inner' => 'border-blue-200', 'text' => 'text-blue-600'],
                            'Printer Thermal' => ['bg' => 'bg-indigo-50', 'border' => 'border-indigo-500', 'border-inner' => 'border-indigo-200', 'text' => 'text-indigo-600'],
                            'Barcode Scanner' => ['bg' => 'bg-pink-50', 'border' => 'border-pink-500', 'border-inner' => 'border-pink-200', 'text' => 'text-pink-600'],
                            'Jaringan & Internet' => ['bg' => 'bg-green-50', 'border' => 'border-green-500', 'border-inner' => 'border-green-200', 'text' => 'text-green-600'],
                            'CCTV' => ['bg' => 'bg-yellow-50', 'border' => 'border-yellow-500', 'border-inner' => 'border-yellow-200', 'text' => 'text-yellow-600'],
                            'Software POS' => ['bg' => 'bg-purple-50', 'border' => 'border-purple-500', 'border-inner' => 'border-purple-200', 'text' => 'text-purple-600'],
                            'Server & Database' => ['bg' => 'bg-red-50', 'border' => 'border-red-500', 'border-inner' => 'border-red-200', 'text' => 'text-red-600'],
                        ];
                    @endphp
                    @foreach($ticketsByCategory as $catName => $catCount)
                        @php
                            $style = $categoryStyles[$catName] ?? ['bg' => 'bg-gray-50', 'border' => 'border-gray-500', 'border-inner' => 'border-gray-200', 'text' => 'text-gray-600'];
                        @endphp
                        <div class="flex items-center justify-between p-3 {{ $style['bg'] }} rounded-lg border {{ $style['border-inner'] }} border-l-4 {{ $style['border'] }}">
                            <div>
                                <p class="text-sm font-semibold text-gray-700">{{ $catName }}</p>
                                <p class="text-xs text-gray-600">Masalah terkait {{ $catName }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-2xl font-bold {{ $style['text'] }}">{{ $catCount }}</p>
                                <p class="text-xs text-gray-600">{{ $totalTickets > 0 ? round(($catCount / $totalTickets) * 100) : 0 }}%</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Recent Tickets Table -->
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Tiket Terbaru</h3>
                <a href="{{ route('support.tickets') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">Lihat Semua →</a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">User</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Judul</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Prioritas</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Di-assign</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($recentTickets as $ticket)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 text-sm text-gray-900 font-medium">{{ $ticket->user->name }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ Str::limit($ticket->subject, 30) }}</td>
                            <td class="px-4 py-3 text-sm">
                                @if($ticket->priority === 'high')
                                    <span class="px-2 py-1 bg-red-100 text-red-700 rounded text-xs font-semibold">Tinggi</span>
                                @elseif($ticket->priority === 'medium')
                                    <span class="px-2 py-1 bg-orange-100 text-orange-700 rounded text-xs font-semibold">Sedang</span>
                                @else
                                    <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-semibold">Rendah</span>
                                @endif
                            </td>
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
                            <td class="px-4 py-6 text-center text-sm text-gray-500" colspan="6">Tidak ada tiket.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
