<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Buat Tiket</h2>
    </x-slot>

    <div class="max-w-xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        @if ($errors->any())
            <div class="mb-4 p-4 rounded bg-red-50 border border-red-200 text-red-700">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white shadow-sm rounded-lg p-6">
            <form method="POST" action="{{ route('tickets.store') }}">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul Masalah</label>
                    <input name="subject" value="{{ old('subject') }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200" placeholder="Judul Masalah">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <textarea name="description" class="w-full border border-gray-300 rounded px-3 py-2 h-32 focus:outline-none focus:ring-2 focus:ring-blue-200" placeholder="Deskripsi">{{ old('description') }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                    <input name="category" value="{{ old('category') }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200" placeholder="Kategori (Network / Hardware)">
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Prioritas</label>
                    <select name="priority" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200">
                        <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Rendah</option>
                        <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Sedang</option>
                        <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>Tinggi</option>
                    </select>
                </div>

                <div class="flex justify-end">
                    <button class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Kirim</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
