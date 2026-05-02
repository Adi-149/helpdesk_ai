<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Ticket Saya</h2>
    </x-slot>

    <div class="max-w-4xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-4 p-4 rounded bg-green-50 border border-green-200 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow-sm rounded-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Daftar Tiket</h3>
                <a href="{{ route('tickets.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">+ Buat Tiket</a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Judul</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Prioritas</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($tickets as $ticket)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $ticket->subject }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ ucfirst($ticket->priority) }}</td>
                            <td class="px-4 py-3 text-sm">
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium ">
                                    @if($ticket->status === 'open')
                                        <span class="bg-green-100 text-green-800 px-2 py-0.5 rounded">Dibuka</span>
                                    @elseif($ticket->status === 'progress')
                                        <span class="bg-yellow-100 text-yellow-800 px-2 py-0.5 rounded">Sedang Diproses</span>
                                    @elseif($ticket->status === 'resolved')
                                        <span class="bg-blue-100 text-blue-800 px-2 py-0.5 rounded">Diselesaikan</span>
                                    @else
                                        <span class="bg-gray-100 text-gray-800 px-2 py-0.5 rounded">{{ ucfirst($ticket->status) }}</span>
                                    @endif
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $ticket->created_at->format('d-m-Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td class="px-4 py-6 text-center text-sm text-gray-500" colspan="4">Belum ada tiket.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
