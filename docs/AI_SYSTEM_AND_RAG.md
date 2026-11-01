# AI System Architecture & RAG Pipeline

Dokumen ini menguraikan arsitektur kecerdasan buatan, integrasi model bahasa besar (LLM) melalui OpenRouter (Google Gemini / OpenAI), implementasi *Retrieval-Augmented Generation* (RAG) berbasis SOP internal, dan teknik prompt engineering yang diterapkan pada **HelpDesk AI**.

---

## 1. Arsitektur Komponen AI

```
                      +---------------------------------------+
                      |       User / Employee Input           |
                      +-------------------+-------------------+
                                          |
                                          v
                      +-------------------+-------------------+
                      |      KnowledgeBaseService.php         |
                      |  - Role-based SOP Search (Keyword)    |
                      |  - Top Matches Filtering (Threshold)  |
                      +-------------------+-------------------+
                                          | (Internal Context)
                                          v
+------------------+  System Prompt       |
| Guardrails Rules | ----------------> [Prompt Builder]
+------------------+                      |
                                          v
                      +-------------------+-------------------+
                      |     Conversation History Context      |
                      |  - Chronological chat messages        |
                      |  - Session-bounded limit (10 msgs)    |
                      +-------------------+-------------------+
                                          |
                                          v
                      +-------------------+-------------------+
                      |   OpenRouter API Gateway Client       |
                      |   (Gemini 2.0 Flash / GPT-4o-mini)    |
                      +-------------------+-------------------+
                                          |
               +--------------------------+--------------------------+
               | (Success)                                           | (Fallback / Timeout)
               v                                                     v
+------------------------------+                       +------------------------------+
| AI Response Stream / Payload |                       | Internal Rule-based Matcher  |
+--------------+---------------+                       +--------------+---------------+
               |                                                      |
               +--------------------------+---------------------------+
                                          |
                                          v
                      +-------------------+-------------------+
                      |  Automated Ticket Triage & Prefill    |
                      |  - Subject extraction                 |
                      |  - Category classification            |
                      |  - Priority assessment (High/Med/Low) |
                      |  - Initial troubleshooting guide      |
                      +---------------------------------------+
```

---

## 2. Fitur-Fitur Utama AI

### A. RAG (Retrieval-Augmented Generation) Berbasis SOP Internal
Sistem tidak hanya mengandalkan pengetahuan umum model AI, melainkan menyuntikkan dokumen **Standard Operating Procedure (SOP)** yang relevan dari tabel `knowledge_bases`:
1. Sistem mengekstrak kata kunci dari pertanyaan pengguna (`KnowledgeBaseService.php`).
2. Melakukan pencarian terarah berdasarkan kategori dan target role (misalnya teknisi atau pengguna umum).
3. Menginjeksi konten SOP ke dalam `system prompt` sebagai konteks resmi (*ground truth*).
4. AI memberikan instruksi troubleshooting langkah-demi-langkah dengan sitasi sumber SOP (misal: `[Sumber: SOP Printer Thermal Tidak Mencetak]`).

### B. Guardrails & Safety Prompts
Untuk menjaga integritas operasional helpdesk perusahaan:
- **Domain Isolation:** AI secara eksplisit menolak topik non-teknologi (politik, hiburan, resep makanan, dll.) dengan respons ramah dan mengarahkan kembali ke ranah IT.
- **Plain Text Formatting:** Output dioptimalkan tanpa simbol markdown yang membingungkan bagi pengguna awam di antarmuka web.
- **Escalation Trigger:** Jika kendala hardware berat tidak terselesaikan, AI secara otomatis menyarankan pengguna untuk mengonfirmasi draf tiket atau menghubungi nomor hotline teknisi siaga.

### C. Analisis Otomatis & Pembuatan Draf Tiket (*Ticket Drafting*)
Ketika percakapan mencapai titik kebutuhan pembuatan tiket:
- Endpoint `analyzeConversation()` mengevaluasi riwayat chat.
- Mengembalikan struktur JSON terstandarisasi:
  ```json
  {
    "subject": "Printer thermal terdeteksi tetapi tidak mencetak struk",
    "category": "Printer Thermal",
    "priority": "High",
    "description": "Pengguna melaporkan printer EPSON TM-T82X tidak merespons...",
    "suggested_solution": "Periksa kabel power dan sensor kertas..."
  }
  ```
- Form pembuatan tiket pengguna langsung terisi otomatis (*auto-prefill*), mengurangi waktu pembuatan tiket hingga **51,58%**.

### D. Rekomendasi Kasus Serupa (*Similar Cases*) untuk Teknisi
- Pada halaman detail tiket sisi teknisi, sistem menganalisis judul dan deskripsi masalah terhadap riwayat tiket berstatus `resolved` atau `closed`.
- Menampilkan hingga **3 tiket historis yang paling relevan** lengkap dengan solusi yang terbukti berhasil, mempercepat *Mean Time to Resolution* (MTTR).

### E. Ringkasan Solusi Tiket Otomatis (*Auto-Resolution Summarization*)
- Ketika teknisi menyelesaikan tiket dan mengisi catatan penanganan, AI merangkum percakapan teknisi-pengguna dan langkah teknis menjadi ringkasan padat pada kolom `resolution_summary`.
- Data ini secara otomatis memperkaya basis pengetahuan (*knowledge base*) masa depan.

---

## 3. Konfigurasi Lingkungan (`.env`)

```env
# AI Integration via OpenRouter
OPENROUTER_API_KEY=sk-or-v1-xxxxxxxxxxxxxxxxxxxx
OPENROUTER_MODEL=google/gemini-2.0-flash-exp:free
```
Sistem juga mendukung pergantian model fleksibel seperti `gpt-4o-mini`, `anthropic/claude-3-haiku`, atau `meta-llama/llama-3.1-8b-instruct`.
