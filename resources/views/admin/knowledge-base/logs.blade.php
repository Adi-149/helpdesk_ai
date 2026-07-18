<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Riwayat Perubahan Knowledge Base</h2>
                <p class="text-sm text-gray-500 mt-1">Audit log aktivitas perubahan data oleh admin</p>
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
        {{-- Filter --}}
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4 mb-6">
            <form method="GET" action="{{ route('admin.knowledge-base.logs') }}" class="flex items-end gap-3">
                <div class="w-48">
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Aktivitas</label>
                    <select name="action" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
                        <option value="">Semua</option>
                        <option value="create" {{ request('action') === 'create' ? 'selected' : '' }}>Create (Tambah)</option>
                        <option value="update" {{ request('action') === 'update' ? 'selected' : '' }}>Update (Ubah)</option>
                        <option value="delete" {{ request('action') === 'delete' ? 'selected' : '' }}>Delete (Hapus)</option>
                    </select>
                </div>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-lg transition-all">
                    Filter
                </button>
                <a href="{{ route('admin.knowledge-base.logs') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition-all">
                    Reset
                </a>
            </form>
        </div>

        {{-- Log Table --}}
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Waktu</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Admin</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Aktivitas</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Knowledge Base</th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">Detail Perubahan</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($logs as $log)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $log->created_at->format('d M Y H:i:s') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-semibold text-gray-900">{{ $log->user->name ?? 'N/A' }}</div>
                                    <div class="text-xs text-gray-500">{{ $log->user->email ?? '' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold
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
                                <td class="px-6 py-4">
                                    @if($log->action === 'delete')
                                        <span class="text-sm text-gray-500 italic">{{ $log->old_data['title'] ?? 'Data Dihapus' }} (ID: {{ $log->old_data['id'] ?? '' }})</span>
                                    @else
                                        <div class="text-sm font-semibold text-gray-900">
                                            @if($log->knowledgeBase)
                                                <a href="{{ route('admin.knowledge-base.edit', $log->knowledge_base_id) }}" class="text-blue-600 hover:text-blue-800 hover:underline">
                                                    {{ $log->knowledgeBase->title }}
                                                </a>
                                            @else
                                                <span class="text-gray-500 italic">{{ $log->new_data['title'] ?? 'N/A' }} (ID: {{ $log->knowledge_base_id }})</span>
                                            @endif
                                        </div>
                                        <div class="text-xs text-gray-500">Kategori: {{ \App\Models\KnowledgeBase::CATEGORIES[$log->new_data['category'] ?? ''] ?? ($log->new_data['category'] ?? '') }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <button onclick="showDetails({{ $log->id }})" class="text-xs font-bold text-blue-600 hover:text-blue-800 hover:underline bg-transparent border-0 cursor-pointer">
                                        Lihat Detail
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                    Belum ada riwayat aktivitas perubahan data.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($logs->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                    {{ $logs->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- Detail Modal --}}
    <div id="detailsModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/60 hidden">
        <div class="bg-white rounded-xl shadow-xl border border-gray-300 w-full max-w-4xl max-h-[85vh] flex flex-col overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wider">Detail Perubahan Data</h3>
                <button onclick="closeDetails()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="p-6 overflow-y-auto flex-1 space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <h4 class="text-xs font-bold text-gray-600 uppercase mb-2">Data Sebelum</h4>
                        <pre id="oldDataPre" class="p-4 bg-gray-50 border border-gray-200 rounded-lg text-xs overflow-x-auto text-gray-800 whitespace-pre-wrap max-h-96"></pre>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-gray-600 uppercase mb-2">Data Sesudah</h4>
                        <pre id="newDataPre" class="p-4 bg-gray-50 border border-gray-200 rounded-lg text-xs overflow-x-auto text-gray-800 whitespace-pre-wrap max-h-96"></pre>
                    </div>
                </div>
            </div>
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex justify-end">
                <button onclick="closeDetails()" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-semibold rounded-lg transition-all">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        const detailsModal = document.getElementById('detailsModal');
        const oldDataPre = document.getElementById('oldDataPre');
        const newDataPre = document.getElementById('newDataPre');
        const logsData = @json($logs->items());

        function showDetails(logId) {
            const log = logsData.find(item => item.id === logId);
            if (!log) return;

            oldDataPre.textContent = log.old_data ? JSON.stringify(log.old_data, null, 2) : '(Kosong/Tidak Ada)';
            newDataPre.textContent = log.new_data ? JSON.stringify(log.new_data, null, 2) : '(Kosong/Tidak Ada)';

            detailsModal.classList.remove('hidden');
        }

        function closeDetails() {
            detailsModal.classList.add('hidden');
        }

        // Close on esc key press
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeDetails();
            }
        });
    </script>
    @endpush
</x-app-layout>
