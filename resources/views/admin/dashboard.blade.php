<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Kelola Pengguna</h2>
            <div class="flex items-center gap-4">
                <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-lg shadow-sm transition-all duration-200">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                    Tambah Pengguna Baru
                </a>
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
            <div class="bg-white border border-gray-200 border-l-4 border-l-blue-600 rounded-lg p-6 shadow-sm">
                <div class="flex flex-col">
                    <p class="text-blue-700 text-xs font-semibold uppercase tracking-wider">Total Pengguna</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $users->count() + $supportStaff->count() }}</p>
                </div>
            </div>

            <div class="bg-white border border-gray-200 border-l-4 border-l-green-600 rounded-lg p-6 shadow-sm">
                <div class="flex flex-col">
                    <p class="text-green-700 text-xs font-semibold uppercase tracking-wider">Pengguna Biasa</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $users->count() }}</p>
                </div>
            </div>

            <div class="bg-white border border-gray-200 border-l-4 border-l-purple-600 rounded-lg p-6 shadow-sm">
                <div class="flex flex-col">
                    <p class="text-purple-700 text-xs font-semibold uppercase tracking-wider">Staff Support</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $supportStaff->count() }}</p>
                </div>
            </div>

            <div class="bg-white border border-gray-200 border-l-4 border-l-red-600 rounded-lg p-6 shadow-sm cursor-pointer" onclick="window.location.href='{{ route('tickets.index') }}'">
                <div class="flex flex-col">
                    <p class="text-red-700 text-xs font-semibold uppercase tracking-wider">Total Tiket</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalTickets }}</p>
                </div>
            </div>
        </div>

        <!-- Statistik & Laporan -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
            <!-- Status Breakdown -->
            <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4 flex items-center gap-1.5">
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
                                <span class="font-semibold text-gray-700">{{ $lbl }}</span>
                                <span class="font-extrabold text-gray-900">{{ $count }} <span class="text-gray-400 font-normal">({{ $percentages }}%)</span></span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-{{ $color }}-500 h-2 rounded-full transition-all duration-500" style="width: {{ $percentages }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Priority Breakdown -->
            <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4 flex items-center gap-1.5">
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
                                <span class="font-semibold text-gray-700">{{ $lbl }}</span>
                                <span class="font-extrabold text-gray-900">{{ $count }} <span class="text-gray-400 font-normal">({{ $percentages }}%)</span></span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-{{ $color }}-500 h-2 rounded-full transition-all duration-500" style="width: {{ $percentages }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Category & Reports Box -->
            <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200 flex flex-col justify-between">
                <div>
                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4 flex items-center gap-1.5">
                        <span class="w-1.5 h-4 bg-blue-500 rounded"></span> Top Kategori
                    </h3>
                    <div class="space-y-2 text-xs">
                        @foreach($categoryCounts as $catName => $count)
                            @php
                                $percentages = $totalTickets > 0 ? round(($count / $totalTickets) * 100) : 0;
                            @endphp
                            <div class="flex items-center justify-between py-1 border-b border-gray-100">
                                <span class="text-gray-600">{{ $catName }}</span>
                                <span class="font-bold text-gray-800">{{ $count }} tiket ({{ $percentages }}%)</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mt-4 pt-3 border-t border-gray-100">
                    <a href="{{ route('admin.reports') }}" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-lg shadow-sm transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Lihat Laporan Lengkap
                    </a>
                </div>
            </div>
        </div>

        <!-- Pengguna Biasa -->
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm mb-6">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg font-medium leading-6 text-gray-900">
                    Pengguna Biasa
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Role</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($users as $user)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $user->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $user->email }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <form method="POST" action="{{ route('admin.users.update-role', $user) }}" class="flex gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <select name="role" onchange="this.form.submit()" class="px-2 py-1 border border-gray-300 rounded bg-white text-gray-950 text-sm focus:border-blue-500 focus:ring-blue-500">
                                            <option value="user" @selected($user->role === 'user')>Pengguna Biasa</option>
                                            <option value="support" @selected($user->role === 'support')>Teknisi</option>
                                        </select>
                                    </form>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                                    <form method="POST" action="{{ route('admin.users.delete', $user) }}" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 font-medium">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                    Tidak ada pengguna biasa
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Staff Support -->
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm mb-6">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg font-medium leading-6 text-gray-900">
                    Staff Support
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Role</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($supportStaff as $staff)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $staff->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $staff->email }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <form method="POST" action="{{ route('admin.users.update-role', $staff) }}" class="flex gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <select name="role" onchange="this.form.submit()" class="px-2 py-1 border border-gray-300 rounded bg-white text-gray-950 text-sm focus:border-blue-500 focus:ring-blue-500">
                                            <option value="user" @selected($staff->role === 'user')>Pengguna Biasa</option>
                                            <option value="support" @selected($staff->role === 'support')>Teknisi</option>
                                        </select>
                                    </form>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                                    <form method="POST" action="{{ route('admin.users.delete', $staff) }}" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 font-medium">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                    Tidak ada staff support
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Admin List -->
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg font-medium leading-6 text-gray-900">
                    Admin
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Role</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($admins as $admin)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $admin->name }} @if($admin->id === auth()->id())<span class="text-xs bg-red-100 text-red-800 px-2 py-1 rounded">(Anda)</span>@endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $admin->email }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span class="px-2 py-1 bg-red-100 text-red-800 rounded text-xs font-medium">
                                        Admin
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">
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
