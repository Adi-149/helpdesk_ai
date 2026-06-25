# Review dan Rekomendasi Perbaikan Aplikasi Helpdesk AI

Dokumen ini berisi rangkuman evaluasi, analisis alur sistem, temuan bug kritis, serta rekomendasi perbaikan untuk pengembangan aplikasi **Helpdesk AI** skala kecil (cocok untuk Rumah Sakit, Pabrik, Kantor, dll.).

---

## 🛠️ 1. Temuan Bug Kritis & Perbaikan Teknis

### A. Konflik Integritas Relasi Database (User Deletion Bug)
*   **Temuan**: 
    Pada model [User.php](file:///C:/Adi/Skripsi/skripsi/helpdesk_ai/app/Models/User.php#L55-L62), terdapat fungsi event-booting yang mencoba mengubah `user_id` di tabel tiket menjadi `null` saat user dihapus agar riwayat tiket tidak ikut terhapus:
    ```php
    protected static function booted(): void
    {
        static::deleting(function (User $user) {
            Ticket::where('user_id', $user->id)->update(['user_id' => null]);
        });
    }
    ```
    Namun, di file migrasi database [2026_01_19_020352_create_tickets_table.php](file:///C:/Adi/Skripsi/skripsi/helpdesk_ai/database/migrations/2026_01_19_020352_create_tickets_table.php#L16), kolom `user_id` diset sebagai **NOT NULL** dengan relasi cascade:
    ```php
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    ```
    Aksi ini akan menyebabkan database melempar **SQL Integrity Constraint Violation Error (Crash)** saat admin mencoba menghapus user yang sudah pernah membuat tiket.
*   **Rekomendasi Solusi**: 
    Jika Anda ingin tetap menyimpan riwayat tiket saat user dihapus, ubah migrasi kolom `user_id` pada tiket agar mendukung `.nullable()`. Jika tidak, sesuaikan logika model agar tiket ikut terhapus menggunakan cascading delete.

### B. Penyimpanan Pesan Chatbot AI (Database vs Session)
*   **Temuan**:
    Database migrasi untuk chatbot ([2026_01_19_150000_create_chatbot_conversations_table.php](file:///C:/Adi/Skripsi/skripsi/helpdesk_ai/database/migrations/2026_01_19_150000_create_chatbot_conversations_table.php) dan [2026_01_19_160000_create_chat_messages_table.php](file:///C:/Adi/Skripsi/skripsi/helpdesk_ai/database/migrations/2026_01_19_160000_create_chat_messages_table.php)) sudah siap, namun pada [ChatbotController.php](file:///C:/Adi/Skripsi/skripsi/helpdesk_ai/app/Http/Controllers/ChatbotController.php#L33), riwayat chat masih disimpan di **Session**.
    *   *Kelemahan*: Riwayat obrolan dengan AI akan hilang seketika saat user logout atau session kedaluwarsa. Admin/Support juga tidak bisa memantau atau menganalisis masalah IT apa saja yang sering dikonsultasikan pengguna ke chatbot.
*   **Rekomendasi Solusi**:
    Gunakan model `ChatbotConversation` dan `ChatMessage` untuk menyimpan riwayat obrolan ke database sehingga data tetap persisten dan dapat dianalisis di masa mendatang.

---

## 📈 2. Evaluasi Alur Kerja (Workflow) Helpdesk Fisik (On-Site)

Konsep helpdesk on-site di mana teknisi langsung menuju ke lokasi masalah (ruangan rumah sakit, area pabrik, meja kantor) dinilai **sangat tepat guna** untuk organisasi skala kecil. 

### Peran Komentar/Catatan Tiket
Meskipun teknisi berkomunikasi secara langsung (tatap muka) dengan pengguna di lokasi kejadian, **fitur kolom komentar/catatan tetap sangat penting** karena beberapa alasan operasional:
1.  **Komunikasi Asinkron**: Jika teknisi datang ke lokasi perbaikan namun pengguna sedang tidak di tempat (sedang rapat, memeriksa pasien, atau istirahat), teknisi bisa meninggalkan catatan di komentar tiket (misal: *"Printer sudah dikalibrasi ulang dan berfungsi normal"*).
2.  **Penanganan Tertunda (Indent Sparepart)**: Jika perbaikan membutuhkan waktu (misalnya menunggu pemesanan RAM atau mainboard selama beberapa hari), catatan di tiket berfungsi agar pengguna mengetahui kejelasan progres tanpa harus menelpon tim IT berulang kali.
3.  **Audit Kerja & Knowledge Base**: Komentar teknisi berfungsi sebagai dokumentasi solusi (*Knowledge Base*). Jika kendala yang sama terulang, teknisi lain dapat membaca tiket lama untuk menemukan cara penyelesaiannya.

### Kolom Prioritas Tiket pada Sisi Pengguna (User)
*   **Temuan / Isu**: Saat ini formulir pembuatan tiket meminta pengguna umum menentukan sendiri prioritas tiket mereka (`low`, `medium`, `high`). Hal ini kurang efektif karena bias subjektivitas pengguna (menganggap semua keluhan mereka sangat mendesak) serta ketidakpahaman teknis mengenai dampak sistemik.
*   **Pendekatan Rekomendasi (Pendekatan 1 - Triage oleh IT)**:
    *   Hapus kolom prioritas dari formulir pembuatan tiket yang diisi oleh pengguna biasa.
    *   Set nilai prioritas secara otomatis oleh sistem di latar belakang ke nilai default (misalnya `low` atau `medium`).
    *   Pindahkan otorisasi pengaturan prioritas ke staf **IT Support / Helpdesk** agar mereka dapat menentukannya secara objektif berdasarkan skala dampak nyata di lapangan sewaktu tiket sedang diproses dan ditugaskan.

---

## 🤖 3. Evaluasi Kegunaan Chatbot AI

Penggunaan Chatbot AI (Gemini via OpenRouter) sebagai penyaring pertama (*First-Tier Support*) dinilai **Sangat Berguna** dengan alasan berikut:
1.  **Efisiensi Sumber Daya**: Membantu mengatasi masalah minor secara mandiri oleh user (*self-troubleshooting*), sehingga staf IT support yang terbatas dapat fokus pada penanganan hardware kritis atau jaringan utama.
2.  **Siap Sedia 24/7**: Sangat berguna pada instansi dengan shift malam seperti **Rumah Sakit** dan **Pabrik** ketika staf IT di kantor sedang tidak bertugas.
3.  **Akurasi Topik**: Filter system prompt yang Anda terapkan sudah tepat dalam memaksa chatbot hanya menjawab hal-hal bertema IT dan menolak pertanyaan luar topik.

---

## 🚀 4. Rekomendasi Rencana Aksi Pengembangan (Action Plan)

Untuk menyempurnakan aplikasi Helpdesk AI Anda ke tahap berikutnya, berikut adalah beberapa langkah pengembangan yang disarankan:

| Prioritas | Sektor | Deskripsi Rencana Perbaikan |
| :--- | :--- | :--- |
| **Tinggi** | Database | Ubah migrasi tabel `tickets` agar kolom `user_id` menjadi `nullable()`, menyelaraskannya dengan metode booting pada model `User`. |
| **Tinggi** | Tiket / UI | Sembunyikan kolom prioritas dari form tiket sisi pengguna. Set prioritas ke default (`low` / `medium`) di `TicketController@store` dan biarkan IT Support mengaturnya di detail tiket. |
| **Sedang** | Chatbot | Hubungkan pengiriman pesan di `ChatbotController` agar tersimpan di tabel database `chatbot_conversations` dan `chat_messages` alih-alih session. |
| **Sedang** | UI/UX Chatbot | Tambahkan tombol **"Solusi Tidak Membantu, Laporkan Tiket Baru"** di widget chat apabila pengguna tidak berhasil memperbaiki masalahnya secara mandiri setelah berkonsultasi dengan AI. |
| **Rendah** | Tiket | Implementasikan fitur notifikasi dasar (email / database log) ketika tiket berganti status atau teknisi support ditugaskan. |
