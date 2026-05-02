<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Assign Tiket</h2>
    </x-slot>

    <div class="max-w-2xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm rounded-lg p-6">
            <p class="mb-4"><strong>Judul:</strong> {{ $ticket->subject }}</p>

            <form method="POST" action="{{ route('tickets.assign', $ticket->id) }}">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Support</label>
                    <select name="assigned_to" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                        @foreach($supports as $support)
                            <option value="{{ $support->id }}">{{ $support->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex justify-end">
                    <button class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Tetapkan</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
