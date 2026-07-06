Implementasi Antarmuka  
Salah satu langkah dalam memenuhi kebutuhan pengguna untuk berinteraksi dengan sistem yang dibuat adalah implementasi antarmuka. Antarmuka yang baik akan membantu pengguna memahami proses yang sedang dilakukan sistem, sehingga sistem dapat bekerja lebih baik.
59 

4.1.3.1 Halaman Dashboard User 
Gambar 4.9 Halaman Dashboard User 
Halaman dashboard user pada Gambar 4.9 adalah tampilan awal yang akan muncul setelah aktor user (pelanggan) berhasil melakukan proses login. Tampilan ini menyajikan statistik ringkasan tiket yang dimiliki oleh user tersebut berdasarkan status tiket (open, progress, resolved, closed) dan prioritas penanganan (low, medium, high), serta menampilkan daftar 5 tiket pengaduan terbaru milik user.
60 
Segmen 4.1 Dashboard User 
@extends('layouts.app') 
@section('content') 
<div class="py-12"> 
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8"> 
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6"> 
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6"> 
                <div class="text-sm font-medium text-gray-500">Tiket Terbuka</div> 
                <div class="text-3xl font-semibold">{{ $ticketsByStatus['open'] }}</div> 
            </div> 
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6"> 
                <div class="text-sm font-medium text-gray-500">Sedang Diproses</div> 
                <div class="text-3xl font-semibold">{{ $ticketsByStatus['progress'] }}</div> 
            </div> 
        </div> 
    </div> 
</div> 
@endsection 
Segmen 4.1 kode ini merupakan bagian dari tampilan halaman dashboard user. Penggunaan @extends('layouts.app') berfungsi sebagai master layout untuk menjaga konsistensi elemen visual seperti header, navigasi, dan footer. Pada bagian @section('content'), statistik jumlah tiket user diakses dari variabel $ticketsByStatus untuk ditampilkan dalam bentuk kartu grid yang responsif.

4.1.3.2 Halaman Daftar Tiket User 
Gambar 4.10 Halaman Daftar Tiket User 
Tampilan halaman pada Gambar 4.10 menampilkan seluruh riwayat tiket kendala yang diajukan oleh user. Halaman ini dilengkapi dengan fitur penyaringan (filter) berdasarkan status tiket, prioritas, kategori masalah, serta tanggal pembuatan tiket. Dengan adanya pagination, data tiket disajikan sebanyak 15 data per halaman agar memudahkan navigasi pengguna.
61 
Segmen 4.2 Halaman Daftar Tiket User
public function index(Request $request) 
{ 
    if (auth()->user()->role === 'support') { 
        return redirect()->route('support.tickets'); 
    } 
    $filterStatus = $request->query('status'); 
    $filterPriority = $request->query('priority'); 
    $filterCategory = $request->query('category'); 
    $ticketsQuery = Ticket::with(['user', 'assignedSupport'])->latest(); 
    if (auth()->user()->role !== 'admin') { 
        $ticketsQuery->where('user_id', auth()->id()); 
    } 
    $tickets = $ticketsQuery->paginate(15)->appends($request->query()); 
    $categories = Ticket::select('category')->distinct()->orderBy('category')->pluck('category'); 
    return view('tickets.index', compact('tickets', 'categories')); 
} 
Pada Segmen 4.2 menjelaskan kode pengendali (controller) untuk menampilkan halaman daftar tiket. Fungsi index() akan memverifikasi peran pengguna terlebih dahulu. Jika pengguna adalah support, sistem akan mengarahkannya ke halaman tiket support. Sementara itu, untuk user biasa, query database dibatasi hanya untuk mengambil tiket milik mereka sendiri sebelum akhirnya dikirimkan ke blade views untuk dirender.

4.1.3.3 Halaman Pembuatan Tiket Baru 
Gambar 4.11 Halaman Pembuatan Tiket Baru 
Pada gambar 4.11 menampilkan formulir pembuatan tiket baru yang diakses oleh user. Formulir ini meminta input subjek masalah, deskripsi kendala secara detail, pemilihan kategori (Hardware, Software, Jaringan, Akun, Lainnya), serta opsi unggah berkas lampiran pendukung berupa foto atau gambar.
62 
Segmen 4.3 Form Pembuatan Tiket 
<form action="{{ route('tickets.store') }}" method="POST" enctype="multipart/form-data"> 
    @csrf 
    <div class="mb-4"> 
        <label for="subject">Subjek Masalah</label> 
        <input type="text" name="subject" id="subject" required class="form-input"> 
    </div> 
    <div class="mb-4"> 
        <label for="category">Kategori</label> 
        <select name="category" id="category" required class="form-select"> 
            <option value="Hardware">Hardware</option> 
            <option value="Software">Software</option> 
            <option value="Jaringan">Jaringan</option> 
            <option value="Akun">Akun</option> 
            <option value="Lainnya">Lainnya</option> 
        </select> 
    </div> 
    <div class="mb-4"> 
        <label for="attachment">Lampiran Gambar (Opsional)</label> 
        <input type="file" name="attachment" id="attachment" accept="image/*"> 
    </div> 
    <button type="submit" class="btn-submit">Kirim Tiket</button> 
</form> 
Segmen 4.3 menampilkan rancangan formulir Blade HTML untuk mengunggah tiket. Atribut enctype="multipart/form-data" digunakan agar form dapat memproses unggahan file gambar lampiran secara aman. Validasi masukan dilakukan di sisi server untuk memastikan semua data wajib terisi sesuai format.

4.1.3.4 Halaman Detail Tiket & Analisis AI 
Gambar 4.12 Halaman Detail Tiket & Analisis AI 
Halaman detail tiket pada Gambar 4.12 menampilkan rincian dari satu tiket kendala terpilih. Pada halaman ini, staff teknisi dan admin dapat melihat data laporan pengguna beserta visualisasi analisis AI secara real-time yang bersumber dari API OpenRouter. AI akan menyajikan ringkasan masalah, dugaan penyebab, rekomendasi solusi, serta persentase keyakinan (confidence).
63 
Segmen 4.4 Detail Tiket & Rekomendasi AI 
@if($ticket->ai_summary) 
<div class="bg-blue-50 p-4 rounded-lg mb-6 border border-blue-200"> 
    <h3 class="text-lg font-medium text-blue-800">Analisis Otomatis AI Helpdesk</h3> 
    <p><strong>Ringkasan Masalah:</strong> {{ $ticket->ai_summary }}</p> 
    <p><strong>Kemungkinan Penyebab:</strong></p> 
    <div class="text-sm text-gray-700">{!! nl2br(e($ticket->ai_causes)) !!}</div> 
    <p><strong>Rekomendasi Penanganan:</strong></p> 
    <div class="text-sm text-gray-700">{!! nl2br(e($ticket->ai_recommendations)) !!}</div> 
    <p><strong>Tingkat Keyakinan AI:</strong> <span class="badge">{{ $ticket->ai_confidence }}</span></p> 
</div> 
@endif 
Segmen 4.4 menjelaskan kode tampilan detail tiket yang memproses render bersyarat (@if) untuk menampilkan analisis AI. Apabila kolom `ai_summary` pada tabel tickets terisi, sistem akan mencetak panel analisis terstruktur dengan styling khusus untuk mempermudah teknisi dalam mengidentifikasi masalah secara cepat.

4.1.3.5 Halaman Diskusi Tiket (Obrolan Detail) 
Gambar 4.13 Halaman Diskusi Tiket 
Di dalam halaman detail tiket terdapat modul obrolan diskusi seperti terlihat pada Gambar 4.13. Modul ini difungsikan agar pembuat tiket (user), teknisi yang ditugaskan, dan administrator dapat melakukan tanya jawab secara interaktif guna mempercepat koordinasi pemecahan masalah teknis.
64 
Segmen 4.5 Pengiriman Pesan Obrolan Tiket 
public function storeMessage(Request $request, $id) 
{ 
    $request->validate(['message' => 'required|string|max:1000']); 
    $ticket = Ticket::findOrFail($id); 
    $user = auth()->user(); 
    if ($ticket->user_id !== $user->id && $user->role !== 'support' && $user->role !== 'admin') { 
        abort(403, 'Anda tidak memiliki akses ke tiket ini.'); 
    } 
    $msg = TicketMessage::create([ 
        'ticket_id' => $ticket->id, 
        'user_id'   => $user->id, 
        'message'   => $request->message, 
    ]); 
    return redirect()->route('tickets.show', $ticket->id)->with('success', 'Pesan berhasil dikirim.'); 
} 
Pada Segmen 4.5 menjelaskan logika controller untuk menyimpan pesan diskusi baru. Metode storeMessage() melakukan pengecekan otorisasi ketat guna memastikan hanya aktor yang berhak (pemilik tiket, teknisi pemroses, atau admin) yang dapat menyisipkan rekaman ke dalam tabel `ticket_messages`, diikuti dengan pengiriman notifikasi otomatis kepada pihak terkait.

4.1.3.6 Halaman Chatbot AI (Konsultasi Mandiri) 
Gambar 4.14 Halaman Chatbot AI 
Halaman Chatbot AI pada Gambar 4.14 memfasilitasi user untuk melakukan konsultasi masalah IT secara mandiri dengan asisten cerdas Gemini AI. Jika AI sedang tidak terjangkau (karena limitasi API), sistem mengaktifkan mekanisme fallback berbasis ekspresi reguler (regex) untuk mencocokkan kata kunci teknologi spesifik. Selain itu, terdapat tombol "Analisis Percakapan" untuk memproses riwayat obrolan menjadi sebuah draf tiket pengaduan secara instan.
65 
Segmen 4.6 Pemrosesan Chatbot dan Fallback Regex 
private function getFallbackResponse(string $message): string 
{ 
    $message = strtolower($message); 
    $fallbacks = [ 
        '/\b(wifi|internet|jaringan|koneksi|sinyal|lemot|lag)\b/i' => 
            "Sepertinya Anda mengalami masalah koneksi. Coba langkah berikut:\n1. Pastikan WiFi Anda menyala.\n2. Coba restart router atau modem Anda.", 
        '/\b(error|bug|masalah|rusak|gagal|crash|freeze)\b/i' => 
            "Jelaskan lebih detail tentang error atau masalah teknis yang Anda hadapi. Berikan informasi seperti: pesan error dan kapan terjadi.", 
    ]; 
    foreach ($fallbacks as $pattern => $response) { 
        if (preg_match($pattern, $message)) { 
            return $response; 
        } 
    } 
    return "Maaf, sepertinya saya sedang mengalami gangguan koneksi ke server AI utama. Silakan coba tanyakan lagi."; 
} 
Segmen 4.6 ini diimplementasikan di dalam `ChatbotController` sebagai pengaman apabila koneksi OpenRouter mengalami kendala. Logika mencocokkan input masukan pengguna dengan kata kunci kunci menggunakan fungsi preg_match() PHP. Apabila kecocokan pola ditemukan, pesan petunjuk standar akan langsung dikirim kembali ke antarmuka user.

4.1.3.7 Halaman Form Login & Autentikasi 
Gambar 4.15 Halaman Form Login 
Halaman login pada Gambar 4.15 adalah gerbang utama otentikasi pengakses sistem. Formulir ini memvalidasi kombinasi email dan password unik pengguna. Setelah proses verifikasi sukses, sistem akan mengarahkan pengguna ke rute dashboard masing-masing sesuai dengan peran yang terdaftar di database.
66 
Segmen 4.7 Rute Pengalihan Login Berdasarkan Role 
Route::get('/dashboard', function () { 
    $user = auth()->user(); 
    if ($user->role === 'admin') { 
        return redirect()->route('admin.dashboard'); 
    } 
    if ($user->role === 'support') { 
        return redirect()->route('dashboard.support'); 
    } 
    return redirect()->route('dashboard.user'); 
})->middleware(['auth', 'verified'])->name('dashboard'); 
Segmen kode pada Segmen 4.7 ini mengelola pengalihan pengguna yang berhasil login. Pengecekan middleware `auth` dan `verified` memastikan sesi pengguna valid. Perbedaan logika peran diuji menggunakan struktur kondisi if untuk menentukan apakah pengguna diarahkan ke dashboard admin, support, atau user.

4.1.3.8 Halaman Form Registrasi Pengguna Baru 
Gambar 4.16 Halaman Form Registrasi 
Halaman registrasi memfasilitasi pembuatan akun pengguna baru agar dapat mengakses fitur helpdesk. Formulir ini meminta nama lengkap, email unik, kata sandi, dan konfirmasi kata sandi. Secara sistem, setiap akun baru yang didaftarkan melalui halaman ini akan otomatis mendapatkan peran awal (role) sebagai 'user'.
67 
Segmen 4.8 Validasi Pendaftaran Akun 
protected function validator(array $data) 
{ 
    return Validator::make($data, [ 
        'name' => ['required', 'string', 'max:255'], 
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'], 
        'password' => ['required', 'string', 'min:8', 'confirmed'], 
    ]); 
} 
Segmen 4.8 ini menguraikan fungsi validator pendaftaran bawaan sistem Laravel. Aturan 'unique:users' memvalidasi agar tidak ada email ganda di dalam tabel users, sedangkan aturan 'confirmed' memastikan masukan konfirmasi sandi sama persis dengan kolom password utama.

4.1.3.9 Halaman Dashboard Support (Teknisi) 
Gambar 4.17 Halaman Dashboard Support 
Halaman utama bagi aktor support (teknisi) ditampilkan pada Gambar 4.17. Dasbor ini menyajikan visualisasi data statistik yang komprehensif, mencakup jumlah tiket aktif, statistik tiket per status, tingkat prioritas tiket, kategori kerusakan terbanyak, jumlah tiket yang belum ditugaskan (unassigned), serta ringkasan tiket yang baru masuk.
68 
Segmen 4.9 Statistik Tiket pada Dashboard Support 
public function supportDashboard() 
{ 
    $totalTickets = Ticket::count(); 
    $ticketsByStatus = [ 
        'open' => Ticket::where('status', 'open')->count(), 
        'progress' => Ticket::where('status', 'progress')->count(), 
        'resolved' => Ticket::where('status', 'resolved')->count(), 
        'closed' => Ticket::where('status', 'closed')->count(), 
    ]; 
    $unassignedTickets = Ticket::where('status', 'open')->whereNull('assigned_to')->count(); 
    $recentTickets = Ticket::latest()->take(5)->get(); 
    return view('dashboard.support', compact('totalTickets', 'ticketsByStatus', 'unassignedTickets', 'recentTickets')); 
} 
Segmen 4.9 menjelaskan fungsi supportDashboard() di dalam `DashboardController`. Data statistik dihitung menggunakan agregasi Eloquent `count()` dari tabel tickets berdasarkan status dan penugasan teknisi. Data ini dipasok ke view `dashboard.support` untuk ditampilkan sebagai panel informasi penanganan harian teknisi.

4.1.3.10 Halaman Daftar Seluruh Tiket Masuk 
Gambar 4.18 Halaman Daftar Tiket Masuk 
Halaman ini menampilkan seluruh daftar tiket pengaduan yang masuk dari seluruh user di dalam database seperti terlihat pada Gambar 4.18. Halaman ini dapat diakses oleh teknisi dan admin untuk memantau beban antrean tiket kendala secara menyeluruh.
69 
Segmen 4.10 Pengambilan Tiket Masuk 
public function all(Request $request) 
{ 
    $filterStatus = $request->query('status'); 
    $ticketsQuery = Ticket::with(['user', 'assignedSupport'])->latest(); 
    if ($filterStatus) { 
        $ticketsQuery->where('status', $filterStatus); 
    } 
    $tickets = $ticketsQuery->paginate(15)->appends($request->query()); 
    $categories = Ticket::select('category')->distinct()->orderBy('category')->pluck('category'); 
    return view('support.tickets', compact('tickets', 'categories')); 
} 
Segmen 4.10 menunjukkan implementasi fungsi all() untuk mengambil seluruh data tiket di sistem. Relasi database `user` dan `assignedSupport` dipanggil dengan metode eager loading `with()` agar meminimalisir kueri ke database (N+1 query problem) saat mencetak daftar tiket di halaman support.

4.1.3.11 Halaman Penugasan Tiket (Self-Assign) 
Gambar 4.19 Halaman Penugasan Tiket 
Untuk menangani masalah yang masuk, teknisi dapat memilih tombol penugasan tiket pada halaman detail tiket seperti Gambar 4.19. Tindakan ini memicu pembaruan kolom `assigned_to` pada tiket menjadi ID teknisi yang sedang login dan otomatis mengubah status tiket dari `open` menjadi `progress`.
70 
Segmen 4.11 Proses Self-Assign Tiket 
public function assign(Request $request, $id) 
{ 
    $request->validate([ 
        'assigned_to' => 'required|in:' . auth()->id(), 
    ], [ 
        'assigned_to.in' => 'Anda hanya dapat menugaskan tiket untuk diri Anda sendiri.', 
    ]); 
    $ticket = Ticket::findOrFail($id); 
    $ticket->assigned_to = auth()->id(); 
    $ticket->status = 'progress'; 
    $ticket->save(); 
    if ($ticket->user) { 
        $ticket->user->notify(new TicketAssignedNotification($ticket, auth()->user())); 
    } 
    return redirect()->route('support.tickets')->with('success', 'Tiket berhasil ditugaskan ke diri Anda sendiri.'); 
} 
Segmen 4.11 di atas adalah fungsi assign() di dalam `TicketController`. Validasi `'in:' . auth()->id()` memastikan teknisi hanya bisa mengklaim tiket untuk dirinya sendiri. Setelah data berhasil disimpan ke database, notifikasi `TicketAssignedNotification` dikirimkan secara otomatis ke email atau dasbor user pembuat tiket.

4.1.3.12 Halaman Pembaruan Tiket & AI Resolution 
Gambar 4.20 Halaman Pembaruan Tiket 
Teknisi diberikan hak untuk memperbarui status penanganan tiket (open, progress, resolved, closed), mengubah skala prioritas, serta memasukkan catatan akhir. Saat status tiket diubah menjadi `resolved` atau `closed`, sistem memanggil OpenRouter secara otomatis untuk menyusun ringkasan penyelesaian (resolution summary) berdasarkan riwayat chat tiket tersebut.
71 
Segmen 4.12 Pembaruan Status dan AI Resolution Summary 
if (in_array($request->status, ['resolved', 'closed']) && empty($ticket->resolution_summary)) { 
    $ticket->resolution_summary = $this->generateResolutionSummary($ticket, $request->notes); 
} 
$ticket->save(); 
TicketHistory::create([ 
    'ticket_id' => $ticket->id, 
    'user_id' => auth()->id(), 
    'old_status' => $oldStatus, 
    'new_status' => $request->status, 
    'notes' => $finalNotes ?: null, 
]); 
Segmen 4.12 memaparkan sebagian logika pembaruan tiket. Ketika status penyelesaian dicapai, fungsi pembantu `generateResolutionSummary` dieksekusi. Selanjutnya, riwayat perubahan ini disimpan ke dalam tabel `ticket_histories` sebagai log audit pelacakan kinerja teknisi.

4.1.3.13 Halaman Dashboard Admin 
Gambar 4.21 Halaman Dashboard Admin 
Halaman utama administrator pada Gambar 4.21 menyajikan ringkasan administratif global. Admin dapat memantau statistik total seluruh tiket, sebaran kategori, prioritas masalah, serta daftar seluruh pengguna sistem yang dibagi berdasarkan peran (user biasa, staff support, dan administrator).
72 
Segmen 4.13 Tampilan Data Pengguna pada Dashboard Admin 
public function index(): View 
{ 
    $users = User::where('role', 'user')->get(); 
    $supportStaff = User::where('role', 'support')->get(); 
    $admins = User::where('role', 'admin')->get(); 
    $totalTickets = Ticket::count(); 
    return view('admin.dashboard', compact('users', 'supportStaff', 'admins', 'totalTickets')); 
} 
Segmen 4.13 menunjukkan pemrosesan dashboard admin di dalam `AdminController`. Fungsi index() mengambil semua data pengguna dari tabel users yang dikelompokkan sesuai dengan perannya (`role`) untuk dipetakan ke dalam tabel kelola akun pada view admin.

4.1.3.14 Halaman Kelola Data Pengguna (Manajemen Akun) 
Gambar 4.22 Halaman Kelola Data Pengguna 
Sebagai pemegang otoritas tertinggi, admin dapat mengelola akun pengguna pada halaman Gambar 4.22. Aksi yang dapat dilakukan oleh admin meliputi penyesuaian hak akses role pengguna (misal menaikkan user menjadi support) serta penghapusan akun pengguna dari basis data.
73 
Segmen 4.14 Logika Penghapusan Akun Pengguna 
public function deleteUser(Request $request, User $user): RedirectResponse 
{ 
    if ($user->id === auth()->id()) { 
        return redirect()->route('admin.dashboard')->with('error', 'Anda tidak dapat menghapus akun admin Anda sendiri.'); 
    } 
    $user->delete(); 
    return redirect()->route('admin.dashboard')->with('status', 'Pengguna berhasil dihapus.'); 
} 
Segmen 4.14 menunjukkan metode deleteUser() di dalam `AdminController`. Terdapat logika pengaman penting yang mencegah admin untuk tidak sengaja menghapus akun miliknya sendiri yang sedang aktif digunakan untuk login.

4.1.3.15 Halaman Laporan & Statistik Kinerja 
Gambar 4.23 Halaman Laporan 
Halaman laporan pada Gambar 4.23 membantu admin menganalisis kinerja helpdesk. Halaman ini memuat visualisasi statistik kinerja teknisi (jumlah tiket yang ditugaskan, diselesaikan, dan diproses), tren jumlah tiket bulanan selama 6 bulan terakhir, serta tabel kueri tiket terfilter yang dapat dicetak atau diekspor.
74 
Segmen 4.15 Agregasi Kinerja Bulanan dan Teknisi 
$supportStaff = User::where('role', 'support')->get()->map(function ($staff) { 
    $staff->assigned_count = Ticket::where('assigned_to', $staff->id)->count(); 
    $staff->resolved_count = Ticket::where('assigned_to', $staff->id)->whereIn('status', ['resolved', 'closed'])->count(); 
    return $staff; 
}); 
$monthlyData = []; 
for ($i = 5; $i >= 0; $i--) { 
    $date = Carbon::now()->subMonths($i); 
    $monthlyData[] = [ 
        'month' => $date->translatedFormat('M Y'), 
        'total' => Ticket::whereYear('created_at', $date->year)->whereMonth('created_at', $date->month)->count(), 
    ]; 
} 
Segmen 4.15 merupakan logika pengolahan data laporan pada `ReportController`. Fungsi memetakan daftar staf support menggunakan penambahan atribut kustom (`assigned_count`, `resolved_count`) serta mengumpulkan data kuantitatif bulanan menggunakan perulangan Carbon untuk disajikan dalam bentuk grafik tren bulanan.
76 

4.1.3.16 Halaman Reset Password 
Gambar 4.24 Halaman Reset Password 
Halaman reset password pada Gambar 4.24 diakses dari tautan "Lupa Password" pada halaman login. Halaman ini memproses pengiriman token verifikasi ke email pengguna untuk kemudian menyajikan formulir pembuatan kata sandi baru demi menjaga keamanan akses akun helpdesk.
78 
Segmen 4.16 Verifikasi Token Pengubahan Sandi 
Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset'); 
Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.store'); 
Segmen 4.16 menunjukkan potongan rute Laravel Breeze untuk penanganan reset password. Klien mengirim permintaan ubah sandi berbekal token keamanan terenkripsi. Sisi server memverifikasi token tersebut terhadap tabel password_reset_tokens sebelum mengizinkan proses pembaharuan password di tabel users.