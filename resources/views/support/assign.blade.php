<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Assign Tiket</h2>
    </x-slot>

    <div class="max-w-2xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm rounded-lg p-6">
            <p class="mb-4"><strong>Judul:</strong> {{ $ticket->subject }}</p>

            <form method="POST" action="{{ route('tickets.assign', $ticket->id) }}">
                @csrf

                <input type="hidden" name="assigned_to" value="{{ auth()->id() }}">

                <div class="mb-6 p-4 bg-indigo-50 border border-indigo-100 rounded text-indigo-800 text-sm">
                    Apakah Anda yakin ingin menugaskan tiket ini ke diri Anda sendiri (<strong>{{ auth()->user()->name }}</strong>)?
                </div>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('support.tickets') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Batal</a>
                    <button class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Ambil Tiket</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
