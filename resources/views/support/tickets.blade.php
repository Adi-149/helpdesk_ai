<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Tiket Support</h2>
            <svg class="w-8 h-8 text-purple-600 dark:text-purple-400 opacity-30" fill="currentColor" viewBox="0 0 24 24">
                <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zm-5.04-6.71l-2.75 3.54-2.29-2.59c-.49-.53-1.3-.53-1.79 0-.51.58-.47 1.45.1 1.97l3.21 3.65c.39.42.92.65 1.5.65.48 0 .95-.17 1.34-.52l4.2-5.35c.45-.59.35-1.45-.25-1.89-.59-.45-1.45-.35-1.89.25l-3.18 4.06z"/>
            </svg>
        </div>
    </x-slot>

    <div class="max-w-6xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-4 p-4 rounded bg-green-50 border border-green-200 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow-sm rounded-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Daftar Tiket</h3>
                <!-- Create Ticket button removed for support view -->
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Judul</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Prioritas</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($tickets as $ticket)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $ticket->user->name }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $ticket->subject }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ ucfirst($ticket->priority) }}</td>
                            <td class="px-4 py-3 text-sm">
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium ">
                                    @if($ticket->status === 'open')
                                        <span class="bg-green-100 text-green-800 px-2 py-0.5 rounded">Dibuka</span>
                                    @elseif($ticket->status === 'progress')
                                        <span class="bg-yellow-100 text-yellow-800 px-2 py-0.5 rounded">Sedang Diproses</span>
                                    @else
                                        <span class="bg-gray-100 text-gray-800 px-2 py-0.5 rounded">{{ ucfirst($ticket->status) }}</span>
                                    @endif
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right space-x-2 flex justify-end">
                                <a href="{{ route('tickets.show', $ticket->id) }}" class="inline-flex items-center px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-xs">Lihat</a>
                                @if(!$ticket->assigned_to)
                                    <a href="{{ route('tickets.assign.form', $ticket->id) }}" class="inline-flex items-center px-3 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-700 text-xs">Ambil</a>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td class="px-4 py-6 text-center text-sm text-gray-500" colspan="5">Tidak ada tiket.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</x-app-layout>
