# Analisis Kritis Skripsi
## "Integrasi API Chatbot Berbasis Artificial Intelligence pada Sistem Helpdesk Ticketing Berbasis Web"

---

## A. Ringkasan Penilaian Keseluruhan

**Kelebihan penelitian:**
- Topik relevan dan aplikatif — integrasi AI pada helpdesk adalah kebutuhan nyata industri.
- Struktur BAB I–IV lengkap, alur Waterfall dijelaskan runtut.
- Literature review (Tabel 2.1) sudah menyertakan kolom "Gap Penelitian" yang eksplisit — ini bagus, jarang dilakukan mahasiswa.
- Implementasi kode (Laravel/Blade/Eloquent) ditampilkan cukup detail dan relevan dengan pembahasan, bukan sekadar tempelan.
- Sudah ada mekanisme fallback (regex keyword matching) saat API OpenRouter gagal — menunjukkan pemikiran mitigasi risiko yang matang.

**Kekurangan penelitian:**
- Fitur unggulan yang menjadi **pembeda utama terhadap penelitian terdahulu** (pencarian/rekomendasi tiket serupa sebagai *knowledge base*) disebutkan di BAB I, BAB II (gap penelitian), dan BAB III (kebutuhan fungsional #9 + flowchart), tetapi **tidak pernah ditunjukkan implementasinya di BAB IV**. Ini adalah temuan paling kritis.
- Ditemukan kontradiksi angka: BAB IV menyebut "17 skenario valid dari 17 skenario uji" (4.3.1) padahal Tabel 4.1 dan rekapitulasi (4.2.3) hanya mencantumkan **11** skenario.
- Muncul **User Acceptance Test (UAT)** dengan skor Likert di BAB IV, padahal Batasan Masalah BAB I secara eksplisit hanya menyebut Blackbox Testing — tidak ada metodologi UAT di BAB III (jumlah responden, instrumen, indikator penilaian). Ini scope creep yang tidak dijustifikasi.
- Penomoran gambar dan sub-bab tidak konsisten (beberapa nomor gambar dipakai dua kali; sub-bab 4.1.3.x menggantung di bawah heading 4.3).
- Beberapa desain database punya potensi masalah integritas data (cascade delete yang bertentangan dengan klaim di pembahasan).
- Validasi dan keamanan (self-assign race condition, upload file, kontrol akses berbasis role) masih longgar dan belum diuji.

**Tingkat kesiapan skripsi: ±68%**
Layak lanjut ke tahap revisi terarah sebelum sidang, namun **belum siap sidang** dalam kondisi saat ini karena ada gap fungsional inti yang kemungkinan besar akan langsung ditanyakan penguji ("mana implementasi pencarian kasus serupa yang Anda janjikan di BAB I?").

---

## B. Temuan per BAB

### BAB I

**Temuan:**
1. Rumusan Masalah #3 menyebut tiga sub-tugas asisten AI: (a) analisis tiket, (b) **mencari riwayat tiket serupa**, (c) merangkum penyelesaian. Sub-tugas (b) tidak pernah dibuktikan implementasinya di BAB IV.
2. Batasan Masalah #8 membatasi pengujian hanya pada Blackbox Testing, tetapi BAB IV menambahkan UAT tanpa batasan/metodologi yang jelas — bertentangan dengan batasan yang ditetapkan sendiri.
3. Latar belakang menjelaskan alur AI yang sangat kaya (draf tiket otomatis, knowledge base, resolution summary) — proporsinya jauh lebih besar dibanding apa yang benar-benar terealisasi di BAB IV.

**Dampak:**
- Penguji akan menilai penelitian tidak menjawab rumusan masalahnya sendiri secara tuntas — ini poin fatal dalam sidang, karena rumusan masalah adalah kontrak penelitian.
- Inkonsistensi batasan masalah vs realisasi pengujian menurunkan kredibilitas metodologis keseluruhan naskah.

**Rekomendasi Perbaikan:**
- Jika fitur "kasus serupa" memang sudah dibangun tapi belum didokumentasikan → tambahkan di BAB IV lengkap dengan potongan kode dan gambar antarmuka.
- Jika fitur belum dibangun → revisi Rumusan Masalah, Tujuan, dan Batasan Masalah agar tidak menjanjikan fitur yang tidak direalisasikan, atau cantumkan secara eksplisit sebagai keterbatasan penelitian ("fitur pencarian kasus serupa direncanakan namun tidak termasuk ruang lingkup implementasi").
- Tambahkan poin UAT ke Batasan Masalah dan jelaskan metodenya (jumlah responden, instrumen kuesioner, skala Likert) agar tidak muncul tiba-tiba di BAB IV.

---

### BAB II

**Temuan:**
1. Konsep "Tier 1 / Tier 2" pada 2.2.1 hanya menjelaskan dua tingkatan support, padahal sistem punya 3 role (User, Support, Admin). Posisi Admin dalam skema tier tidak dijelaskan — apakah admin adalah Tier 3 (manajerial) atau tidak termasuk skema tier sama sekali?
2. Tinjauan teori tentang AI (2.2.3) dan API (2.2.4) sudah cukup relevan dan mendukung BAB III, tetapi tidak ada sub-bab teori khusus tentang **konsep knowledge base / case-based reasoning**, padahal ini justru fitur yang diklaim sebagai pembeda riset (lihat Tabel 2.1). Landasan teori tidak selaras dengan klaim kontribusi penelitian.
3. Tabel 2.1 baik secara struktur, tetapi ada baris yang terpotong format tabelnya ("Tabel 2.1 Lanjutan") — ini rapi diselesaikan saat convert ke PDF, hanya perlu dicek ulang saat finalisasi.

**Dampak:**
- Ketiadaan landasan teori knowledge base membuat argumentasi ilmiah "penelitian ini mengisi gap X" menjadi lemah — tidak didukung teori, hanya klaim di narasi.
- Menimbulkan pertanyaan penguji: "Apa dasar teori untuk fitur rekomendasi kasus serupa Anda?"

**Rekomendasi Perbaikan:**
- Tambahkan sub-bab 2.2.x tentang *Case-Based Reasoning* atau *Knowledge Base Management* sebagai landasan untuk fitur rekomendasi tiket serupa.
- Jelaskan posisi Admin secara eksplisit dalam skema tier support (atau nyatakan admin berada di luar skema operasional, murni manajerial/pengelola akun).

---

### BAB III

**Temuan:**
1. **Duplikasi penomoran gambar**: "Gambar 3.2" dipakai untuk *Flowchart Aplikasi Bagian 2* dan juga untuk *Use Case Diagram*. "Gambar 3.7" dipakai untuk *Activity Diagram Penanganan Tiket* dan juga untuk *Sequence Diagram User*. Ini kesalahan penomoran yang akan langsung terlihat oleh penguji.
2. Kebutuhan Fungsional #9 ("melihat rekomendasi kasus serupa... maksimal tiga riwayat") tidak memiliki penjelasan teknis bagaimana pencarian kemiripan dilakukan (berbasis kategori? kemiripan teks/embedding? keyword?). Tidak ada rancangan algoritma di BAB III untuk fitur ini — wajar jika kemudian tidak muncul di BAB IV.
3. Flowchart Bagian 1 menyatakan "Pada metode manual, AI tetap bekerja di latar belakang untuk menganalisis data masukan secara real-time" — namun tidak ada requirement/desain eksplisit yang menjelaskan proses ini (apakah trigger via event Laravel? job queue? sinkron saat submit?).
4. Struktur tabel `ticket_messages` menetapkan **on cascade delete** untuk `user_id`, sementara `tickets.user_id` bersifat *nullable* (agar riwayat tiket tetap ada meski user dihapus). Ini kontradiksi desain: riwayat *diskusi* tiket justru akan ikut terhapus saat user dihapus, padahal tujuan nullable pada tabel tickets adalah menjaga histori.
5. Tidak ada tabel `notifications` pada struktur database (3.7), padahal Kebutuhan Fungsional #11 mensyaratkan notifikasi real-time dan BAB IV menyebut `TicketAssignedNotification` dikirim otomatis.
6. Kolom `category` pada tabel tickets bertipe `varchar` bebas, padahal form hanya mengizinkan 5 pilihan tetap (Hardware, Software, Jaringan, Akun, Lainnya) — sebaiknya `enum` atau tabel referensi terpisah agar konsisten dan tervalidasi di level database, bukan hanya di level form.

**Dampak:**
- Kesalahan penomoran gambar mengesankan kurang teliti dalam proofreading — poin minor tapi sering jadi catatan formal penguji.
- Ketiadaan desain algoritma pencarian kasus serupa menjelaskan mengapa fitur ini "hilang" di implementasi — akar masalah root cause temuan BAB I.
- Kontradiksi cascade delete berpotensi menjadi bug produksi nyata: begitu user dihapus, seluruh histori diskusi tiketnya ikut lenyap, bertentangan dengan tujuan audit trail sistem helpdesk.

**Rekomendasi Perbaikan:**
- Perbaiki penomoran seluruh gambar Bab III secara berurutan (gunakan numbering otomatis Word: References → Insert Caption).
- Tambahkan rancangan algoritma pencarian kasus serupa (misalnya: pencocokan `category` + kemiripan teks `description` menggunakan cosine similarity/embedding sederhana, atau minimal query `WHERE category = ? AND status IN (resolved, closed) ORDER BY created_at DESC LIMIT 3` jika pendekatannya sederhana).
- Ubah `ticket_messages.user_id` menjadi **nullable, on delete set null** (bukan cascade), agar konsisten dengan filosofi `tickets.user_id` — riwayat percakapan tetap tersimpan untuk keperluan audit meskipun user dihapus.
- Tambahkan tabel `notifications` ke struktur database (3.7) — bisa gunakan tabel bawaan Laravel `notifications` (polymorphic) — dan jelaskan skemanya.

---

### BAB IV

**Temuan:**
1. **Kontradiksi jumlah skenario uji**: 4.3.1 menulis "17 skenario valid dari total 17 skenario uji", tetapi Tabel 4.1 hanya berisi 11 test case dan rekapitulasi 4.2.3 menyatakan total 11. Ini harus disamakan.
2. **UAT muncul tanpa metodologi**: skor 4.62 dari "5 responden" — tidak dijelaskan siapa 5 responden ini (user/teknisi/admin sungguhan atau simulasi), instrumen kuesioner apa yang dipakai, dan skala penilaian per indikator seperti apa. Ini rawan dianggap data tidak dapat diverifikasi.
3. **Fitur pencarian kasus serupa tidak ada bukti implementasi** — tidak ada segmen kode, tidak ada tangkapan layar panel "3 kasus serupa" yang disebut di flowchart BAB III meskipun ini adalah fitur kunci pembeda riset.
4. Penomoran heading kacau: "4.1 Implementasi" (pembuka umum) langsung diikuti "4.3 Implementasi Sistem" (melompati 4.2), lalu sub-bab di dalamnya diberi nomor "4.1.3.x" (tidak match dengan induk 4.3). Baru kemudian muncul "4.2 Pengujian Black Box" dan "4.3 Pembahasan" (menduplikasi nomor 4.3 yang sudah dipakai untuk Implementasi Sistem).
5. Segmen 4.4 menampilkan tampilan `ai_summary`, `ai_causes`, `ai_recommendations`, `ai_confidence` di halaman detail tiket, tetapi kode yang mengisi keempat kolom ini untuk **tiket yang dibuat manual** tidak pernah ditunjukkan — Segmen 4.6b (`analyzeConversation`) hanya menganalisis draf tiket dari chatbot, bukan submission form manual. Ini bertentangan dengan pernyataan flowchart 3.1 bahwa "AI tetap bekerja di latar belakang" pada metode manual.
6. Fungsi `assign()` (Segmen 4.11) tidak memvalidasi apakah tiket **sudah di-assign ke teknisi lain** sebelum mengizinkan self-assign — berpotensi race condition dua teknisi meng-klaim tiket yang sama, atau teknisi lain "mencuri" assignment tiket yang sedang dikerjakan.
7. Form upload lampiran (Segmen 4.3) memakai `accept="image/"` — seharusnya `accept="image/*"` (typo), dan tidak ada validasi ukuran/mime type di sisi server yang ditunjukkan — potensi celah keamanan upload file.
8. `ai_confidence` disajikan sebagai persentase "keyakinan AI", namun ini adalah nilai yang **di-generate oleh LLM itu sendiri** (self-reported), bukan hasil pengukuran statistik objektif — ini kelemahan metodologis yang hampir pasti akan dipertanyakan penguji ("apakah confidence score ini valid secara statistik, atau hanya karangan model?").

**Dampak:**
- Poin 1 dan 2 adalah **red flag validitas data** — penguji bisa mempertanyakan integritas seluruh bab hasil jika ada angka yang tidak konsisten.
- Poin 3 adalah kelemahan paling fatal karena berkaitan langsung dengan originalitas/kontribusi riset yang diklaim di BAB I dan BAB II.
- Poin 6 dan 7 adalah kelemahan teknis nyata yang bisa menyebabkan bug produksi (bukan hanya isu akademik).

**Rekomendasi Perbaikan:**
- Samakan angka skenario uji (perbaiki jadi 11 di semua bagian, atau tambahkan 6 skenario lagi jika memang ada tapi belum ditampilkan di tabel).
- Tambahkan sub-bab metodologi UAT di BAB III (instrumen, jumlah & kriteria responden, skala Likert) sebelum menampilkan hasilnya di BAB IV.
- Implementasikan dan dokumentasikan fitur pencarian kasus serupa, atau jujur nyatakan sebagai keterbatasan dengan revisi di BAB I.
- Perbaiki penomoran heading 4.1–4.3 secara berurutan dan konsisten.
- Tambahkan validasi `if ($ticket->assigned_to !== null) { abort(409, 'Tiket sudah ditugaskan.'); }` sebelum proses self-assign.
- Perbaiki `accept="image/"` menjadi `accept="image/*"`, tambahkan validasi Laravel `'attachment' => 'nullable|image|max:2048'` di server-side.

---

## C. Temuan pada Aplikasi

**Kekurangan fitur:**
- Fitur rekomendasi/pencarian kasus serupa (knowledge base) tidak terbukti terimplementasi.
- Analisis AI otomatis untuk tiket manual (bukan dari chatbot) tidak ditunjukkan.
- Tidak ada fitur pencarian/filter riwayat percakapan chatbot lama (histori percakapan sebelumnya untuk direview user).
- Tidak ada indikator sisa kuota pesan (`MAX_USER_MESSAGES = 10`) yang terlihat oleh user di antarmuka — bisa membingungkan saat sesi tiba-tiba dibatasi.

**Kekurangan alur sistem:**
- Tidak ada mekanisme mencegah pembuatan banyak sesi percakapan baru untuk melewati batas 10 pesan per sesi (potensi penyalahgunaan kuota API).
- Self-assign tidak mengecek status assignment sebelumnya (race condition).
- Tidak ada alur eksplisit untuk transfer/reassign tiket antar teknisi (hanya self-assign, tidak ada unassign atau pengalihan oleh admin).

**Kekurangan database:**
- Kontradiksi cascade delete pada `ticket_messages.user_id` vs nullable pada `tickets.user_id`.
- Tidak ada tabel `notifications` meski fitur notifikasi disebutkan berjalan.
- Kolom `category` tidak dibatasi tipe data (enum/relasi), rawan inkonsistensi data jika input dari luar form (API/seeder).
- Desain `ChatMessage` (kolom `message` + `response` + `sender_type` dalam satu tabel) tumpang tindih secara konseptual — sender_type mengindikasikan baris adalah pesan tunggal, tapi kolom `response` juga menyimpan balasan bot di baris yang sama; perlu dipilih satu pola desain yang konsisten.

**Kekurangan keamanan:**
- Kontrol akses (role check) dilakukan ad-hoc di masing-masing controller (`if ($user->role !== ...)`), bukan lewat middleware/policy terpusat — rawan celah jika ada route baru lupa diberi pengecekan.
- Tidak ada validasi file upload di sisi server yang ditunjukkan (ukuran, tipe MIME).
- Tidak ada rate limiting eksplisit pada login (brute force) maupun endpoint chatbot (selain limit 10 pesan/sesi yang bisa dilewati dengan membuat sesi baru).
- Tidak dibahas skenario "admin terakhir menghapus dirinya sendiri secara tidak langsung" atau demosi role admin terakhir menjadi tanpa admin sama sekali.

**Kekurangan integrasi AI:**
- Confidence score AI bersifat self-reported dari LLM, tanpa validasi statistik independen.
- Tidak ada logging/monitoring biaya (token usage) pemanggilan OpenRouter meski sistem berulang kali memanggil API (chatbot, draf tiket, resolution summary) — penting untuk riset yang mengklaim efisiensi biaya.
- Tidak ada penanganan eksplisit jika output JSON dari LLM tidak valid/gagal di-parse pada `analyzeConversation()` (comment "// ... parsing json..." tidak menunjukkan try-catch atau fallback jika format JSON rusak).

---

## D. Daftar Perbaikan Prioritas

**1. Kritis**
- Ketidaksesuaian jumlah skenario uji (17 vs 11) di BAB IV.
- Fitur pencarian/rekomendasi kasus serupa tidak terbukti implementasinya, padahal jadi klaim kontribusi utama riset.
- UAT muncul tanpa metodologi dan tanpa dasar di Batasan Masalah BAB I.
- Kontradiksi desain cascade delete `ticket_messages.user_id` yang bisa menghapus histori diskusi tiket.

**2. Tinggi**
- Validasi self-assign tidak mengecek status assignment sebelumnya (race condition).
- Tidak ada validasi server-side untuk file upload (keamanan).
- Kontrol akses berbasis role dilakukan ad-hoc, bukan middleware/policy terpusat.
- Tidak ada tabel `notifications` di struktur database meski fitur notifikasi diklaim berjalan.
- Analisis AI untuk tiket manual (bukan via chatbot) tidak ditunjukkan implementasinya, bertentangan dengan flowchart BAB III.

**3. Sedang**
- Penomoran gambar dan sub-bab yang duplikat/tidak berurutan di BAB III dan BAB IV.
- Tidak ada rancangan algoritma untuk fitur rekomendasi kasus serupa di BAB III (akar dari gap di BAB IV).
- Kolom `category` tidak divalidasi di level database.
- Landasan teori Knowledge Base/Case-Based Reasoning tidak ada di BAB II padahal jadi klaim kontribusi.
- Desain tabel `chat_messages` (kolom message+response+sender_type) tumpang tindih konsep.

**4. Rendah**
- Typo `accept="image/"` seharusnya `accept="image/*"`.
- Tidak ada indikator kuota pesan chatbot di antarmuka user.
- Belum ada logging biaya/token pemanggilan API OpenRouter.
- Kejelasan posisi Admin dalam skema Tier 1/Tier 2 di BAB II.

---

## E. Revisi Langsung (Contoh Penerapan)

**1. Menyamakan jumlah skenario uji**
Ganti kalimat di 4.3.1 dari:
> "...persentase keberhasilan sistem mencapai 100% (17 skenario valid dari total 17 skenario uji)."

Menjadi:
> "...persentase keberhasilan sistem mencapai 100% (11 skenario valid dari total 11 skenario uji, sebagaimana tercantum pada Tabel 4.1)."

**2. Menambahkan validasi self-assign agar tidak race condition**
```php
public function assign(Request $request, $id)
{
    $ticket = Ticket::findOrFail($id);

    if ($ticket->assigned_to !== null) {
        return back()->with('error', 'Tiket ini sudah ditugaskan ke teknisi lain.');
    }

    $ticket->assigned_to = auth()->id();
    $ticket->status = 'progress';
    $ticket->save();

    // ...kirim notifikasi seperti semula
}
```

**3. Memperbaiki relasi `ticket_messages.user_id` agar konsisten dengan filosofi audit trail**
Ubah migrasi dari `onDelete('cascade')` menjadi:
```php
$table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
```
Sehingga histori diskusi tiket tetap tersimpan meski akun pengguna dihapus admin.

**4. Menambahkan validasi upload file di server**
```php
$request->validate([
    'subject' => 'required|string|max:255',
    'category' => 'required|in:Hardware,Software,Jaringan,Akun,Lainnya',
    'attachment' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
]);
```
Dan perbaiki HTML: `<input type="file" name="attachment" accept="image/*">`

**5. Contoh rancangan sederhana fitur "kasus serupa" (untuk ditambahkan ke BAB III & BAB IV)**
```php
private function findSimilarTickets(Ticket $ticket, int $limit = 3)
{
    return Ticket::where('category', $ticket->category)
        ->whereIn('status', ['resolved', 'closed'])
        ->where('id', '!=', $ticket->id)
        ->latest('updated_at')
        ->take($limit)
        ->get(['id', 'subject', 'resolution_summary']);
}
```
Ini bisa dijadikan pendekatan berbasis kategori sebagai baseline sederhana (dijelaskan keterbatasannya: belum menggunakan kemiripan teks/embedding), sehingga klaim kontribusi di BAB I tetap dapat dipertanggungjawabkan.

**6. Menambahkan sub-bab metodologi UAT di BAB III (3.9, contoh)**
> "Selain pengujian Blackbox, penelitian ini juga melakukan User Acceptance Test (UAT) terhadap [n] responden yang terdiri dari [komposisi peran], menggunakan kuesioner skala Likert 1–5 dengan indikator: (1) kemudahan penggunaan, (2) kecepatan respons chatbot, (3) akurasi analisis AI, (4) kepuasan terhadap antarmuka."

---

## Prediksi Pertanyaan Sidang & Titik Kritis

1. "Anda menyebut fitur pencarian kasus serupa di BAB I dan BAB III, tapi mana implementasinya di BAB IV?" — **Wajib disiapkan jawaban/demo, atau revisi cakupan sebelum sidang.**
2. "Kenapa jumlah skenario uji di teks (17) berbeda dengan tabel (11)?" — perbaiki sebelum cetak final.
3. "Bagaimana Anda memvalidasi bahwa 'confidence score' dari AI benar-benar akurat, bukan sekadar angka yang dikarang model?" — siapkan penjelasan keterbatasan metode ini secara jujur di bab keterbatasan.
4. "Kenapa UAT tidak disebutkan di Batasan Masalah / Metodologi Penelitian?" — pastikan konsisten.
5. "Bagaimana jika dua teknisi menekan tombol assign secara bersamaan pada tiket yang sama?" — tunjukkan Anda sudah memikirkan/menambal celah ini.
6. "Apa yang terjadi pada riwayat diskusi tiket jika pengguna yang membuatnya dihapus oleh admin?" — jelaskan perilaku cascade yang sebenarnya, dan pastikan sudah konsisten dengan klaim di 4.3.1.