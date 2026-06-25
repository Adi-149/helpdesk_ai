# Sistem Helpdesk Ticketing Berbasis Web dengan Integrasi AI

Saya sedang mengembangkan sistem Helpdesk Ticketing berbasis web untuk skripsi dengan fokus utama integrasi Artificial Intelligence (AI) sebagai bagian inti dari proses helpdesk, bukan hanya sebagai chatbot tambahan.

Tujuan sistem adalah menjadikan AI sebagai First-Level Support bagi user dan AI Assistant bagi teknisi.

## Aktor Sistem

### User

* Login ke sistem.
* Menggunakan chatbot AI.
* Membuat tiket bantuan.
* Melihat status tiket.
* Menerima notifikasi perubahan status tiket.
* Melihat riwayat tiket.

### Teknisi

* Melihat tiket yang masuk.
* Mengubah status tiket.
* Memberikan tanggapan penyelesaian.
* Menerima rekomendasi dari AI.
* Melihat ringkasan masalah yang dibuat AI.
* Menerima notifikasi tiket baru.

### Admin

* Memiliki seluruh hak akses Teknisi dan User.
* Mengelola pengguna.
* Mengelola teknisi.
* Melihat laporan.
* Mengelola data sistem.

## Konsep Integrasi AI

AI tidak hanya berfungsi sebagai chatbot tanya jawab, tetapi harus terintegrasi dengan seluruh alur helpdesk.

### Tahap 1: Konsultasi Awal

User pertama kali berinteraksi dengan chatbot AI.

Contoh:
"Saya tidak bisa login ke sistem."

AI memberikan solusi awal berdasarkan pengetahuan yang dimiliki.

Jika masalah selesai:

* Tidak perlu membuat tiket.

Jika masalah belum selesai:

* AI menawarkan pembuatan tiket otomatis.

## Tahap 2: Analisis Masalah oleh AI

Ketika user ingin membuat tiket, AI harus menganalisis percakapan dan menghasilkan:

* Judul tiket otomatis.
* Deskripsi tiket otomatis.
* Kategori tiket otomatis.
* Prioritas tiket otomatis.
* Ringkasan masalah otomatis.

Contoh hasil:

Judul:
"Gagal Login Sistem Akademik"

Kategori:
"Akun"

Prioritas:
"Sedang"

Ringkasan:
"Pengguna tidak dapat login meskipun kredensial sudah benar."

User cukup melakukan konfirmasi sebelum tiket dibuat.

## Tahap 3: Pembuatan Tiket Otomatis

Setelah konfirmasi:

* Sistem membuat tiket secara otomatis.
* Data hasil analisis AI disimpan ke database.
* Tiket masuk ke daftar tiket teknisi.

## Tahap 4: Notifikasi Teknisi

Ketika tiket baru dibuat:

* Sistem mengirim notifikasi kepada teknisi.
* Notifikasi muncul pada dashboard teknisi.
* Badge jumlah notifikasi belum dibaca harus tersedia.

Contoh:

"Tiket baru #TK-001 memerlukan penanganan."

## Tahap 5: AI Assistant untuk Teknisi

Ketika teknisi membuka tiket, AI harus membantu teknisi dengan menyediakan:

### Ringkasan Masalah

AI menampilkan ringkasan singkat masalah berdasarkan isi tiket dan percakapan user.

### Analisis Kemungkinan Penyebab

Contoh:

* Password kadaluarsa
* Akun terkunci
* Gangguan server autentikasi

### Rekomendasi Penanganan

Contoh:

1. Verifikasi akun pengguna
2. Reset password
3. Periksa log autentikasi

### Tingkat Keyakinan

Opsional:
AI dapat memberikan confidence score untuk rekomendasi yang diberikan.

## Tahap 6: Pencarian Kasus Serupa

AI harus dapat memanfaatkan riwayat tiket yang sudah pernah diselesaikan.

Ketika tiket baru dibuka:

* Cari tiket serupa berdasarkan judul, deskripsi, kategori, dan isi percakapan.
* Tampilkan daftar kasus yang mirip.
* Tampilkan solusi yang pernah berhasil digunakan.

Contoh:

Kasus Serupa:

* Tiket #TK-021
* Tiket #TK-034

Solusi Sebelumnya:
"Reset password dan sinkronisasi akun."

Fitur ini menjadi knowledge base otomatis.

## Tahap 7: Penyelesaian Tiket

Teknisi mengubah status tiket:

* Open
* In Progress
* Resolved
* Closed

Setiap perubahan status mengirim notifikasi kepada user.

## Tahap 8: Ringkasan Penyelesaian Otomatis

Ketika tiket selesai:

AI membuat ringkasan akhir.

Contoh:

Masalah:
Gagal login sistem.

Penyebab:
Password kadaluarsa.

Solusi:
Password direset oleh teknisi.

Status:
Selesai.

Ringkasan ini disimpan sebagai knowledge base untuk membantu penyelesaian tiket berikutnya.

## Dashboard User

Tampilkan:

* Total Tiket Saya
* Tiket Dibuka
* Tiket Diproses
* Tiket Selesai
* Tiket Ditutup

## Dashboard Teknisi

Tampilkan:

* Total Tiket
* Belum Ditangani
* Sedang Diproses
* Selesai
* Statistik Prioritas
* Statistik Kategori

## Dashboard Admin

Tampilkan:

* Total Pengguna
* Total Teknisi
* Total Tiket
* Statistik Prioritas
* Statistik Status Tiket
* Statistik Kategori
* Laporan

## Nilai Inovasi Sistem

Sistem harus menonjolkan bahwa AI memiliki peran pada tiga tahap utama:

1. Membantu User sebagai First-Level Support.
2. Menganalisis dan membuat tiket secara otomatis.
3. Membantu Teknisi melalui rekomendasi, pencarian kasus serupa, dan pembuatan knowledge base.

AI bukan sekadar chatbot eksternal, tetapi menjadi komponen inti dalam proses helpdesk ticketing.
