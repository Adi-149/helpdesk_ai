<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Laporan Helpdesk</h2>
            <div class="flex items-center gap-3">
                <button onclick="window.print()" class="hidden sm:inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white text-sm font-medium rounded-lg shadow transition-all duration-200 print:hidden">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    Cetak Laporan
                </button>
                <svg class="w-8 h-8 text-blue-600 dark:text-blue-400 opacity-30" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
                </svg>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">

        {{-- ============================================= --}}
        {{-- SECTION 1: Summary Cards --}}
        {{-- ============================================= --}}
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 mb-8">
            {{-- Total --}}
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-5 text-white shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="flex flex-col">
                    <p class="text-blue-100 text-xs font-medium uppercase tracking-wider">Total Tiket</p>
                    <p class="text-3xl font-bold mt-1">{{ $totalTickets }}</p>
                </div>
            </div>
            {{-- Open --}}
            <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl p-5 text-white shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="flex flex-col">
                    <p class="text-emerald-100 text-xs font-medium uppercase tracking-wider">Dibuka</p>
                    <p class="text-3xl font-bold mt-1">{{ $ticketsByStatus['open'] }}</p>
                </div>
            </div>
            {{-- Progress --}}
            <div class="bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl p-5 text-white shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="flex flex-col">
                    <p class="text-amber-100 text-xs font-medium uppercase tracking-wider">Diproses</p>
                    <p class="text-3xl font-bold mt-1">{{ $ticketsByStatus['progress'] }}</p>
                </div>
            </div>
            {{-- Resolved --}}
            <div class="bg-gradient-to-br from-sky-500 to-sky-600 rounded-xl p-5 text-white shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="flex flex-col">
                    <p class="text-sky-100 text-xs font-medium uppercase tracking-wider">Diselesaikan</p>
                    <p class="text-3xl font-bold mt-1">{{ $ticketsByStatus['resolved'] }}</p>
                </div>
            </div>
            {{-- Closed --}}
            <div class="col-span-2 md:col-span-1 bg-gradient-to-br from-slate-500 to-slate-600 rounded-xl p-5 text-white shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="flex flex-col">
                    <p class="text-slate-100 text-xs font-medium uppercase tracking-wider">Ditutup</p>
                    <p class="text-3xl font-bold mt-1">{{ $ticketsByStatus['closed'] }}</p>
                </div>
            </div>
        </div>

        {{-- ============================================= --}}
        {{-- SECTION 2: Chart + Category/Priority --}}
        {{-- ============================================= --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            {{-- Monthly Chart --}}
            <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"/><path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"/></svg>
                    Tren Tiket 6 Bulan Terakhir
                </h3>
                <div class="relative" style="height: 280px;">
                    <canvas id="monthlyChart"></canvas>
                </div>
            </div>

            {{-- Category Breakdown --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-purple-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/></svg>
                    Berdasarkan Kategori
                </h3>
                <div class="space-y-3">
                    @php
                        $categoryColors = [
                            'Hardware' => 'blue',
                            'Software' => 'purple',
                            'Jaringan' => 'green',
                            'Akun' => 'orange',
                            'Lainnya' => 'gray',
                        ];
                    @endphp
                    @forelse($ticketsByCategory as $cat)
                        @php
                            $color = $categoryColors[$cat->category] ?? 'gray';
                            $percentage = $totalTickets > 0 ? round(($cat->total / $totalTickets) * 100) : 0;
                        @endphp
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $cat->category }}</span>
                                <span class="text-sm font-bold text-gray-900 dark:text-white">{{ $cat->total }} <span class="text-xs text-gray-400 font-normal">({{ $percentage }}%)</span></span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5">
                                <div class="bg-{{ $color }}-500 h-2.5 rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 dark:text-gray-400 text-center py-4">Belum ada data tiket.</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- ============================================= --}}
        {{-- SECTION 3: Priority + Technician Performance --}}
        {{-- ============================================= --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            {{-- Priority Breakdown --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    Berdasarkan Prioritas
                </h3>
                <div class="space-y-4">
                    {{-- High --}}
                    <div class="flex items-center justify-between p-4 bg-red-50 dark:bg-red-900/20 rounded-lg border-l-4 border-red-500">
                        <div>
                            <p class="text-sm font-semibold text-gray-800 dark:text-gray-200">Prioritas Tinggi</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Urgen dan kritis</p>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-bold text-red-600 dark:text-red-400">{{ $ticketsByPriority['high'] }}</p>
                            <p class="text-xs text-gray-500">{{ $totalTickets > 0 ? round(($ticketsByPriority['high'] / $totalTickets) * 100) : 0 }}%</p>
                        </div>
                    </div>
                    {{-- Medium --}}
                    <div class="flex items-center justify-between p-4 bg-orange-50 dark:bg-orange-900/20 rounded-lg border-l-4 border-orange-500">
                        <div>
                            <p class="text-sm font-semibold text-gray-800 dark:text-gray-200">Prioritas Sedang</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Penting namun tidak segera</p>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-bold text-orange-600 dark:text-orange-400">{{ $ticketsByPriority['medium'] }}</p>
                            <p class="text-xs text-gray-500">{{ $totalTickets > 0 ? round(($ticketsByPriority['medium'] / $totalTickets) * 100) : 0 }}%</p>
                        </div>
                    </div>
                    {{-- Low --}}
                    <div class="flex items-center justify-between p-4 bg-green-50 dark:bg-green-900/20 rounded-lg border-l-4 border-green-500">
                        <div>
                            <p class="text-sm font-semibold text-gray-800 dark:text-gray-200">Prioritas Rendah</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Bisa ditangani kemudian</p>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $ticketsByPriority['low'] }}</p>
                            <p class="text-xs text-gray-500">{{ $totalTickets > 0 ? round(($ticketsByPriority['low'] / $totalTickets) * 100) : 0 }}%</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Technician Performance --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/></svg>
                    Performa Teknisi
                </h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Teknisi</th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Ditangani</th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Proses</th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Selesai</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($supportStaff as $staff)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 bg-gradient-to-br from-indigo-400 to-indigo-600 rounded-full flex items-center justify-center text-white text-xs font-bold">
                                            {{ strtoupper(substr($staff->name, 0, 1)) }}
                                        </div>
                                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $staff->name }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span class="inline-flex items-center justify-center px-2.5 py-1 bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-300 rounded-full text-xs font-bold min-w-[2rem]">{{ $staff->assigned_count }}</span>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span class="inline-flex items-center justify-center px-2.5 py-1 bg-amber-100 dark:bg-amber-900/40 text-amber-700 dark:text-amber-300 rounded-full text-xs font-bold min-w-[2rem]">{{ $staff->progress_count }}</span>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span class="inline-flex items-center justify-center px-2.5 py-1 bg-green-100 dark:bg-green-900/40 text-green-700 dark:text-green-300 rounded-full text-xs font-bold min-w-[2rem]">{{ $staff->resolved_count }}</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-4 py-6 text-center text-sm text-gray-500 dark:text-gray-400">Belum ada staff support.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- ============================================= --}}
        {{-- SECTION 4: Ticket Table with Filters --}}
        {{-- ============================================= --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
            {{-- Filter Bar --}}
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 print:hidden">
                <form method="GET" action="{{ route('admin.reports') }}" id="filterForm">
                    <div class="flex flex-wrap items-end gap-3">
                        <div class="flex-1 min-w-[120px]">
                            <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Status</label>
                            <select name="status" onchange="document.getElementById('filterForm').submit()" class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Semua Status</option>
                                <option value="open" @selected($filterStatus === 'open')>Dibuka</option>
                                <option value="progress" @selected($filterStatus === 'progress')>Diproses</option>
                                <option value="resolved" @selected($filterStatus === 'resolved')>Diselesaikan</option>
                                <option value="closed" @selected($filterStatus === 'closed')>Ditutup</option>
                            </select>
                        </div>
                        <div class="flex-1 min-w-[120px]">
                            <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Prioritas</label>
                            <select name="priority" onchange="document.getElementById('filterForm').submit()" class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Semua Prioritas</option>
                                <option value="high" @selected($filterPriority === 'high')>Tinggi</option>
                                <option value="medium" @selected($filterPriority === 'medium')>Sedang</option>
                                <option value="low" @selected($filterPriority === 'low')>Rendah</option>
                            </select>
                        </div>
                        <div class="flex-1 min-w-[120px]">
                            <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Kategori</label>
                            <select name="category" onchange="document.getElementById('filterForm').submit()" class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat }}" @selected($filterCategory === $cat)>{{ $cat }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex-1 min-w-[130px]">
                            <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Dari Tanggal</label>
                            <input type="date" name="date_from" value="{{ $filterDateFrom }}" onchange="document.getElementById('filterForm').submit()" class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div class="flex-1 min-w-[130px]">
                            <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Sampai Tanggal</label>
                            <input type="date" name="date_to" value="{{ $filterDateTo }}" onchange="document.getElementById('filterForm').submit()" class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        @if($filterStatus || $filterPriority || $filterCategory || $filterDateFrom || $filterDateTo)
                            <a href="{{ route('admin.reports') }}" class="inline-flex items-center gap-1 px-3 py-2 text-sm text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 border border-red-300 dark:border-red-700 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/30 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            {{-- Table Header --}}
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/></svg>
                    Riwayat Tiket
                </h3>
                <span class="text-sm text-gray-500 dark:text-gray-400">{{ $tickets->total() }} tiket ditemukan</span>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-50 dark:bg-gray-700/50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">#</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Judul</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Pelapor</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Kategori</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Prioritas</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Teknisi</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($tickets as $ticket)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 font-mono">{{ $ticket->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                {{ Str::limit($ticket->subject, 35) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                                {{ $ticket->user ? $ticket->user->name : 'Dihapus' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded text-xs font-medium">{{ $ticket->category }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if($ticket->priority === 'high')
                                    <span class="px-2 py-1 bg-red-100 dark:bg-red-900/40 text-red-700 dark:text-red-300 rounded text-xs font-semibold">Tinggi</span>
                                @elseif($ticket->priority === 'medium')
                                    <span class="px-2 py-1 bg-orange-100 dark:bg-orange-900/40 text-orange-700 dark:text-orange-300 rounded text-xs font-semibold">Sedang</span>
                                @else
                                    <span class="px-2 py-1 bg-green-100 dark:bg-green-900/40 text-green-700 dark:text-green-300 rounded text-xs font-semibold">Rendah</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if($ticket->status === 'open')
                                    <span class="inline-flex items-center gap-1 px-2 py-1 bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-300 rounded text-xs font-semibold">
                                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>Dibuka
                                    </span>
                                @elseif($ticket->status === 'progress')
                                    <span class="inline-flex items-center gap-1 px-2 py-1 bg-amber-100 dark:bg-amber-900/40 text-amber-700 dark:text-amber-300 rounded text-xs font-semibold">
                                        <span class="w-1.5 h-1.5 bg-amber-500 rounded-full animate-pulse"></span>Diproses
                                    </span>
                                @elseif($ticket->status === 'resolved')
                                    <span class="inline-flex items-center gap-1 px-2 py-1 bg-sky-100 dark:bg-sky-900/40 text-sky-700 dark:text-sky-300 rounded text-xs font-semibold">
                                        <span class="w-1.5 h-1.5 bg-sky-500 rounded-full"></span>Diselesaikan
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded text-xs font-semibold">
                                        <span class="w-1.5 h-1.5 bg-gray-500 rounded-full"></span>Ditutup
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                                @if($ticket->assigned_to && $ticket->assignedSupport)
                                    <span class="px-2 py-1 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 rounded text-xs">{{ $ticket->assignedSupport->name }}</span>
                                @else
                                    <span class="text-xs text-gray-400 dark:text-gray-500 italic">Belum di-assign</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $ticket->created_at->format('d M Y') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center">
                                <svg class="w-12 h-12 mx-auto text-gray-300 dark:text-gray-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Tidak ada tiket yang sesuai filter.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($tickets->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 print:hidden">
                    {{ $tickets->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- ============================================= --}}
    {{-- Chart.js Script --}}
    {{-- ============================================= --}}
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('monthlyChart').getContext('2d');
            const monthlyData = @json($monthlyData);

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: monthlyData.map(d => d.month),
                    datasets: [
                        {
                            label: 'Total Tiket',
                            data: monthlyData.map(d => d.total),
                            backgroundColor: 'rgba(59, 130, 246, 0.7)',
                            borderColor: 'rgba(59, 130, 246, 1)',
                            borderWidth: 1,
                            borderRadius: 6,
                            borderSkipped: false,
                        },
                        {
                            label: 'Selesai',
                            data: monthlyData.map(d => d.resolved),
                            backgroundColor: 'rgba(16, 185, 129, 0.7)',
                            borderColor: 'rgba(16, 185, 129, 1)',
                            borderWidth: 1,
                            borderRadius: 6,
                            borderSkipped: false,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true,
                                pointStyle: 'circle',
                                font: { size: 12 }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                font: { size: 11 }
                            },
                            grid: {
                                color: 'rgba(0,0,0,0.05)'
                            }
                        },
                        x: {
                            ticks: {
                                font: { size: 11 }
                            },
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        });
    </script>
    @endpush

    {{-- ============================================= --}}
    {{-- Print Styles --}}
    {{-- ============================================= --}}
    <style>
        @media print {
            nav, .print\:hidden { display: none !important; }
            body { background: white !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .shadow-lg, .shadow { box-shadow: none !important; }
            .rounded-xl { border-radius: 8px !important; border: 1px solid #e5e7eb; }
            canvas { max-height: 200px !important; }
        }
    </style>
</x-app-layout>
