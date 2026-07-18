<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Buat Tiket</h2>
    </x-slot>

    <div class="max-w-2xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        @if ($errors->any())
            <div class="mb-4 p-4 rounded bg-red-50 border border-red-200 text-red-700">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- AI Analysis Loading State / Alert Panel -->
        <div id="ai-panel" class="hidden mb-6 p-5 rounded-xl border transition-all duration-300">
            <div id="ai-loading" class="flex items-center space-x-3">
                <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-600"></div>
                <div>
                    <h4 class="font-bold text-sm text-gray-800">Menyusun Tiket dengan AI...</h4>
                    <p class="text-xs text-gray-500">Sedang menganalisis percakapan chatbot aktif Anda untuk mengisi formulir secara otomatis.</p>
                </div>
            </div>
            
            <div id="ai-result-success" class="hidden">
                <div class="flex items-center space-x-2 mb-3 text-blue-750 font-bold text-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    <h4>Tiket Berhasil Disusun Oleh AI!</h4>
                </div>
                <p class="text-xs text-gray-600 mb-4">Kami telah mengisi formulir berdasarkan riwayat obrolan Anda. Silakan tinjau detail analisis AI di bawah sebelum mengirim tiket ini.</p>
                
                <!-- AI Preview Metadata -->
                <div class="grid grid-cols-2 gap-3 p-3 bg-blue-50 rounded-lg text-xs mb-3 border border-blue-100">
                    <div>
                        <span class="text-gray-550 block font-semibold">Prioritas AI</span>
                        <span id="preview-priority" class="font-bold text-gray-800 uppercase">Low</span>
                    </div>
                    <div>
                        <span class="text-gray-555 block font-semibold">Tingkat Keyakinan AI</span>
                        <span id="preview-confidence" class="font-bold text-blue-600">85%</span>
                    </div>
                </div>
                
                <div class="p-3 bg-gray-50 rounded-lg text-xs space-y-2 border border-gray-200">
                    <div>
                        <span class="font-semibold text-gray-700 block">Ringkasan Masalah AI:</span>
                        <p id="preview-summary" class="text-gray-600 italic mt-0.5">Menganalisis...</p>
                    </div>
                </div>
            </div>

            <div id="ai-result-error" class="hidden flex items-start space-x-3 text-red-700">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                </svg>
                <div>
                    <h4 class="font-bold text-sm">Gagal Menyusun Tiket Otomatis</h4>
                    <p id="ai-error-msg" class="text-xs mt-0.5">Koneksi terputus atau tidak ada sesi obrolan aktif. Anda tetap dapat mengisi tiket secara manual di bawah ini.</p>
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-3" id="form-title">Form Pembuatan Tiket</h3>
            <form method="POST" action="{{ route('tickets.store') }}" enctype="multipart/form-data" id="ticket-form">
                @csrf

                <!-- Hidden inputs for AI Metadata -->
                <input type="hidden" name="ai_summary" id="hidden-ai-summary">
                <input type="hidden" name="ai_causes" id="hidden-ai-causes">
                <input type="hidden" name="ai_recommendations" id="hidden-ai-recommendations">
                <input type="hidden" name="ai_confidence" id="hidden-ai-confidence">
                <input type="hidden" name="priority" id="hidden-priority" value="low">

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul Masalah</label>
                    <input name="subject" id="subject-input" value="{{ old('subject') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500" placeholder="Contoh: Gagal Login atau WiFi Lambat" required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Kendala</label>
                    <textarea name="description" id="description-input" class="w-full border border-gray-300 rounded-lg px-3 py-2 h-32 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500" placeholder="Jelaskan secara lengkap detail kendala Anda..." required>{{ old('description') }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kategori Masalah</label>
                    <select name="category" id="category-input" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500" required>
                        <option value="" disabled {{ old('category') ? '' : 'selected' }}>Pilih Kategori Masalah</option>
                        <option value="Hardware POS" {{ old('category') == 'Hardware POS' ? 'selected' : '' }}>Hardware POS</option>
                        <option value="Printer Thermal" {{ old('category') == 'Printer Thermal' ? 'selected' : '' }}>Printer Thermal</option>
                        <option value="Barcode Scanner" {{ old('category') == 'Barcode Scanner' ? 'selected' : '' }}>Barcode Scanner</option>
                        <option value="Jaringan & Internet" {{ old('category') == 'Jaringan & Internet' ? 'selected' : '' }}>Jaringan & Internet</option>
                        <option value="CCTV" {{ old('category') == 'CCTV' ? 'selected' : '' }}>CCTV</option>
                        <option value="Software POS" {{ old('category') == 'Software POS' ? 'selected' : '' }}>Software POS</option>
                        <option value="Server & Database" {{ old('category') == 'Server & Database' ? 'selected' : '' }}>Server & Database</option>
                    </select>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Lampiran Foto (Opsional)</label>
                    <input type="file" name="attachment" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm" accept="image/*">
                </div>

                <div class="flex justify-between items-center border-t pt-4">
                    <a href="{{ route('tickets.index') }}" class="text-sm font-semibold text-gray-600 hover:text-gray-800 transition">Batal</a>
                    <button class="inline-flex items-center px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-bold text-sm transition shadow-sm active:scale-95" id="submit-btn">Kirim Tiket</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', async function() {
            const urlParams = new URLSearchParams(window.location.search);
            const shouldAnalyze = urlParams.get('analyze') === '1';

            if (shouldAnalyze) {
                const aiPanel = document.getElementById('ai-panel');
                const aiLoading = document.getElementById('ai-loading');
                const aiSuccess = document.getElementById('ai-result-success');
                const aiError = document.getElementById('ai-result-error');
                const aiErrorMsg = document.getElementById('ai-error-msg');
                const formTitle = document.getElementById('form-title');
                const submitBtn = document.getElementById('submit-btn');

                // Tampilkan loading panel
                aiPanel.classList.remove('hidden');
                aiPanel.classList.add('bg-blue-50/30', 'border-blue-100');

                try {
                    const response = await fetch('{{ route("chatbot.analyze") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    });

                    const resData = await response.json();

                    aiLoading.classList.add('hidden');

                    if (response.ok && resData.success && resData.data) {
                        const data = resData.data;

                        // Pre-fill form inputs
                        document.getElementById('subject-input').value = data.subject || '';
                        document.getElementById('description-input').value = data.description || '';
                        
                        if (data.category) {
                            const catInput = document.getElementById('category-input');
                            for (let option of catInput.options) {
                                if (option.value.toLowerCase() === data.category.toLowerCase()) {
                                    option.selected = true;
                                    break;
                                }
                            }
                        }

                        // Pre-fill hidden inputs
                        document.getElementById('hidden-ai-summary').value = data.ai_summary || '';
                        document.getElementById('hidden-ai-causes').value = data.ai_causes || '';
                        document.getElementById('hidden-ai-recommendations').value = data.ai_recommendations || '';
                        document.getElementById('hidden-ai-confidence').value = data.ai_confidence || '';
                        document.getElementById('hidden-priority').value = (data.priority || 'low').toLowerCase();

                        // Update UI preview
                        document.getElementById('preview-summary').textContent = data.ai_summary || '';
                        
                        const priorityEl = document.getElementById('preview-priority');
                        priorityEl.textContent = data.priority || 'Low';
                        if ((data.priority || '').toLowerCase() === 'high') {
                            priorityEl.className = 'font-bold text-red-650';
                        } else if ((data.priority || '').toLowerCase() === 'medium') {
                            priorityEl.className = 'font-bold text-orange-650';
                        } else {
                            priorityEl.className = 'font-semibold text-green-650';
                        }

                        document.getElementById('preview-confidence').textContent = data.ai_confidence || '80%';

                        // Tampilkan UI sukses
                        aiSuccess.classList.remove('hidden');
                        aiPanel.className = "mb-6 p-5 rounded-xl border bg-green-50/40 border-green-200 transition-all duration-300";
                        formTitle.innerHTML = 'Konfirmasi Pembuatan Tiket (Draft AI)';
                        submitBtn.innerHTML = 'Konfirmasi & Kirim';
                        submitBtn.className = "inline-flex items-center px-6 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-lg font-bold text-sm transition shadow-sm active:scale-95";
                    } else {
                        // Tampilkan UI error
                        aiErrorMsg.textContent = resData.message || 'Gagal mengambil analisis percakapan.';
                        aiError.classList.remove('hidden');
                        aiPanel.className = "mb-6 p-5 rounded-xl border bg-red-50/40 border-red-200 transition-all duration-300";
                    }

                } catch (error) {
                    console.error(error);
                    aiLoading.classList.add('hidden');
                    aiErrorMsg.textContent = 'Terjadi kesalahan jaringan atau server saat menghubungi AI.';
                    aiError.classList.remove('hidden');
                    aiPanel.className = "mb-6 p-5 rounded-xl border bg-red-50/40 border-red-200 transition-all duration-300";
                }
            }
        });
    </script>
</x-app-layout>
