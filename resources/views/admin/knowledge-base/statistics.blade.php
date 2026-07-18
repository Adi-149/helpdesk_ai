<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Statistik Knowledge Base</h2>
                <p class="text-sm text-gray-500 mt-1">Metrik dan tinjauan umum data pengetahuan Pondok Pesantren Sunan Drajat</p>
            </div>
            <a href="{{ route('admin.knowledge-base.index') }}" class="inline-flex items-center px-4 py-2 bg-white hover:bg-gray-50 text-gray-700 text-xs font-bold rounded-lg shadow-sm border border-gray-300 transition-all duration-200">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        {{-- Overview Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-6">
            <div class="bg-white border border-gray-200 border-l-4 border-l-blue-600 rounded-lg p-6 shadow-sm">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-50 text-blue-600 rounded-lg mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Data Knowledge</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalKnowledge }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white border border-gray-200 border-l-4 border-l-green-600 rounded-lg p-6 shadow-sm">
                <div class="flex items-center">
                    <div class="p-3 bg-green-50 text-green-600 rounded-lg mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Knowledge Aktif</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">{{ $activeKnowledge }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white border border-gray-200 border-l-4 border-l-red-500 rounded-lg p-6 shadow-sm">
                <div class="flex items-center">
                    <div class="p-3 bg-red-50 text-red-500 rounded-lg mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Knowledge Nonaktif</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">{{ $inactiveKnowledge }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            {{-- Per Kategori --}}
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wider">Penyebaran Per Kategori</h3>
                </div>
                <div class="p-6 space-y-4">
                    @foreach($categoryCounts as $key => $data)
                        @php
                            $percentage = $totalKnowledge > 0 ? round(($data['count'] / $totalKnowledge) * 100) : 0;
                        @endphp
                        <div>
                            <div class="flex justify-between items-center text-sm font-medium mb-1">
                                <span class="text-gray-700">{{ $data['label'] }}</span>
                                <span class="text-gray-900 font-bold">{{ $data['count'] }} ({{ $percentage }}%)</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Per Hak Akses --}}
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden flex flex-col justify-between">
                <div>
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wider">Penyebaran Per Tingkat Akses</h3>
                    </div>
                    <div class="p-6 space-y-5">
                        @foreach($accessCounts as $key => $data)
                            @php
                                $percentage = $totalKnowledge > 0 ? round(($data['count'] / $totalKnowledge) * 100) : 0;
                                $color = $key === 'admin' ? 'bg-red-500' : ($key === 'teknisi' ? 'bg-yellow-500' : 'bg-green-500');
                            @endphp
                            <div>
                                <div class="flex justify-between items-center text-sm font-medium mb-1">
                                    <span class="text-gray-700">{{ $data['label'] }}</span>
                                    <span class="text-gray-900 font-bold">{{ $data['count'] }} ({{ $percentage }}%)</span>
                                </div>
                                <div class="w-full bg-gray-100 rounded-full h-2.5">
                                    <div class="{{ $color }} h-2.5 rounded-full" style="width: {{ $percentage }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Access Description --}}
                <div class="p-6 border-t border-gray-200 bg-gray-50">
                    <h4 class="text-xs font-bold text-gray-600 uppercase mb-2">Penjelasan Hak Akses:</h4>
                    <ul class="text-xs text-gray-600 space-y-1.5 list-disc pl-4 font-semibold">
                        <li><strong class="text-green-600">User:</strong> Informasi umum, FAQ, lokasi, dll. Bisa diakses semua orang.</li>
                        <li><strong class="text-yellow-600">Teknisi:</strong> Informasi teknis, jaringan, server, password WiFi, detail perangkat.</li>
                        <li><strong class="text-red-500">Admin:</strong> Kunci credentials, detail rahasia server tingkat tinggi.</li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Aktivitas Terakhir --}}
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wider">Aktivitas Perubahan Terbaru</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Waktu</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Admin</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Aksi</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Knowledge Base</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($recentLogs as $log)
                            <tr class="text-sm hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-3 text-gray-600 whitespace-nowrap">
                                    {{ $log->created_at->format('d M Y H:i') }}
                                </td>
                                <td class="px-6 py-3 font-semibold text-gray-900 whitespace-nowrap">
                                    {{ $log->user->name ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-3 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold
                                        @switch($log->action)
                                            @case('create') bg-green-100 text-green-800 @break
                                            @case('update') bg-blue-100 text-blue-800 @break
                                            @case('delete') bg-red-100 text-red-800 @break
                                            @default bg-gray-100 text-gray-800
                                        @endswitch
                                    ">
                                        {{ strtoupper($log->action) }}
                                    </span>
                                </td>
                                <td class="px-6 py-3">
                                    @if($log->action === 'delete')
                                        <span class="text-gray-500 italic">{{ $log->old_data['title'] ?? 'N/A' }}</span>
                                    @else
                                        <span class="font-semibold text-gray-900">{{ $log->knowledgeBase->title ?? ($log->new_data['title'] ?? 'N/A') }}</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-6 text-center text-gray-500">
                                    Belum ada aktivitas terbaru.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-3 border-t border-gray-200 bg-gray-50 text-right">
                <a href="{{ route('admin.knowledge-base.logs') }}" class="text-xs font-bold text-blue-600 hover:text-blue-800 flex items-center justify-end space-x-1">
                    <span>Lihat Riwayat Lengkap</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
