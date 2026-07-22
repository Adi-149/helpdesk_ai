<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Knowledge Base</h2>
                <p class="text-sm text-gray-500 mt-1">Kelola pengetahuan internal Pondok Pesantren Sunan Drajat</p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('admin.knowledge-base.statistics') }}" class="inline-flex items-center px-4 py-2 bg-white hover:bg-gray-50 text-gray-700 text-xs font-bold rounded-lg shadow-sm border border-gray-300 transition-all duration-200">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    Statistik
                </a>
                <a href="{{ route('admin.knowledge-base.logs') }}" class="inline-flex items-center px-4 py-2 bg-white hover:bg-gray-50 text-gray-700 text-xs font-bold rounded-lg shadow-sm border border-gray-300 transition-all duration-200">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Riwayat
                </a>
                <a href="{{ route('admin.knowledge-base.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-lg shadow-sm transition-all duration-200">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Tambah Knowledge
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        {{-- Status Messages --}}
        @if (session('status'))
            <div class="mb-4 p-4 rounded-lg bg-green-50 border border-green-200 text-green-700 text-sm font-medium">
                {{ session('status') }}
            </div>
        @endif

        {{-- Summary Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
            <div class="bg-white border border-gray-200 border-l-4 border-l-blue-600 rounded-lg p-5 shadow-sm">
                <p class="text-blue-700 text-xs font-semibold uppercase tracking-wider">Total Knowledge</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalKnowledge }}</p>
            </div>
            <div class="bg-white border border-gray-200 border-l-4 border-l-green-600 rounded-lg p-5 shadow-sm">
                <p class="text-green-700 text-xs font-semibold uppercase tracking-wider">Aktif</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ $activeKnowledge }}</p>
            </div>
            <div class="bg-white border border-gray-200 border-l-4 border-l-red-500 rounded-lg p-5 shadow-sm">
                <p class="text-red-600 text-xs font-semibold uppercase tracking-wider">Nonaktif</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalKnowledge - $activeKnowledge }}</p>
            </div>
        </div>

        {{-- Filter & Search --}}
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4 mb-6">
            <form method="GET" action="{{ route('admin.knowledge-base.index') }}" class="flex flex-wrap gap-3 items-end">
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Cari</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul, kata kunci, atau isi..." class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="w-40">
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Kategori</label>
                    <select name="category" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
                        <option value="">Semua</option>
                        @foreach(\App\Models\KnowledgeBase::CATEGORIES as $key => $label)
                            <option value="{{ $key }}" {{ request('category') === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="w-36">
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Akses</label>
                    <select name="access_level" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
                        <option value="">Semua</option>
                        @foreach(\App\Models\KnowledgeBase::ACCESS_LEVELS as $key => $label)
                            <option value="{{ $key }}" {{ request('access_level') === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="w-32">
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Status</label>
                    <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
                        <option value="">Semua</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-lg transition-all">
                        Filter
                    </button>
                    <a href="{{ route('admin.knowledge-base.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition-all">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        {{-- Data Table --}}
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Judul</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Kategori</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Akses</th>
                            <th class="px-4 py-3 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Diperbarui</th>
                            <th class="px-4 py-3 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($knowledgeItems as $item)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3">
                                    <div class="text-sm font-semibold text-gray-900">{{ $item->title }}</div>
                                    <div class="text-xs text-gray-500 mt-0.5 truncate max-w-xs">{{ Str::limit($item->keywords, 50) }}</div>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold
                                        @switch($item->category)
                                            @case('wifi') @case('jaringan') bg-blue-100 text-blue-800 @break
                                            @case('perangkat') @case('server') bg-purple-100 text-purple-800 @break
                                            @case('sop') bg-amber-100 text-amber-800 @break
                                            @case('faq') bg-green-100 text-green-800 @break
                                            @case('lokasi') @case('unit_usaha') bg-teal-100 text-teal-800 @break
                                            @case('pendidikan') bg-indigo-100 text-indigo-800 @break
                                            @case('kontak') bg-pink-100 text-pink-800 @break
                                            @default bg-gray-100 text-gray-800
                                        @endswitch
                                    ">
                                        {{ \App\Models\KnowledgeBase::CATEGORIES[$item->category] ?? $item->category }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold
                                        {{ $item->access_level === 'admin' ? 'bg-red-100 text-red-800' : ($item->access_level === 'teknisi' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}
                                    ">
                                        {{ \App\Models\KnowledgeBase::ACCESS_LEVELS[$item->access_level] ?? $item->access_level }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <form method="POST" action="{{ route('admin.knowledge-base.toggle', $item->id) }}" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" title="{{ $item->is_active ? 'Klik untuk nonaktifkan' : 'Klik untuk aktifkan' }}" class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 {{ $item->is_active ? 'bg-blue-600' : 'bg-gray-300' }}">
                                            <span class="inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $item->is_active ? 'translate-x-5' : 'translate-x-0' }}"></span>
                                        </button>
                                    </form>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="text-xs text-gray-600">{{ $item->updated_at->format('d M Y') }}</div>
                                    <div class="text-xs text-gray-400">{{ $item->updated_at->format('H:i') }}</div>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin.knowledge-base.edit', $item->id) }}" class="text-blue-600 hover:text-blue-800 transition-colors" title="Edit">
                                            <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                        <form method="POST" action="{{ route('admin.knowledge-base.destroy', $item->id) }}" class="inline" onsubmit="return confirm('Yakin ingin menghapus knowledge ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 transition-colors" title="Hapus">
                                                <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-12 text-center">
                                    <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                    <p class="text-sm text-gray-500 font-medium">Belum ada data knowledge base.</p>
                                    <a href="{{ route('admin.knowledge-base.create') }}" class="inline-flex items-center mt-3 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-lg transition-all">
                                        Tambah Knowledge Pertama
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($knowledgeItems->hasPages())
                <div class="px-4 py-3 border-t border-gray-200 bg-gray-50">
                    {{ $knowledgeItems->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
