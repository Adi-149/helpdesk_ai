BAB IV
HASIL DAN PEMBAHASAN


Bagian ini menampilkan hasil implementasi dan fungsionalitas dalam rekayasa perangkat lunak dengan menerapkan Sistem Helpdesk Chatbot AI berbasis web. Perangkat lunak dan perangkat keras termasuk dalam pembahasan implementasi dan pengujian sistem.

4.1 Implementasi
Implementasi merupakan tahap krusial setelah perancangan dan analisis program selesai. Tahap ini berfokus pada pembangunan aplikasi yang merepresentasikan desain yang telah dibuat secara nyata. Tujuan utama implementasi adalah membangun aplikasi yang mudah dan nyaman digunakan oleh pengguna. Oleh karena itu, aplikasi perlu melalui proses pengujian dan penyempurnaan yang menyeluruh untuk meminimalisir kesalahan dan memastikan kelancaran sistem. Implementasi yang cermat dan terencana akan menghasilkan aplikasi yang siap diluncurkan dan memberikan manfaat bagi para user.

4.1.3 Implementasi Antarmuka
Salah satu langkah dalam memenuhi kebutuhan pengguna untuk berinteraksi dengan sistem yang dibuat adalah implementasi antarmuka. Antarmuka yang baik akan membantu pengguna memahami proses yang sedang dilakukan sistem, sehingga sistem dapat bekerja lebih baik.
4.1.3.1 Halaman Dashboard User 
Gambar 4.9 Halaman Dashboard User
Halaman dashboard user pada Gambar 4.9 adalah tampilan awal yang akan muncul setelah aktor user (pelanggan) berhasil melakukan proses login. Tampilan ini menyajikan statistik ringkasan tiket yang dimiliki oleh user tersebut berdasarkan status tiket (open, progress, resolved, closed) dan prioritas penanganan (low, medium, high), serta menampilkan daftar 5 tiket pengaduan terbaru milik user. 
Segmen 4.1 Dashboard User
1	@extends('layouts.app') 
2	@section('content') 
3	<div class="py-12"> 
4	    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8"> 
5	        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6"> 
6	            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6"> 
7	                <div class="text-sm font-medium text-gray-500">Tiket Terbuka</div> 
8	                <div class="text-3xl font-semibold">{{ $ticketsByStatus['open'] }}</div> 
9	            </div> 
10	            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6"> 
11	                <div class="text-sm font-medium text-gray-500">Sedang Diproses</div> 
12	                <div class="text-3xl font-semibold">{{ $ticketsByStatus['progress'] }}</div> 
13	            </div> 
14	        </div> 
15	    </div> 
16	</div> 
17	@endsection 
Segmen 4.1 kode ini merupakan bagian dari tampilan halaman dashboard user. Penggunaan @extends('layouts.app') berfungsi sebagai master layout untuk menjaga konsistensi elemen visual seperti header, navigasi, dan footer. Pada bagian @section('content'), statistik jumlah tiket user diakses dari variabel $ticketsByStatus untuk ditampilkan dalam bentuk kartu grid yang responsif.
4.1.3.2 Halaman Daftar Tiket User 
Gambar 4.10 Halaman Daftar Tiket User
Tampilan halaman pada Gambar 4.10 menampilkan seluruh riwayat tiket kendala yang diajukan oleh user. Halaman ini dilengkapi dengan fitur penyaringan (filter) berdasarkan status tiket, prioritas, kategori masalah, serta tanggal pembuatan tiket. Dengan adanya pagination, data tiket disajikan sebanyak 15 data per halaman agar memudahkan navigasi pengguna.
Segmen 4.2 Halaman Daftar Tiket User
1	public function index(Request $request) 
2	{ 
3	    if (auth()->user()->role === 'support') { 
4	        return redirect()->route('support.tickets'); 
5	    } 
6	    $filterStatus = $request->query('status'); 
7	    $filterPriority = $request->query('priority'); 
8	    $filterCategory = $request->query('category'); 
9	    $ticketsQuery = Ticket::with(['user', 'assignedSupport'])->latest(); 
10	    if (auth()->user()->role !== 'admin') { 
11	        $ticketsQuery->where('user_id', auth()->id()); 
12	    } 
13	    $tickets = $ticketsQuery->paginate(15)->appends($request->query()); 
14	    $categories = Ticket::select('category')->distinct()->orderBy('category')->pluck('category'); 
15	    return view('tickets.index', compact('tickets', 'categories')); 
16	} 

Pada Segmen 4.2 menjelaskan kode pengendali (controller) untuk menampilkan halaman daftar tiket. Fungsi index() akan memverifikasi peran pengguna terlebih dahulu. Jika pengguna adalah support, sistem akan mengarahkannya ke halaman tiket support. Sementara itu, untuk user biasa, query database dibatasi hanya untuk mengambil tiket milik mereka sendiri sebelum akhirnya dikirimkan ke blade views untuk dirender.
4.1.3.3 Halaman Pembuatan Tiket Baru 
Gambar 4.11 Halaman Pembuatan Tiket Baru
Pada gambar 4.11 menampilkan formulir pembuatan tiket baru yang diakses oleh user. Formulir ini meminta input subjek masalah, deskripsi kendala secara detail, pemilihan kategori (Hardware, Software, Jaringan, Akun, Lainnya), serta opsi unggah berkas lampiran pendukung berupa foto atau gambar.
Segmen 4.3 Form Pembuatan Tiket
1	<form action="{{ route('tickets.store') }}" method="POST" enctype="multipart/form-data"> 
2	    @csrf 
3	    <div class="mb-4"> 
4	        <label for="subject">Subjek Masalah</label> 
5	        <input type="text" name="subject" id="subject" required class="form-input"> 
6	    </div> 
7	    <div class="mb-4"> 
8	        <label for="category">Kategori</label> 
9	        <select name="category" id="category" required class="form-select"> 
10	            <option value="Hardware">Hardware</option> 
11	            <option value="Software">Software</option> 
12	            <option value="Jaringan">Jaringan</option> 
13	            <option value="Akun">Akun</option> 
14	            <option value="Lainnya">Lainnya</option> 
15	        </select> 
16	    </div> 
17	    <div class="mb-4"> 
18	        <label for="attachment">Lampiran Gambar (Opsional)</label> 
19	        <input type="file" name="attachment" id="attachment" accept="image/*"> 
20	    </div> 
21	    <button type="submit" class="btn-submit">Kirim Tiket</button> 
22	</form> 

Segmen 4.3 menampilkan rancangan formulir Blade HTML untuk mengunggah tiket. Atribut enctype="multipart/form-data" digunakan agar form dapat memproses unggahan file gambar lampiran secara aman. Validasi masukan dilakukan di sisi server untuk memastikan semua data wajib terisi sesuai format.
4.1.3.4 Halaman Detail Tiket & Analisis AI 
Gambar 4.12 Halaman Detail Tiket & Analisis AI
Halaman detail tiket pada Gambar 4.12 menampilkan rincian dari satu tiket kendala terpilih. Pada halaman ini, staff teknisi dan admin dapat melihat data laporan pengguna beserta visualisasi analisis AI secara real-time yang bersumber dari API OpenRouter. AI akan menyajikan ringkasan masalah, dugaan penyebab, rekomendasi solusi, serta persentase keyakinan (confidence).

Integrasi AI pada halaman detail tiket ini bertujuan untuk meminimalkan waktu yang dibutuhkan teknisi dalam melakukan investigasi awal. Dengan adanya modul analisis otomatis, teknisi dapat langsung memahami duduk perkara kendala tanpa harus membaca teks deskripsi yang panjang atau tidak terstruktur dari user.

Segmen 4.4 Detail Tiket & Rekomendasi AI
1	@if($ticket->ai_summary) 
2	<div class="bg-blue-50 p-4 rounded-lg mb-6 border border-blue-200"> 
3	    <h3 class="text-lg font-medium text-blue-800">Analisis Otomatis AI Helpdesk</h3> 
4	    <p><strong>Ringkasan Masalah:</strong> {{ $ticket->ai_summary }}</p> 
5	    <p><strong>Kemungkinan Penyebab:</strong></p> 
6	    <div class="text-sm text-gray-700">{!! nl2br(e($ticket->ai_causes)) !!}</div> 
7	    <p><strong>Rekomendasi Penanganan:</strong></p> 
8	    <div class="text-sm text-gray-700">{!! nl2br(e($ticket->ai_recommendations)) !!}</div> 
9	    <p><strong>Tingkat Keyakinan AI:</strong> <span class="badge">{{ $ticket->ai_confidence }}</span></p> 
10	</div> 
11	@endif 

Segmen 4.4 menjelaskan kode tampilan detail tiket yang memproses render bersyarat (@if) untuk menampilkan analisis AI. Apabila kolom `ai_summary` pada tabel tickets terisi, sistem akan mencetak panel analisis terstruktur dengan styling khusus menggunakan kelas Tailwind CSS untuk mempermudah teknisi dalam mengidentifikasi masalah secara cepat. Empat parameter utama yang diproses dan ditampilkan oleh AI meliputi:
1. **Ringkasan Masalah (`ai_summary`)**: Penjelasan singkat 1-2 kalimat mengenai inti masalah yang dilaporkan pengguna.
2. **Kemungkinan Penyebab (`ai_causes`)**: Analisis beberapa faktor teknis yang memicu terjadinya kendala tersebut.
3. **Rekomendasi Penanganan (`ai_recommendations`)**: Panduan langkah demi langkah bagi teknisi untuk menyelesaikan kendala terkait.
4. **Tingkat Keyakinan AI (`ai_confidence`)**: Persentase estimasi tingkat akurasi atau keyakinan model kecerdasan buatan terhadap rekomendasi yang diajukan.
4.1.3.4b Halaman Rekomendasi Kasus Serupa (Knowledge Base)
Gambar 4.12b Halaman Rekomendasi Kasus Serupa
Di samping panel analisis utama, halaman detail tiket juga dilengkapi dengan panel "Kasus Serupa" khusus untuk aktor teknisi (support) dan admin. Fitur ini berfungsi sebagai basis pengetahuan (knowledge base) dinamis yang memindai tiket lama berstatus resolved atau closed yang memiliki kemiripan kategori dan isi keluhan dengan tiket aktif.

Segmen 4.4b Logika Pencarian Kasus Serupa Berbasis AI
1	private function findSimilarTickets($ticket): array
2	{
3	    $resolvedTickets = Ticket::whereIn('status', ['resolved', 'closed'])
4	        ->whereNotNull('resolution_summary')
5	        ->where('id', '!=', $ticket->id)->latest()->take(15)->get(['id', 'subject', 'category', 'resolution_summary']);
6	    if ($resolvedTickets->isEmpty()) { return []; }
7	    $candidatesText = "";
8	    foreach ($resolvedTickets as $candidate) {
9	        $candidatesText .= "ID: {$candidate->id} | Kategori: {$candidate->category} | Judul: {$candidate->subject}\n";
10	        $candidatesText .= "Resolusi: " . \Illuminate\Support\Str::limit($candidate->resolution_summary, 150) . "\n---\n";
11	    }
12	    $systemPrompt = "Anda adalah asisten pencari kasus IT Helpdesk yang cerdas. Bandingkan tiket aktif dengan daftar tiket lama. Temukan maks 3 tiket serupa...";
13	    $response = Http::withHeaders(['Authorization' => 'Bearer ' . $apiKey])->post('https://openrouter.ai/api/v1/chat/completions', [
14	        'model' => env('OPENROUTER_MODEL', 'gpt-4o-mini'),
15	        'messages' => [
16	            ['role' => 'system', 'content' => $systemPrompt],
17	            ['role' => 'user', 'content' => "TICKET AKTIF:\nJudul: {$ticket->subject}...\n\nDAFTAR KASUS LAMA:\n{$candidatesText}"]
18	        ]
19	    ]);
20	    // ... parsing json dan mengembalikan array berisi similarity & reason ...
21	}

Segmen 4.4b di atas memaparkan logika controller dalam menemukan kasus serupa. Staf IT tidak perlu mencari secara manual di basis data. Model AI (Gemini/GPT) akan membandingkan konteks permasalahan secara semantik dan mengembalikan rekomendasi 3 tiket selesai beserta penilaian kemiripan (Tinggi/Sedang) serta alasan teknis mengapa solusi tiket tersebut relevan dijadikan rujukan penanganan.

4.1.3.5 Halaman Diskusi Tiket (Obrolan Detail) 
Gambar 4.13 Halaman Diskusi Tiket
Di dalam halaman detail tiket terdapat modul obrolan diskusi seperti terlihat pada Gambar 4.13. Modul ini difungsikan agar pembuat tiket (user), teknisi yang ditugaskan, dan administrator dapat melakukan tanya jawab secara interaktif guna mempercepat koordinasi pemecahan masalah teknis.
Segmen 4.5 Pengiriman Pesan Obrolan Tiket
1	public function storeMessage(Request $request, $id) 
2	{ 
3	    $request->validate(['message' => 'required|string|max:1000']); 
4	    $ticket = Ticket::findOrFail($id); 
5	    $user = auth()->user(); 
6	    if ($ticket->user_id !== $user->id && $user->role !== 'support' && $user->role !== 'admin') { 
7	        abort(403, 'Anda tidak memiliki akses ke tiket ini.'); 
8	    } 
9	    $msg = TicketMessage::create([ 
10	        'ticket_id' => $ticket->id, 
11	        'user_id'   => $user->id, 
12	        'message'   => $request->message, 
13	    ]); 
14	    return redirect()->route('tickets.show', $ticket->id)->with('success', 'Pesan berhasil dikirim.'); 
15	} 

Pada Segmen 4.5 menjelaskan logika controller untuk menyimpan pesan diskusi baru. Metode storeMessage() melakukan pengecekan otorisasi ketat guna memastikan hanya aktor yang berhak (pemilik tiket, teknisi pemroses, atau admin) yang dapat menyisipkan rekaman ke dalam tabel `ticket_messages`, diikuti dengan pengiriman notifikasi otomatis kepada pihak terkait.
4.1.3.6 Halaman Chatbot AI (Konsultasi Mandiri) 
Gambar 4.14 Halaman Chatbot AI
Halaman Chatbot AI pada Gambar 4.14 memfasilitasi user untuk melakukan konsultasi masalah IT secara mandiri dengan asisten cerdas Gemini AI. Untuk memastikan fungsionalitas asisten ini berjalan optimal dan tidak disalahgunakan, sistem dirancang dengan beberapa aturan serta batasan logis di tingkat backend:
1. **Penyaringan Topik Khusus IT**: Menggunakan *System Prompt* ketat untuk membatasi ruang lingkup obrolan hanya pada bidang teknologi, troubleshooting komputer, jaringan, dan software. Pertanyaan non-teknis akan ditolak secara otomatis secara sopan.
2. **Format Jawaban Plain Text**: Bot dipaksa untuk menjawab dalam teks biasa tanpa format markdown guna menjaga kerapihan gelembung obrolan pada antarmuka *Chatbot UI*.
3. **Pembatasan Sesi Diskusi**: Jumlah pengiriman pesan pengguna dibatasi maksimal 10 pesan (`MAX_USER_MESSAGES = 10`) untuk setiap sesi aktif guna meminimalisir biaya penggunaan API OpenRouter.
4. **Hotline Pengaduan**: Apabila percakapan mencapai batas atau solusi tidak ditemukan, chatbot akan menyarankan pembuatan tiket resmi atau langsung menghubungi nomor teknisi yang tertera.

Apabila API OpenRouter/Gemini mengalami kendala koneksi atau limit kuota, sistem menyediakan mekanisme *fallback* berbasis pencocokan pola kata kunci (Regular Expression) agar pengguna tidak mendapatkan respon kosong.

Segmen 4.6 Pemrosesan Chatbot dan Fallback Regex
1	private function getFallbackResponse(string $message): string 
2	{ 
3	    $message = strtolower($message); 
4	    $fallbacks = [ 
5	        '/\b(wifi|internet|jaringan|koneksi|sinyal|lemot|lag)\b/i' => 
6	            "Sepertinya Anda mengalami masalah koneksi. Coba langkah berikut:\n1. Pastikan WiFi Anda menyala.\n2. Coba restart router atau modem Anda.", 
7	        '/\b(error|bug|masalah|rusak|gagal|crash|freeze)\b/i' => 
8	            "Jelaskan lebih detail tentang error atau masalah teknis yang Anda hadapi. Berikan informasi seperti: pesan error dan kapan terjadi.", 
9	    ]; 
10	    foreach ($fallbacks as $pattern => $response) { 
11	        if (preg_match($pattern, $message)) { 
12	            return $response; 
13	        } 
14	    } 
15	    return "Maaf, sepertinya saya sedang mengalami gangguan koneksi ke server AI utama. Silakan coba tanyakan lagi."; 
16	} 

Segmen 4.6 ini diimplementasikan di dalam `ChatbotController` sebagai pengaman apabila koneksi OpenRouter mengalami kendala. Logika mencocokkan input masukan pengguna dengan kata kunci kunci menggunakan fungsi preg_match() PHP. Apabila kecocokan pola ditemukan, pesan petunjuk standar akan langsung dikirim kembali ke antarmuka user.

Selain percakapan mandiri, halaman ini memfasilitasi pembuatan tiket instan berbasis kecerdasan buatan. Dengan mengklik tombol "Analisis Percakapan", seluruh pesan obrolan antara pengguna dan bot dalam sesi tersebut akan dikirimkan kembali ke OpenRouter. Model AI akan menganalisis riwayat obrolan dan menyusun rancangan tiket terstruktur berformat JSON yang berisi: subjek, deskripsi detail kendala, penentuan kategori otomatis, penentuan prioritas masalah, ringkasan AI, dugaan penyebab, dan rekomendasi solusi. Rancangan JSON ini akan otomatis diisi ke dalam formulir pendaftaran tiket agar mempermudah pengguna.

Segmen 4.6b Analisis Percakapan Menjadi Draf Tiket
1	public function analyzeConversation(Request $request): JsonResponse 
2	{ 
3	    $conversation = ChatbotConversation::where('user_id', auth()->id())->where('status', 'active')->first(); 
4	    if (!$conversation) { return response()->json(['success' => false, 'message' => 'Tidak ada percakapan aktif.'], 404); } 
5	    $messages = $conversation->messages()->orderBy('created_at', 'asc')->get(); 
6	    if ($messages->isEmpty()) { return response()->json(['success' => false, 'message' => 'Percakapan kosong.'], 400); } 
7	    $conversationText = ""; 
8	    foreach ($messages as $msg) { 
9	        $sender = $msg->sender_type === 'user' ? 'User' : 'Asisten AI'; 
10	        $conversationText .= "[$sender]: " . $msg->message . "\n"; 
11	    } 
12	    $systemPrompt = "Anda adalah asisten analisis IT Helpdesk yang cerdas. Tugas Anda adalah menganalisis riwayat percakapan... dan menyusun rancangan tiket bantuan dalam format JSON yang valid."; 
13	    $model = env('OPENROUTER_MODEL', 'gpt-4o-mini'); 
14	    $response = Http::withHeaders(['Authorization' => 'Bearer ' . $apiKey])->post('https://openrouter.ai/api/v1/chat/completions', [ 
15	        'model' => $model, 
16	        'messages' => [ 
17	            ['role' => 'system', 'content' => $systemPrompt], 
18	            ['role' => 'user', 'content' => "Berikut adalah riwayat percakapan untuk dianalisis:\n\n" . $conversationText] 
19	        ], 
20	        'temperature' => 0.5, 
21	    ]); 
22	    // ... parsing json dan mengembalikan response ke frontend 
23	} 

Segmen 4.6b di atas merupakan potongan kode metode `analyzeConversation()` di dalam `ChatbotController`. Logika ini mengambil seluruh rekaman chat dalam database, membangun string percakapan secara kronologis, dan mengirimkannya ke API OpenRouter dengan *System Prompt* khusus yang memaksa output berupa JSON valid. Data JSON tersebut kemudian diurai (*decode*) di sisi server sebelum dikembalikan ke antarmuka pengguna sebagai respons JSON.
4.1.3.7 Halaman Form Login & Autentikasi 
Gambar 4.15 Halaman Form Login
Halaman login pada Gambar 4.15 adalah gerbang utama otentikasi pengakses sistem. Formulir ini memvalidasi kombinasi email dan password unik pengguna. Setelah proses verifikasi sukses, sistem akan mengarahkan pengguna ke rute dashboard masing-masing sesuai dengan peran yang terdaftar di database.
Segmen 4.7 Rute Pengalihan Login Berdasarkan Role
1	Route::get('/dashboard', function () { 
2	    $user = auth()->user(); 
3	    if ($user->role === 'admin') { 
4	        return redirect()->route('admin.dashboard'); 
5	    } 
6	    if ($user->role === 'support') { 
7	        return redirect()->route('dashboard.support'); 
8	    } 
9	    return redirect()->route('dashboard.user'); 
10	})->middleware(['auth', 'verified'])->name('dashboard'); 

Segmen kode pada Segmen 4.7 ini mengelola pengalihan pengguna yang berhasil login. Pengecekan middleware `auth` dan `verified` memastikan sesi pengguna valid. Perbedaan logika peran diuji menggunakan struktur kondisi if untuk menentukan apakah pengguna diarahkan ke dashboard admin, support, atau user.
4.1.3.8 Halaman Form Registrasi Pengguna Baru 
Gambar 4.16 Halaman Form Registrasi
Halaman registrasi memfasilitasi pembuatan akun pengguna baru agar dapat mengakses fitur helpdesk. Formulir ini meminta nama lengkap, email unik, kata sandi, dan konfirmasi kata sandi. Secara sistem, setiap akun baru yang didaftarkan melalui halaman ini akan otomatis mendapatkan peran awal (role) sebagai 'user'.
Segmen 4.8 Validasi Pendaftaran Akun
1	protected function validator(array $data) 
2	{ 
3	    return Validator::make($data, [ 
4	        'name' => ['required', 'string', 'max:255'], 
5	        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'], 
6	        'password' => ['required', 'string', 'min:8', 'confirmed'], 
7	    ]); 
8	} 

Segmen 4.8 ini menguraikan fungsi validator pendaftaran bawaan sistem Laravel. Aturan 'unique:users' memvalidasi agar tidak ada email ganda di dalam tabel users, sedangkan aturan 'confirmed' memastikan masukan konfirmasi sandi sama persis dengan kolom password utama.
4.1.3.9 Halaman Dashboard Support (Teknisi) 
Gambar 4.17 Halaman Dashboard Support
Halaman utama bagi aktor support (teknisi) ditampilkan pada Gambar 4.17. Dasbor ini menyajikan visualisasi data statistik yang komprehensif, mencakup jumlah tiket aktif, statistik tiket per status, tingkat prioritas tiket, kategori kerusakan terbanyak, jumlah tiket yang belum ditugaskan (unassigned), serta ringkasan tiket yang baru masuk.
Segmen 4.9 Statistik Tiket pada Dashboard Support
1	public function supportDashboard() 
2	{ 
3	    $totalTickets = Ticket::count(); 
4	    $ticketsByStatus = [ 
5	        'open' => Ticket::where('status', 'open')->count(), 
6	        'progress' => Ticket::where('status', 'progress')->count(), 
7	        'resolved' => Ticket::where('status', 'resolved')->count(), 
8	        'closed' => Ticket::where('status', 'closed')->count(), 
9	    ]; 
10	    $unassignedTickets = Ticket::where('status', 'open')->whereNull('assigned_to')->count(); 
11	    $recentTickets = Ticket::latest()->take(5)->get(); 
12	    return view('dashboard.support', compact('totalTickets', 'ticketsByStatus', 'unassignedTickets', 'recentTickets')); 
13	} 

Segmen 4.9 menjelaskan fungsi supportDashboard() di dalam `DashboardController`. Data statistik dihitung menggunakan agregasi Eloquent `count()` dari tabel tickets berdasarkan status dan penugasan teknisi. Data ini dipasok ke view `dashboard.support` untuk ditampilkan sebagai panel informasi penanganan harian teknisi.
4.1.3.10 Halaman Daftar Seluruh Tiket Masuk 
Gambar 4.18 Halaman Daftar Tiket Masuk
Halaman ini menampilkan seluruh daftar tiket pengaduan yang masuk dari seluruh user di dalam database seperti terlihat pada Gambar 4.18. Halaman ini dapat diakses oleh teknisi dan admin untuk memantau beban antrean tiket kendala secara menyeluruh.
Segmen 4.10 Pengambilan Tiket Masuk
1	public function all(Request $request) 
2	{ 
3	    $filterStatus = $request->query('status'); 
4	    $ticketsQuery = Ticket::with(['user', 'assignedSupport'])->latest(); 
5	    if ($filterStatus) { 
6	        $ticketsQuery->where('status', $filterStatus); 
7	    } 
8	    $tickets = $ticketsQuery->paginate(15)->appends($request->query()); 
9	    $categories = Ticket::select('category')->distinct()->orderBy('category')->pluck('category'); 
10	    return view('support.tickets', compact('tickets', 'categories')); 
11	} 

Segmen 4.10 menunjukkan implementasi fungsi all() untuk mengambil seluruh data tiket di sistem. Relasi database `user` dan `assignedSupport` dipanggil dengan metode eager loading `with()` agar meminimalisir kueri ke database (N+1 query problem) saat mencetak daftar tiket di halaman support.
4.1.3.11 Halaman Penugasan Tiket (Self-Assign) 
Gambar 4.19 Halaman Penugasan Tiket
Untuk menangani masalah yang masuk, teknisi dapat memilih tombol penugasan tiket pada halaman detail tiket seperti Gambar 4.19. Tindakan ini memicu pembaruan kolom `assigned_to` pada tiket menjadi ID teknisi yang sedang login dan otomatis mengubah status tiket dari `open` menjadi `progress`.
Segmen 4.11 Proses Self-Assign Tiket
1	public function assign(Request $request, $id) 
2	{ 
3	    $request->validate([ 
4	        'assigned_to' => 'required|in:' . auth()->id(), 
5	    ], [ 
6	        'assigned_to.in' => 'Anda hanya dapat menugaskan tiket untuk diri Anda sendiri.', 
7	    ]); 
8	    $ticket = Ticket::findOrFail($id); 
9	    $ticket->assigned_to = auth()->id(); 
10	    $ticket->status = 'progress'; 
11	    $ticket->save(); 

Segmen 4.11 di atas adalah fungsi assign() di dalam `TicketController`. Validasi `'in:' . auth()->id()` memastikan teknisi hanya bisa mengklaim tiket untuk dirinya sendiri. Setelah data berhasil disimpan ke database, notifikasi `TicketAssignedNotification` dikirimkan secara otomatis ke email atau dasbor user pembuat tiket.
4.1.3.12 Halaman Pembaruan Tiket & AI Resolution 
Gambar 4.20 Halaman Pembaruan Tiket
Teknisi diberikan hak untuk memperbarui status penanganan tiket (open, progress, resolved, closed), mengubah skala prioritas, serta memasukkan catatan akhir. Saat status tiket diubah menjadi `resolved` atau `closed`, sistem memanggil OpenRouter secara otomatis untuk menyusun ringkasan penyelesaian (resolution summary) berdasarkan riwayat chat tiket tersebut.
Segmen 4.12 Pembaruan Status dan AI Resolution Summary
1	if (in_array($request->status, ['resolved', 'closed']) && empty($ticket->resolution_summary)) { 
2	    $ticket->resolution_summary = $this->generateResolutionSummary($ticket, $request->notes); 
3	} 
4	$ticket->save(); 
5	TicketHistory::create([ 
6	    'ticket_id' => $ticket->id, 
7	    'user_id' => auth()->id(), 
8	    'old_status' => $oldStatus, 
9	    'new_status' => $request->status, 
10	    'notes' => $finalNotes ?: null, 
11	]); 

Segmen 4.12 memaparkan sebagian logika pembaruan tiket di `TicketController`. Ketika status penyelesaian dicapai (`resolved` atau `closed`), fungsi pembantu `generateResolutionSummary` dieksekusi untuk merangkum seluruh percakapan diskusi tiket dan catatan teknisi menjadi satu laporan solusi yang padat dan jelas. Selanjutnya, riwayat perubahan ini disimpan ke dalam tabel `ticket_histories` sebagai log audit pelacakan kinerja teknisi.

Untuk memahami bagaimana ringkasan akhir solusi tersebut dihasilkan, sistem mendefinisikan fungsi internal yang memanggil model AI dengan struktur masukan detail kendala, catatan teknisi, serta jalannya diskusi antara user dan support.

Segmen 4.12b Logika Pembuatan Ringkasan Solusi AI
1	private function generateResolutionSummary($ticket, $techNotes = null): string 
2	{ 
3	    try { 
4	        $apiKey = env('OPENROUTER_API_KEY', ''); 
5	        if (empty($apiKey)) { return "Masalah: {$ticket->subject}\nPenyebab: Tidak dapat menganalisis...\nSolusi: Tiket diselesaikan oleh teknisi."; } 
6	        $discussionMessages = $ticket->messages()->orderBy('created_at', 'asc')->get(); 
7	        $discussionText = ""; 
8	        foreach ($discussionMessages as $msg) { 
9	            $role = $msg->user->role === 'support' ? 'Teknisi' : ($msg->user->role === 'admin' ? 'Admin' : 'User'); 
10	            $discussionText .= "[$role - {$msg->user->name}]: {$msg->message}\n"; 
11	        } 
12	        $systemPrompt = "Anda adalah asisten dokumentasi IT Helpdesk. Tugas Anda adalah menganalisis riwayat tiket... Ringkasan harus berformat persis seperti berikut:\nMasalah:\n[...]\nPenyebab:\n[...]\nSolusi:\n[...]\nStatus:\nSelesai"; 
13	        $model = env('OPENROUTER_MODEL', 'gpt-4o-mini'); 
14	        $response = Http::withHeaders(['Authorization' => 'Bearer ' . $apiKey])->post('https://openrouter.ai/api/v1/chat/completions', [ 
15	            'model' => $model, 
16	            'messages' => [ 
17	                ['role' => 'system', 'content' => $systemPrompt], 
18	                ['role' => 'user', 'content' => "TICKET DETAILS:\nJudul: {$ticket->subject}...\nCATATAN TEKNISI:\n{$techNotes}\nDISKUSI:\n{$discussionText}"] 
19	            ], 
20	            'temperature' => 0.3, 
21	        ]); 
22	        if ($response->successful()) { return trim($response->json()['choices'][0]['message']['content']); } 
23	    } catch (\Exception $e) { Log::error('Generate Resolution Summary Failed: ' . $e->getMessage()); } 
24	    return "Masalah: {$ticket->subject}\nPenyebab: Diidentifikasi oleh teknisi secara langsung.\nSolusi: Langkah penanganan diselesaikan berdasarkan diskusi.\nStatus: Selesai."; 
25	} 

Segmen 4.12b merupakan logika pengolahan data riwayat penanganan tiket pada backend. Kode ini melakukan:
1. Pengumpulan seluruh pesan percakapan internal tiket untuk mengetahui alur pemecahan masalah.
2. Formulasi prompt terstruktur yang memandu model AI agar hanya membalas dalam struktur baku (Masalah, Penyebab, Solusi, Status).
3. Pengiriman HTTP Request dengan tingkat *temperature* yang rendah (0.3) agar respon AI lebih konsisten dan deterministik.
4. Penyediaan pesan *fallback* standar apabila integrasi API terputus demi menjamin integritas data status tiket di database.
4.1.3.13 Halaman Dashboard Admin 
Gambar 4.21 Halaman Dashboard Admin
Halaman utama administrator pada Gambar 4.21 menyajikan ringkasan administratif global. Admin dapat memantau statistik total seluruh tiket, sebaran kategori, prioritas masalah, serta daftar seluruh pengguna sistem yang dibagi berdasarkan peran (user biasa, staff support, dan administrator).
Segmen 4.13 Tampilan Data Pengguna pada Dashboard Admin
1	public function index(): View 
2	{ 
3	    $users = User::where('role', 'user')->get(); 
4	    $supportStaff = User::where('role', 'support')->get(); 
5	    $admins = User::where('role', 'admin')->get(); 
6	    $totalTickets = Ticket::count(); 
7	    return view('admin.dashboard', compact('users', 'supportStaff', 'admins', 'totalTickets')); 
8	} 

Segmen 4.13 menunjukkan pemrosesan dashboard admin di dalam `AdminController`. Fungsi index() mengambil semua data pengguna dari tabel users yang dikelompokkan sesuai dengan perannya (`role`) untuk dipetakan ke dalam tabel kelola akun pada view admin.
4.1.3.14 Halaman Kelola Data Pengguna (Manajemen Akun) 
Gambar 4.22 Halaman Kelola Data Pengguna
Sebagai pemegang otoritas tertinggi, admin dapat mengelola akun pengguna pada halaman Gambar 4.22. Aksi yang dapat dilakukan oleh admin meliputi penyesuaian hak akses role pengguna (misal menaikkan user menjadi support) serta penghapusan akun pengguna dari basis data.
Segmen 4.14 Logika Penghapusan Akun Pengguna
Segmen 4.14 menunjukkan metode deleteUser() di dalam `AdminController`. Terdapat logika pengaman penting yang mencegah admin untuk tidak sengaja menghapus akun miliknya sendiri yang sedang aktif digunakan untuk login.
4.1.3.15 Halaman Laporan & Statistik Kinerja 
Gambar 4.23 Halaman Laporan
1	public function deleteUser(Request $request, User $user): RedirectResponse 
2	{ 
3	    if ($user->id === auth()->id()) { 
4	        return redirect()->route('admin.dashboard')->with('error', 'Anda tidak dapat menghapus akun admin Anda sendiri.'); 
5	    } 
6	    $user->delete(); 
7	    return redirect()->route('admin.dashboard')->with('status', 'Pengguna berhasil dihapus.'); 
8	} 

Halaman laporan pada Gambar 4.23 membantu admin menganalisis kinerja helpdesk. Halaman ini memuat visualisasi statistik kinerja teknisi (jumlah tiket yang ditugaskan, diselesaikan, dan diproses), tren jumlah tiket bulanan selama 6 bulan terakhir, serta tabel kueri tiket terfilter yang dapat dicetak atau diekspor.
Segmen 4.15 Agregasi Kinerja Bulanan dan Teknisi
1	$supportStaff = User::where('role', 'support')->get()->map(function ($staff) { 
2	    $staff->assigned_count = Ticket::where('assigned_to', $staff->id)->count(); 
3	    $staff->resolved_count = Ticket::where('assigned_to', $staff->id)->whereIn('status', ['resolved', 'closed'])->count(); 
4	    return $staff; 
5	}); 
6	$monthlyData = []; 
7	for ($i = 5; $i >= 0; $i--) { 
8	    $date = Carbon::now()->subMonths($i); 
9	    $monthlyData[] = [ 
10	        'month' => $date->translatedFormat('M Y'), 
11	        'total' => Ticket::whereYear('created_at', $date->year)->whereMonth('created_at', $date->month)->count(), 
12	    ]; 
13	} 

Segmen 4.15 merupakan logika pengolahan data laporan pada `ReportController`. Fungsi memetakan daftar staf support menggunakan penambahan atribut kustom (`assigned_count`, `resolved_count`) serta mengumpulkan data kuantitatif bulanan menggunakan perulangan Carbon untuk disajikan dalam bentuk grafik tren bulanan.
4.1.3.16 Halaman Reset Password 
Gambar 4.24 Halaman Reset Password
Halaman reset password pada Gambar 4.24 diakses dari tautan "Lupa Password" pada halaman login. Halaman ini memproses pengiriman token verifikasi ke email pengguna untuk kemudian menyajikan formulir pembuatan kata sandi baru demi menjaga keamanan akses akun helpdesk.
Segmen 4.16 Verifikasi Token Pengubahan Sandi
1	Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset'); 
2	Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.store'); 

Segmen 4.16 menunjukkan potongan rute Laravel Breeze untuk penanganan reset password. Klien mengirim permintaan ubah sandi berbekal token keamanan terenkripsi. Sisi server memverifikasi token tersebut terhadap tabel password_reset_tokens sebelum mengizinkan proses pembaharuan password di tabel users.
4.2 Pengujian Sistem
Pengujian sistem bertujuan untuk mengevaluasi fungsionalitas dan kinerja sistem helpdesk chatbot AI berdasarkan kriteria kelayakan yang telah ditetapkan. Pengujian ini dibagi menjadi dua tahap, yaitu pengujian Black Box untuk menguji aspek teknis fungsionalitas sistem, dan pengujian User Acceptance Test (UAT) untuk menilai tingkat penerimaan sistem oleh pengguna akhir.

4.2.1 Pengujian Black Box
Pengujian Black Box dilakukan dengan menguji fungsionalitas setiap modul utama pada aplikasi tanpa memperhatikan detail kode internal program. Pengujian berfokus pada masukan (input) dan keluaran (output) untuk memastikan seluruh proses bisnis berjalan dengan benar. Berikut adalah tabel skenario pengujian Black Box:

Tabel 4.X Pengujian Black Box Modul Autentikasi (Login)
ID Test	Skenario Pengujian	Hasil yang Diharapkan (Expected)	Hasil Aktual	Kesimpulan
TC-01	Mengisi email dan password yang valid	Sistem mengarahkan user ke halaman dashboard sesuai role masing-masing	Sesuai dengan yang diharapkan	Valid
TC-02	Mengisi email atau password yang salah	Sistem menolak akses dan menampilkan pesan error	Sesuai dengan yang diharapkan	Valid
TC-03	Mengosongkan form login lalu submit	Sistem menampilkan validasi required	Sesuai dengan yang diharapkan	Valid
Tabel 4.X Pengujian Black Box Modul Pengguna (User)
ID Test	Skenario Pengujian	Hasil yang Diharapkan (Expected)	Hasil Aktual	Kesimpulan
TC-04	User membuka menu Buat Tiket	Sistem menampilkan form pengisian tiket	Sesuai dengan yang diharapkan	Valid
TC-05	User submit tiket dengan data lengkap	Sistem menyimpan tiket dan memberikan notifikasi	Sesuai dengan yang diharapkan	Valid
TC-06	User berinteraksi dengan Chatbot AI	AI memberikan jawaban sesuai permasalahan	Sesuai dengan yang diharapkan	Valid
TC-07	User membuat tiket otomatis dari Chatbot	Sistem membuat draft tiket dari hasil percakapan	Sesuai dengan yang diharapkan	Valid
TC-08	User melihat riwayat tiket	Sistem menampilkan daftar tiket milik user	Sesuai dengan yang diharapkan	Valid
TC-09	User membalas pesan pada tiket	Sistem menyimpan balasan dan mengirim notifikasi	Sesuai dengan yang diharapkan	Valid
Tabel 4.X Pengujian Black Box Modul Teknisi (Support)
ID Test	Skenario Pengujian	Hasil yang Diharapkan (Expected)	Hasil Aktual	Kesimpulan
TC-10	Teknisi melihat daftar tiket masuk	Sistem menampilkan seluruh tiket yang belum selesai	Sesuai dengan yang diharapkan	Valid
TC-11	Teknisi mengambil tiket (Assign)	Status tiket berubah menjadi Progress	Sesuai dengan yang diharapkan	Valid
TC-12	Teknisi melihat detail tiket	Sistem menampilkan detail tiket dan rekomendasi AI	Sesuai dengan yang diharapkan	Valid
TC-13	Teknisi mengubah status tiket menjadi Resolved	Sistem menyimpan status dan membuat ringkasan solusi AI	Sesuai dengan yang diharapkan	Valid
Tabel 4.X Pengujian Black Box Modul Administrator
ID Test	Skenario Pengujian	Hasil yang Diharapkan (Expected)	Hasil Aktual	Kesimpulan
TC-14	Admin melihat dashboard laporan	Sistem menampilkan statistik tiket secara akurat	Sesuai dengan yang diharapkan	Valid
TC-15	Admin melihat performa teknisi	Sistem menampilkan jumlah tiket yang diselesaikan teknisi	Sesuai dengan yang diharapkan	Valid
TC-16	Admin mengubah role pengguna	Hak akses pengguna diperbarui sesuai role baru	Sesuai dengan yang diharapkan	Valid
TC-17	Admin menghapus akun pengguna	Akun berhasil dihapus dari sistem	Sesuai dengan yang diharapkan	Valid
Tabel 4.X Rekapitulasi Hasil Pengujian Black Box
Keterangan	Jumlah
Total Skenario Pengujian	17
Berhasil (Valid)	17
Gagal (Tidak Valid)	0
Persentase Keberhasilan	100%

4.2.2 Pengujian User Acceptance Test (UAT)

Pengujian User Acceptance Test (UAT) dilakukan untuk mengevaluasi apakah sistem yang dibangun telah memenuhi kebutuhan dan harapan pengguna akhir (end-user). Pengujian ini melibatkan responden dari dua kelompok aktor utama, yakni user (pelanggan) dan support (teknisi). Setiap responden diminta untuk menjalankan skenario pengujian yang telah ditentukan dan memberikan penilaian terhadap hasil yang diperoleh.

Penilaian UAT menggunakan skala Likert 1-5 dengan kategori sebagai berikut:
- 5 = Sangat Setuju (SS)
- 4 = Setuju (S)
- 3 = Netral (N)
- 2 = Tidak Setuju (TS)
- 1 = Sangat Tidak Setuju (STS)

Tabel 4.X User Acceptance Test Aktor User (Pelanggan)
No	Pernyataan Pengujian	SS (5)	S (4)	N (3)	TS (2)	STS (1)	Rata-Rata
1	Proses registrasi dan login ke sistem mudah dilakukan	3	2	0	0	0	4.6
2	Halaman dashboard menampilkan ringkasan tiket (open, progress, resolved, closed) dengan akurat	3	2	0	0	0	4.6
3	Form pembuatan tiket baru mudah dipahami dan diisi	4	1	0	0	0	4.8
4	Sistem berhasil menyimpan tiket baru dan memberikan notifikasi konfirmasi	3	2	0	0	0	4.6
5	Daftar riwayat tiket dapat difilter berdasarkan status, prioritas, dan kategori dengan mudah	3	2	0	0	0	4.6
6	Chatbot AI memberikan jawaban yang relevan terhadap permasalahan IT yang ditanyakan	3	1	1	0	0	4.4
7	Fitur analisis percakapan chatbot berhasil menghasilkan draf tiket secara otomatis	3	1	1	0	0	4.4
8	Fitur diskusi obrolan pada tiket memudahkan komunikasi dengan teknisi	3	2	0	0	0	4.6
9	Notifikasi status tiket diterima dengan tepat waktu dan informatif	3	2	0	0	0	4.6
10	Tampilan antarmuka sistem secara keseluruhan nyaman dan mudah digunakan	4	1	0	0	0	4.8

Tabel 4.X User Acceptance Test Aktor Teknisi (Support)
No	Pernyataan Pengujian	SS (5)	S (4)	N (3)	TS (2)	STS (1)	Rata-Rata
1	Dashboard support menampilkan statistik tiket secara akurat dan informatif	3	2	0	0	0	4.6
2	Daftar seluruh tiket masuk dari semua user ditampilkan dengan lengkap dan dapat difilter	3	2	0	0	0	4.6
3	Proses self-assign tiket berjalan dengan benar dan status tiket otomatis berubah menjadi progress	4	1	0	0	0	4.8
4	Analisis AI pada halaman detail tiket (ringkasan, penyebab, rekomendasi) membantu proses identifikasi masalah	3	1	1	0	0	4.4
5	Fitur mengubah status dan prioritas tiket berfungsi sesuai alur yang ditentukan	4	1	0	0	0	4.8
6	Ringkasan penyelesaian (resolution summary) yang dibuat AI secara otomatis sudah tepat dan informatif	3	1	1	0	0	4.4
7	Fitur diskusi obrolan pada tiket memudahkan koordinasi dengan user	3	2	0	0	0	4.6
8	Riwayat perubahan status tiket (ticket history) tercatat dengan lengkap dan akurat	4	1	0	0	0	4.8
9	Tampilan antarmuka untuk penanganan tiket secara keseluruhan nyaman dan efisien digunakan	4	1	0	0	0	4.8

Tabel 4.X Rekapitulasi Hasil User Acceptance Test (UAT)
Aktor	Jumlah Pernyataan	Rata-Rata Skor
User (Pelanggan)	10	4.60
Teknisi (Support)	9	4.64
Rata-Rata Keseluruhan	19	4.62

Berdasarkan hasil pengujian User Acceptance Test (UAT), diperoleh rata-rata skor keseluruhan sebesar 4.62 dari skala 5.00 yang termasuk dalam kategori Sangat Baik. Hasil ini menunjukkan bahwa sistem IT Helpdesk Chatbot AI yang dibangun telah memenuhi kebutuhan dan harapan pengguna akhir, baik dari sisi user maupun teknisi.

Interpretasi kategori skor rata-rata:
- 4.21 - 5.00 = Sangat Baik
- 3.41 - 4.20 = Baik
- 2.61 - 3.40 = Cukup
- 1.81 - 2.60 = Kurang
- 1.00 - 1.80 = Sangat Kurang

4.3 Pembahasan

Pembahasan hasil penelitian ini difokuskan pada analisis efektivitas implementasi Sistem Helpdesk Chatbot AI berbasis web dan kontribusinya terhadap peningkatan efisiensi penanganan kendala IT di lingkungan instansi/organisasi. Analisis dilakukan dengan menghubungkan hasil pengujian Black Box dan User Acceptance Test (UAT) dengan teori serta tujuan perancangan sistem.

4.3.1 Analisis Fungsionalitas Sistem (Black Box)
Berdasarkan hasil pengujian Black Box yang ditunjukkan pada sub-bab sebelumnya, persentase keberhasilan sistem mencapai 100% (17 skenario valid dari total 17 skenario uji). Hasil ini menunjukkan bahwa:
1. Logika otorisasi multi-role (User, Support, Admin) telah terimplementasi dengan aman. Pengguna dialihkan ke rute dashboard masing-masing secara otomatis pasca-autentikasi.
2. Relasi basis data berjalan stabil, terutama penanganan penghapusan data pengguna (User Deletion) di mana sistem menerapkan foreign key nullable pada kolom user_id di tabel tickets, sehingga riwayat laporan tiket tetap terjaga meskipun akun pelapor dihapus.
3. Penanganan integrasi eksternal (API OpenRouter) telah dilengkapi dengan mekanisme error handling (fallback regex). Jika API Gemini/OpenRouter mengalami kegagalan koneksi atau limit kuota, sistem beralih ke pencocokan pola kata kunci (Regular Expression) untuk tetap memberikan jawaban operasional dasar kepada pengguna.

4.3.2 Analisis Penerimaan Pengguna (User Acceptance Test)
Hasil pengujian UAT dari 5 responden menunjukkan tingkat penerimaan rata-rata sebesar 4.62 (skala 5.00) dengan kategori "Sangat Baik". Distribusi kepuasan dinilai berdasarkan peran aktor pengguna:
1. **Aktor User (Pelanggan)** memberikan skor rata-rata 4.60. Nilai tertinggi diperoleh pada kemudahan form pembuatan tiket baru dan estetika desain antarmuka (4.8). Fitur yang dinilai masih memerlukan peningkatan adalah akurasi pemahaman draf tiket otomatis chatbot AI (4.4), yang dipengaruhi oleh variabilitas gaya penulisan bahasa pengguna saat berinteraksi dengan AI.
2. **Aktor Teknisi (Support)** memberikan skor rata-rata 4.64. Nilai tertinggi diperoleh pada fungsionalitas self-assign tiket, kemudahan alur perubahan status, dan rekam jejak riwayat tiket (4.8). Teknisi merasa terbantu dengan adanya panel analisis AI (ringkasan masalah, dugaan penyebab, dan rekomendasi solusi) yang meminimalkan waktu investigasi awal kendala di lapangan.

4.3.3 Kontribusi Fitur Kecerdasan Buatan (AI)
Penerapan Gemini AI melalui OpenRouter memberikan dampak signifikan pada siklus hidup helpdesk:
1. **Triage Otomatis (First-Level Support)**: Chatbot AI mampu menangani kendala IT umum pengguna secara mandiri 24/7. Hal ini mereduksi beban kerja teknisi agar dapat berfokus pada masalah hardware/jaringan yang lebih kritis di lapangan.
2. **Standardisasi Dokumentasi (Resolution Summary)**: Ketika tiket diselesaikan (resolved/closed), AI secara otomatis merangkum riwayat obrolan dan catatan perbaikan teknisi menjadi format laporan yang seragam. Dokumentasi ini secara otomatis memperkaya basis pengetahuan (Knowledge Base) untuk mempermudah penanganan kasus serupa di masa mendatang.
3. **Efisiensi Waktu Penanganan**: Integrasi fitur analisis draf tiket otomatis dari obrolan chatbot mempercepat proses pelaporan tiket oleh pengguna tanpa perlu mengisi formulir panjang secara manual dari awal.

