# System Architecture & Flowchart

Dokumen ini menjelaskan rancangan arsitektur, diagram alur sistem (*flowchart*), interaksi aktor (*use case*), dan skema relasi basis data (*class diagram*) dari **HelpDesk AI**.

---

## 1. Alur Sistem Terintegrasi (System Flowchart)

Berikut adalah diagram alur interaksi terpadu antara **Pengguna (User)**, **Sistem & AI**, dan **Teknisi (IT Support)**:

```mermaid
flowchart TD
    %% Styling
    classDef user fill:#e1f5fe,stroke:#0288d1,stroke-width:2px,color:#01579b;
    classDef system fill:#efebe9,stroke:#5d4037,stroke-width:2px,color:#3e2723;
    classDef ai fill:#ede7f6,stroke:#7e57c2,stroke-width:2px,color:#4a148c;
    classDef tech fill:#e8f5e9,stroke:#388e3c,stroke-width:2px,color:#1b5e20;

    %% Nodes
    Start([Mulai]) --> UserLogin[User Login ke Sistem]:::user
    UserLogin --> ChatbotAI["Konsultasi dengan Chatbot AI<br>(First-Level Support)"]:::user
    
    ChatbotAI --> SolveCheck{"Apakah Solusi<br>AI Membantu?"}:::user
    
    SolveCheck -- Ya --> EndSolved([Selesai - Tidak Perlu Tiket])
    
    SolveCheck -- Tidak --> TicketChoice{"Metode Pembuatan<br>Tiket?"}:::user
    
    TicketChoice -- "Otomatis (via Chatbot)" --> AIAnalyze["AI Menganalisis Obrolan Chat<br>dan Membuat Draf Tiket"]:::ai
    AIAnalyze --> FillDraft["Pre-fill Form Tiket<br>(Judul, Deskripsi, Kategori, Prioritas)"]:::system
    FillDraft --> UserConfirm[User Konfirmasi Draf Tiket]:::user
    UserConfirm --> SaveTicketAuto["Simpan Tiket ke Database<br>(Menyimpan Data Analisis AI)"]:::system
    
    TicketChoice -- "Manual (Form Biasa)" --> FillManual[User Isi Form Tiket Manual]:::user
    FillManual --> SyncAnalyze[AI Menganalisis Input Secara Sinkron]:::ai
    SyncAnalyze --> SaveTicketManual["Simpan Tiket ke Database<br>(Menyimpan Data Analisis AI)"]:::system

    SaveTicketAuto --> NotifyTech[Kirim Web Push Notification ke Teknisi]:::system
    SaveTicketManual --> NotifyTech
    
    NotifyTech --> TechDashboard[Teknisi Lihat Tiket Baru di Dashboard]:::tech
    TechDashboard --> SelfAssign["Teknisi Mengambil Tiket<br>(Self-Assignment)"]:::tech
    
    SelfAssign --> StatusProgress[Status Tiket Berubah: 'In Progress']:::system
    StatusProgress --> NotifyUser[Kirim Notifikasi ke Pelapor]:::system
    
    NotifyUser --> TechShow[Teknisi Buka Detail Tiket]:::tech
    
    TechShow --> AIAssistantPanel["Asisten AI Menyajikan:<br>1. Ringkasan Masalah<br>2. Kemungkinan Penyebab<br>3. Rekomendasi Solusi<br>4. Skor Keyakinan"]:::ai
    TechShow --> SimilarCases["AI Menampilkan Kasus Serupa<br>(Top 3 Tiket Resolved/Closed)"]:::ai
    
    AIAssistantPanel --> TechRepair["Teknisi Melakukan Troubleshooting<br>(Dapat Berdiskusi via Chat Tiket)"]:::tech
    SimilarCases --> TechRepair
    
    TechRepair --> MarkResolved["Teknisi Mengubah Status ke 'Resolved'<br>& Input Catatan Solusi"]:::tech
    
    MarkResolved --> AIResolution["AI Membuat Ringkasan Solusi<br>Secara Otomatis"]:::ai
    AIResolution --> SaveResolution["Simpan ke 'resolution_summary'"]:::system
    
    SaveResolution --> UserVerify{"User Konfirmasi<br>Penyelesaian?"}:::user
    
    UserVerify -- Setuju --> StatusClosed[Status Tiket Berubah: 'Closed']:::system
    StatusClosed --> KBUpdate["Tiket Masuk ke Knowledge Base<br>untuk Kasus Serupa di Masa Depan"]:::system
    KBUpdate --> EndClosed([Tiket Ditutup - Sukses])
    
    UserVerify -- "Masalah Belum Tuntas (< 48 Jam)" --> ReopenTicket["User Buka Kembali Tiket (Reopen)"]:::user
    ReopenTicket --> StatusReopened["Status Tiket Kembali ke 'In Progress'"]:::system
    StatusReopened --> NotifyTechReopen[Kirim Notifikasi ke Teknisi]:::system
    NotifyTechReopen --> TechShow
```

---

## 2. Use Case Diagram

Sistem mengakomodasi 3 aktor utama dengan hak akses berbasis peran (Role-Based Access Control):

```mermaid
graph LR
    User(["👤 User / Karyawan"])
    Teknisi(["🛠️ Teknisi / Support"])
    Admin(["👑 Administrator"])
    AI(["🤖 Google Gemini AI"])

    subgraph HelpdeskSystem ["Sistem IT Helpdesk AI"]
        UC1(Login & Autentikasi)
        UC2(Konsultasi Chatbot AI & SOP)
        UC3(Pembuatan Tiket Otomatis / Manual)
        UC4(Diskusi & Lampiran Tiket)
        UC5(Riwayat & Status Tiket)
        UC6(Self-Assignment Tiket)
        UC7(Update Status & Prioritas)
        UC8(Rekomendasi Kasus Serupa AI)
        UC9(Ringkasan Solusi Tiket AI)
        UC10(Manajemen Pengguna & Role)
        UC11(Manajemen SOP & Knowledge Base)
        UC12(Laporan & Analitik SLA)
    end

    User --> UC1
    User --> UC2
    User --> UC3
    User --> UC4
    User --> UC5

    Teknisi --> UC1
    Teknisi --> UC4
    Teknisi --> UC6
    Teknisi --> UC7
    Teknisi --> UC8
    Teknisi --> UC9

    Admin --> UC1
    Admin --> UC2
    Admin --> UC3
    Admin --> UC4
    Admin --> UC5
    Admin --> UC6
    Admin --> UC7
    Admin --> UC10
    Admin --> UC11
    Admin --> UC12

    UC2 -.-> AI
    UC3 -.-> AI
    UC8 -.-> AI
    UC9 -.-> AI
```

---

## 3. Skema Basis Data & Class Diagram

```mermaid
classDiagram
    class User {
        +bigint id
        +varchar name
        +varchar email
        +varchar password
        +varchar role (admin|support|user)
        +timestamp created_at
        +timestamp updated_at
    }

    class Ticket {
        +bigint id
        +bigint user_id
        +bigint assigned_to
        +varchar subject
        +text description
        +varchar category
        +enum priority (low|medium|high)
        +enum status (open|progress|resolved|closed)
        +text ai_analysis
        +text resolution_notes
        +text resolution_summary
        +timestamp resolved_at
        +timestamp closed_at
        +timestamp created_at
    }

    class TicketHistory {
        +bigint id
        +bigint ticket_id
        +bigint user_id
        +varchar old_status
        +varchar new_status
        +text notes
        +timestamp created_at
    }

    class ChatbotConversation {
        +bigint id
        +bigint user_id
        +varchar title
        +varchar status (active|closed)
        +timestamp created_at
    }

    class ChatMessage {
        +bigint id
        +bigint chatbot_conversation_id
        +bigint user_id
        +text message
        +varchar sender_type (user|assistant)
        +text response
        +timestamp created_at
    }

    class KnowledgeBase {
        +bigint id
        +varchar title
        +varchar category
        +text content
        +varchar target_role
        +timestamp created_at
    }

    User "1" --> "*" Ticket : creates
    User "1" --> "*" Ticket : assigned_to
    Ticket "1" --> "*" TicketHistory : logs
    User "1" --> "*" ChatbotConversation : participates
    ChatbotConversation "1" --> "*" ChatMessage : contains
    KnowledgeBase ..> ChatbotConversation : supplies context
```
