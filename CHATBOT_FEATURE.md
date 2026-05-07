# Fitur Chatbot Helpdesk

Dokumentasi lengkap untuk fitur chatbot yang telah ditambahkan ke aplikasi HelpDesk.

## 📋 Daftar Komponen

### Models

- **ChatbotConversation** - Model untuk menyimpan percakapan chatbot
- **ChatMessage** - Model untuk menyimpan pesan dalam percakapan

### Controllers

- **ChatbotController** - Controller untuk mengelola chatbot conversations dan messages

### Views

- **resources/views/chatbot/index.blade.php** - Halaman daftar percakapan
- **resources/views/chatbot/show.blade.php** - Halaman percakapan utama (chat interface)

### Policies

- **ChatbotConversationPolicy** - Policy untuk otorisasi akses percakapan

### Database Migrations

- `2026_01_19_150000_create_chatbot_conversations_table.php`
- `2026_01_19_160000_create_chat_messages_table.php`

## 🚀 Setup & Installasi

### 1. Jalankan Migrations

```bash
php artisan migrate
```

Ini akan membuat dua tabel baru:

- `chatbot_conversations` - Menyimpan data percakapan
- `chat_messages` - Menyimpan pesan individual

### 2. Akses Fitur Chatbot

Setelah migration selesai, pengguna yang sudah login dapat mengakses chatbot melalui:

- URL: `http://localhost:8000/chatbot`
- Navigation Menu: Klik menu "Chatbot" di navigation bar

## 🎯 Fitur Utama

### 1. Daftar Percakapan

- Lihat semua percakapan chatbot yang telah dibuat
- Setiap percakapan menampilkan jumlah pesan dan waktu pembuatan
- Dapat membuat percakapan baru, edit, atau hapus

### 2. Chat Interface

- Interface percakapan real-time
- Menampilkan pesan pengguna dan respons bot
- Support untuk pertanyaan umum dengan respons otomatis
- Quick action buttons untuk pertanyaan yang sering diajukan

### 3. Smart Responses

Bot akan memberikan respons berdasarkan keyword yang terdeteksi:

#### Keywords yang didukung:

- **Tiket/Ticket** - Informasi tentang cara membuat tiket
- **Jam/Berapa/What time** - Jam kerja support
- **Bantuan/Help** - Penawaran bantuan umum
- **Terima Kasih/Thanks** - Response berterimakasih
- **Halo/Hi/Hello** - Salam pembuka
- **Default** - Respons default untuk pertanyaan lainnya

## 💾 Database Schema

### Tabel: chatbot_conversations

```
id              (primary key)
user_id         (foreign key → users)
title           (string) - Judul percakapan
status          (string) - Status: active, closed
created_at      (timestamp)
updated_at      (timestamp)
```

### Tabel: chat_messages

```
id                              (primary key)
chatbot_conversation_id         (foreign key → chatbot_conversations)
user_id                        (foreign key → users)
message                        (longText) - Pesan dari user
sender_type                    (string) - user atau bot
response                       (longText) - Respons dari bot
created_at                     (timestamp)
updated_at                     (timestamp)
```

## 🔐 Security & Authorization

- Setiap percakapan hanya bisa diakses oleh user yang membuatnya
- Implementasi menggunakan Laravel Policies (ChatbotConversationPolicy)
- Semua endpoint dilindungi dengan middleware `auth`

## 🛣️ Routes

```
GET    /chatbot                        - Daftar percakapan (index)
GET    /chatbot/create                 - Form buat percakapan (optional)
POST   /chatbot                        - Simpan percakapan baru (store)
GET    /chatbot/{id}                   - Tampilkan percakapan (show)
POST   /chatbot/{id}/send-message      - Kirim pesan (sendMessage)
DELETE /chatbot/{id}                   - Hapus percakapan (destroy)
```

## 🧠 Customizing Bot Responses

Untuk mengubah respons bot, edit method `generateBotResponse()` di file:

```
app/Http/Controllers/ChatbotController.php
```

Contoh menambah keyword baru:

```php
if (strpos($message, 'kata_kunci_anda') !== false) {
    return 'Respons Anda di sini';
}
```

## 📱 UI/UX Features

### Desain Responsif

- Tampilan desktop dan mobile yang optimal
- Dark mode support
- Smooth animations dan transitions

### User Experience

- Auto-scroll ke pesan terbaru
- Typing indicator saat bot sedang meresponse
- Quick action buttons untuk pertanyaan umum
- Timestamp pada setiap pesan
- Loading states dan error handling

## 🔧 Customization

### Mengubah Styling

- View files menggunakan Tailwind CSS
- Warna utama: Indigo (indigo-600)
- Ubah di `resources/views/chatbot/` files

### Menambah Fitur

Beberapa ide ekspansi:

1. Integrasi dengan LLM API (OpenAI, Claude, etc.)
2. Kategorisasi percakapan dengan tags
3. Rating dan feedback untuk respons bot
4. Admin dashboard untuk analisis chat
5. Export percakapan ke PDF
6. Multi-language support

## 📝 Notes

- Bot responses saat ini menggunakan simple keyword matching
- Untuk AI conversation yang lebih advanced, pertimbangkan integrasi dengan API LLM
- Semua pesan disimpan di database untuk future analytics
- Sistem authorization memastikan data privacy per user

## 🐛 Troubleshooting

### Halaman chatbot tidak muncul di navigation

- Pastikan user sudah login
- User harus memiliki role 'user' atau 'support', bukan 'admin'
- Clear browser cache atau coba hard refresh

### Pesan tidak terkirim

- Pastikan CSRF token tersedia (biasanya sudah di layout app)
- Check browser console untuk error messages
- Pastikan database connection aktif

### Migration error

- Pastikan timestamp di nama migration unik
- Jika ada conflict, ubah timestamp di nama file migration
- Run: `php artisan migrate --step` untuk troubleshoot

## 📞 Support

Untuk pertanyaan atau issue, hubungi tim development.
