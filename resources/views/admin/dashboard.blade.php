<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Kelola Pengguna</h2>
            <div class="flex items-center gap-4">
                <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-lg shadow transition-all duration-200">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                    Tambah Pengguna Baru
                </a>
                <svg class="w-8 h-8 text-red-600 dark:text-red-400 opacity-30" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z"/>
                </svg>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <!-- Status Messages -->
        @if (session('status'))
            <div class="mb-4 p-4 rounded bg-green-50 border border-green-200 text-green-700">
                {{ session('status') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 p-4 rounded bg-red-50 border border-red-200 text-red-700">
                {{ session('error') }}
            </div>
        @endif

        <!-- Admin Summary -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg p-6 text-white shadow-lg">
                <div class="flex items-end justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-medium">Total Pengguna</p>
                        <p class="text-4xl font-bold">{{ $users->count() + $supportStaff->count() }}</p>
                    </div>
                    <svg class="w-12 h-12 opacity-20" fill="currentColor" viewBox="0 0 20 20"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM9 12a9 9 0 1-18 0 9 9 0 0118 0zm-9-4a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
            </div>

            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg p-6 text-white shadow-lg">
                <div class="flex items-end justify-between">
                    <div>
                        <p class="text-green-100 text-sm font-medium">Pengguna Biasa</p>
                        <p class="text-4xl font-bold">{{ $users->count() }}</p>
                    </div>
                    <svg class="w-12 h-12 opacity-20" fill="currentColor" viewBox="0 0 20 20"><path d="M10.5 1.5H3.75A2.25 2.25 0 001.5 3.75v12.5A2.25 2.25 0 003.75 18.5h12.5a2.25 2.25 0 002.25-2.25V9.5m-15-4h12m-12 4v8m12-8v8m0-8h4.5"/></svg>
                </div>
            </div>

            <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg p-6 text-white shadow-lg">
                <div class="flex items-end justify-between">
                    <div>
                        <p class="text-purple-100 text-sm font-medium">Staff Support</p>
                        <p class="text-4xl font-bold">{{ $supportStaff->count() }}</p>
                    </div>
                    <svg class="w-12 h-12 opacity-20" fill="currentColor" viewBox="0 0 24 24"><path d="M18 8C18 5.24 15.76 3 13 3H11C8.24 3 6 5.24 6 8V12C6 14.76 8.24 17 11 17H12V20C12 21.1 11.1 22 10 22C8.9 22 8 21.1 8 20V18H16V20C16 21.1 15.1 22 14 22C12.9 22 12 21.1 12 20V17H13C15.76 17 18 14.76 18 12V8Z"/></svg>
                </div>
            </div>

            <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-lg p-6 text-white shadow-lg cursor-pointer" onclick="window.location.href='{{ route('tickets.index') }}'">
                <div class="flex items-end justify-between">
                    <div>
                        <p class="text-red-100 text-sm font-medium">Total Tiket</p>
                        <p class="text-4xl font-bold">{{ $totalTickets }}</p>
                    </div>
                    <svg class="w-12 h-12 opacity-20" fill="currentColor" viewBox="0 0 20 20"><path d="M5 3a2 2 0 012-2h6a2 2 0 012 2v6h4a2 2 0 012 2v5a2 2 0 01-2 2H3a2 2 0 01-2-2v-5a2 2 0 012-2h4V3z"/></svg>
                </div>
            </div>
        </div>

        <!-- Statistik & Laporan (test.md) -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
            <!-- Status Breakdown -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 border border-gray-100 dark:border-gray-700/50">
                <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider mb-4 flex items-center gap-1.5">
                    <span class="w-1.5 h-4 bg-emerald-500 rounded"></span> Statistik Status
                </h3>
                <div class="space-y-3.5">
                    @foreach($statusCounts as $statusName => $count)
                        @php
                            $percentages = $totalTickets > 0 ? round(($count / $totalTickets) * 100) : 0;
                            $labels = ['open' => 'Dibuka', 'progress' => 'Diproses', 'resolved' => 'Diselesaikan', 'closed' => 'Ditutup'];
                            $colors = ['open' => 'emerald', 'progress' => 'amber', 'resolved' => 'sky', 'closed' => 'slate'];
                            $lbl = $labels[$statusName] ?? $statusName;
                            $color = $colors[$statusName] ?? 'gray';
                        @endphp
                        <div>
                            <div class="flex items-center justify-between mb-1 text-xs">
                                <span class="font-semibold text-gray-700 dark:text-gray-300">{{ $lbl }}</span>
                                <span class="font-extrabold text-gray-900 dark:text-white">{{ $count }} <span class="text-gray-400 font-normal">({{ $percentages }}%)</span></span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                <div class="bg-{{ $color }}-500 h-2 rounded-full transition-all duration-500" style="width: {{ $percentages }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Priority Breakdown -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 border border-gray-100 dark:border-gray-700/50">
                <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider mb-4 flex items-center gap-1.5">
                    <span class="w-1.5 h-4 bg-red-500 rounded"></span> Statistik Prioritas
                </h3>
                <div class="space-y-3.5">
                    @foreach($priorityCounts as $priorityName => $count)
                        @php
                            $percentages = $totalTickets > 0 ? round(($count / $totalTickets) * 100) : 0;
                            $labels = ['high' => 'Prioritas Tinggi', 'medium' => 'Prioritas Sedang', 'low' => 'Prioritas Rendah'];
                            $colors = ['high' => 'red', 'medium' => 'orange', 'low' => 'green'];
                            $lbl = $labels[$priorityName] ?? $priorityName;
                            $color = $colors[$priorityName] ?? 'gray';
                        @endphp
                        <div>
                            <div class="flex items-center justify-between mb-1 text-xs">
                                <span class="font-semibold text-gray-700 dark:text-gray-300">{{ $lbl }}</span>
                                <span class="font-extrabold text-gray-900 dark:text-white">{{ $count }} <span class="text-gray-400 font-normal">({{ $percentages }}%)</span></span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                <div class="bg-{{ $color }}-500 h-2 rounded-full transition-all duration-500" style="width: {{ $percentages }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Category & Reports Box -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 border border-gray-100 dark:border-gray-700/50 flex flex-col justify-between">
                <div>
                    <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider mb-4 flex items-center gap-1.5">
                        <span class="w-1.5 h-4 bg-indigo-500 rounded"></span> Top Kategori
                    </h3>
                    <div class="space-y-2 text-xs">
                        @foreach($categoryCounts as $catName => $count)
                            @php
                                $percentages = $totalTickets > 0 ? round(($count / $totalTickets) * 100) : 0;
                            @endphp
                            <div class="flex items-center justify-between py-1 border-b border-gray-50 dark:border-gray-700">
                                <span class="text-gray-600 dark:text-gray-400">{{ $catName }}</span>
                                <span class="font-bold text-gray-800 dark:text-gray-200">{{ $count }} tiket ({{ $percentages }}%)</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mt-4 pt-3 border-t border-gray-100 dark:border-gray-700">
                    <a href="{{ route('admin.reports') }}" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-700 hover:to-blue-700 text-white text-sm font-bold rounded-lg shadow transition-all duration-200 hover:scale-[1.01] active:scale-95">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Lihat Laporan Lengkap
                    </a>
                </div>
            </div>
        </div>

        <!-- Pengguna Biasa -->
        <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg mb-6">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white">
                    Pengguna Biasa
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">Role</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($users as $user)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $user->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                                    {{ $user->email }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <form method="POST" action="{{ route('admin.users.update-role', $user) }}" class="flex gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <select name="role" onchange="this.form.submit()" class="px-2 py-1 border border-gray-300 dark:border-gray-600 rounded dark:bg-gray-700 dark:text-white text-sm">
                                            <option value="user" @selected($user->role === 'user')>Pengguna Biasa</option>
                                            <option value="support" @selected($user->role === 'support')>Teknisi</option>
                                        </select>
                                    </form>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                                    <form method="POST" action="{{ route('admin.users.delete', $user) }}" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300 font-medium">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                    Tidak ada pengguna biasa
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Staff Support -->
        <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg mb-6">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white">
                    Staff Support
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">Role</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($supportStaff as $staff)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $staff->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                                    {{ $staff->email }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <form method="POST" action="{{ route('admin.users.update-role', $staff) }}" class="flex gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <select name="role" onchange="this.form.submit()" class="px-2 py-1 border border-gray-300 dark:border-gray-600 rounded dark:bg-gray-700 dark:text-white text-sm">
                                            <option value="user" @selected($staff->role === 'user')>Pengguna Biasa</option>
                                            <option value="support" @selected($staff->role === 'support')>Teknisi</option>
                                        </select>
                                    </form>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                                    <form method="POST" action="{{ route('admin.users.delete', $staff) }}" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300 font-medium">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                    Tidak ada staff support
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Admin List -->
        <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white">
                    Admin
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">Role</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($admins as $admin)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $admin->name }} @if($admin->id === auth()->id())<span class="text-xs bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 px-2 py-1 rounded">(Anda)</span>@endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                                    {{ $admin->email }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span class="px-2 py-1 bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 rounded text-xs font-medium">
                                        Admin
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                    Tidak ada admin
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
