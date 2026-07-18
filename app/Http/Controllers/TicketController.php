<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TicketHistory;
use App\Models\TicketMessage;
use App\Notifications\TicketCreatedNotification;
use App\Notifications\TicketAssignedNotification;
use App\Notifications\TicketStatusUpdatedNotification;
use App\Notifications\NewTicketMessageNotification;
use App\Notifications\TicketClosedNotification;
use App\Notifications\TicketReopenedNotification;
use Illuminate\Support\Facades\Notification;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        // Jika support, redirect ke support.tickets
        if (auth()->user()->role === 'support') {
            return redirect()->route('support.tickets');
        }

        // Ambil filter query
        $filterStatus = $request->query('status');
        $filterPriority = $request->query('priority');
        $filterCategory = $request->query('category');
        $filterDateFrom = $request->query('date_from');
        $filterDateTo = $request->query('date_to');

        // Query dasar tiket
        $ticketsQuery = Ticket::with(['user', 'assignedSupport'])->latest();

        // Jika bukan admin, batasi ke tiket milik user
        if (auth()->user()->role !== 'admin') {
            $ticketsQuery->where('user_id', auth()->id());
        }

        // Terapkan filter jika ada
        if ($filterStatus) {
            $ticketsQuery->where('status', $filterStatus);
        }
        if ($filterPriority) {
            $ticketsQuery->where('priority', $filterPriority);
        }
        if ($filterCategory) {
            $ticketsQuery->where('category', $filterCategory);
        }
        if ($filterDateFrom) {
            $ticketsQuery->whereDate('created_at', '>=', $filterDateFrom);
        }
        if ($filterDateTo) {
            $ticketsQuery->whereDate('created_at', '<=', $filterDateTo);
        }

        // Pagination 15 per halaman
        $tickets = $ticketsQuery->paginate(15)->appends($request->query());

        // Daftar kategori unik untuk filter
        $categories = Ticket::select('category')->distinct()->orderBy('category')->pluck('category');

        return view('tickets.index', compact(
            'tickets',
            'categories',
            'filterStatus',
            'filterPriority',
            'filterCategory',
            'filterDateFrom',
            'filterDateTo'
        ));
    }


    public function assignForm($id)
    {
        $ticket = Ticket::findOrFail($id);
        return view('support.assign', compact('ticket'));
    }

    public function assign(Request $request, $id)
    {
        $request->validate([
            'assigned_to' => 'required|in:' . auth()->id(),
        ], [
            'assigned_to.in' => 'Anda hanya dapat menugaskan tiket untuk diri Anda sendiri.',
        ]);

        $ticket = Ticket::findOrFail($id);

        if ($ticket->assigned_to !== null) {
            return redirect()->route('support.tickets')
                ->with('error', 'Tiket ini sudah ditugaskan ke teknisi lain.');
        }

        $ticket->assigned_to = auth()->id();
        $ticket->status = 'progress';
        $ticket->save();

        // Kirim notifikasi ke pembuat tiket
        if ($ticket->user) {
            $ticket->user->notify(new TicketAssignedNotification($ticket, auth()->user()));
        }

        return redirect()->route('support.tickets')
            ->with('success', 'Tiket berhasil ditugaskan ke diri Anda sendiri.');
    }

    public function create()
    {
        return view('tickets.create');
    }

    public function all(Request $request)
    {
        $filterStatus = $request->query('status');
        $filterPriority = $request->query('priority');
        $filterCategory = $request->query('category');
        $filterDateFrom = $request->query('date_from');
        $filterDateTo = $request->query('date_to');

        $ticketsQuery = Ticket::with(['user', 'assignedSupport'])->latest();

        if ($filterStatus) {
            $ticketsQuery->where('status', $filterStatus);
        }
        if ($filterPriority) {
            $ticketsQuery->where('priority', $filterPriority);
        }
        if ($filterCategory) {
            $ticketsQuery->where('category', $filterCategory);
        }
        if ($filterDateFrom) {
            $ticketsQuery->whereDate('created_at', '>=', $filterDateFrom);
        }
        if ($filterDateTo) {
            $ticketsQuery->whereDate('created_at', '<=', $filterDateTo);
        }

        $tickets = $ticketsQuery->paginate(15)->appends($request->query());

        // Get distinct categories
        $categories = Ticket::select('category')->distinct()->orderBy('category')->pluck('category');

        return view('support.tickets', compact(
            'tickets',
            'categories',
            'filterStatus',
            'filterPriority',
            'filterCategory',
            'filterDateFrom',
            'filterDateTo'
        ));
    }


    public function show($id)
    {
        $ticket = Ticket::with(['user', 'assignedSupport', 'histories.user', 'messages.user'])->findOrFail($id);
        
        $user = auth()->user();
        if ($ticket->user_id !== $user->id && $user->role !== 'support' && $user->role !== 'admin') {
            abort(403, 'Anda tidak memiliki akses ke tiket ini.');
        }

        // Fallback: Jika tiket belum memiliki analisis AI, lakukan analisis sekarang
        if (empty($ticket->ai_summary)) {
            $aiData = $this->generateTicketAIFields($ticket->subject, $ticket->description, $ticket->category);
            $ticket->update([
                'ai_summary' => $aiData['ai_summary'],
                'ai_causes' => $aiData['ai_causes'],
                'ai_recommendations' => $aiData['ai_recommendations'],
                'ai_confidence' => $aiData['ai_confidence'],
            ]);
            $ticket->refresh();
        }

        // Cari tiket serupa untuk teknisi dan admin
        $similarTickets = [];
        if ($user->role === 'support' || $user->role === 'admin') {
            $similarTickets = $this->findSimilarTickets($ticket);
        }

        return view('tickets.show', compact('ticket', 'similarTickets'));
    }

    public function update(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);

        $request->validate([
            'status' => 'required|in:open,progress,resolved,closed',
            'priority' => 'required|in:low,medium,high',
            'assigned_to' => [
                'nullable',
                function ($attribute, $value, $fail) use ($ticket) {
                    if ($value != auth()->id() && $value != $ticket->assigned_to && !empty($value)) {
                        $fail('Anda hanya dapat menugaskan tiket ini ke diri Anda sendiri.');
                    }
                }
            ],
            'notes' => 'nullable|string',
        ]);

        $oldStatus = $ticket->status;
        $oldPriority = $ticket->priority;
        $oldAssignedTo = $ticket->assigned_to;

        $ticket->status = $request->status;
        $ticket->priority = $request->priority;
        if ($request->assigned_to) {
            $ticket->assigned_to = $request->assigned_to;
        }

        // Jalankan ringkasan penyelesaian otomatis jika status diselesaikan/ditutup dan belum ada
        if (in_array($request->status, ['resolved', 'closed']) && empty($ticket->resolution_summary)) {
            $ticket->resolution_summary = $this->generateResolutionSummary($ticket, $request->notes);
        }

        $ticket->save();

        // Cari tahu atribut apa saja yang berubah untuk dicatat ke riwayat
        $newAssignedTo = $request->assigned_to ? (int)$request->assigned_to : $oldAssignedTo;
        $changes = [];

        $statusLabels = [
            'open' => 'Dibuka',
            'progress' => 'Sedang Diproses',
            'resolved' => 'Diselesaikan',
            'closed' => 'Ditutup',
        ];

        $priorityLabels = [
            'low' => 'Rendah',
            'medium' => 'Sedang',
            'high' => 'Tinggi',
        ];

        if ($oldStatus !== $request->status) {
            $oldLbl = $statusLabels[$oldStatus] ?? $oldStatus;
            $newLbl = $statusLabels[$request->status] ?? $request->status;
            if ($oldStatus === 'open' && $oldAssignedTo) {
                $oldLbl = 'Ditangani';
            }
            if ($request->status === 'open' && $newAssignedTo) {
                $newLbl = 'Ditangani';
            }
            $changes[] = "Mengubah status dari '{$oldLbl}' menjadi '{$newLbl}'";
        }

        if ($oldPriority !== $request->priority) {
            $oldLbl = $priorityLabels[$oldPriority] ?? $oldPriority;
            $newLbl = $priorityLabels[$request->priority] ?? $request->priority;
            $changes[] = "Mengubah prioritas dari '{$oldLbl}' menjadi '{$newLbl}'";
        }

        if ($oldAssignedTo != $newAssignedTo) {
            if (empty($oldAssignedTo) && !empty($newAssignedTo)) {
                $supportName = \App\Models\User::find($newAssignedTo)->name ?? 'Teknisi';
                $changes[] = "Mengambil tiket ini (ditugaskan ke {$supportName})";
            } elseif (!empty($oldAssignedTo) && empty($newAssignedTo)) {
                $changes[] = "Melepas penugasan tiket";
            } else {
                $oldSupportName = \App\Models\User::find($oldAssignedTo)->name ?? 'Teknisi';
                $newSupportName = \App\Models\User::find($newAssignedTo)->name ?? 'Teknisi';
                $changes[] = "Mengubah penugasan dari {$oldSupportName} menjadi {$newSupportName}";
            }
        }

        $autoNotes = implode(', ', $changes);
        $finalNotes = $request->notes;
        if (empty($finalNotes)) {
            $finalNotes = $autoNotes;
        } else {
            $finalNotes = $autoNotes ? $autoNotes . '. Catatan: ' . $finalNotes : $finalNotes;
        }

        // Hanya simpan history jika ada perubahan status/prioritas/penugasan atau ada catatan yang ditambahkan
        if (!empty($changes) || !empty($request->notes)) {
            TicketHistory::create([
                'ticket_id' => $ticket->id,
                'user_id' => auth()->id(),
                'old_status' => $oldStatus,
                'new_status' => $request->status,
                'notes' => $finalNotes ?: null,
            ]);

            // Kirim notifikasi jika ada perubahan status/prioritas/penugasan
            if (!empty($changes) && $ticket->user && $ticket->user_id !== auth()->id()) {
                $ticket->user->notify(new TicketStatusUpdatedNotification($ticket, auth()->user(), $changes));
            }
            
            return redirect()->route('tickets.show', $ticket->id)
                ->with('success', 'Ticket berhasil diperbarui');
        }

        return redirect()->route('tickets.show', $ticket->id);
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required',
            'description' => 'required',
            'category' => 'required|in:Hardware POS,Printer Thermal,Barcode Scanner,Jaringan & Internet,CCTV,Software POS,Server & Database',
            'attachment' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('attachments', 'public');
        }

        // Cek apakah data AI sudah disediakan dari Chatbot
        if ($request->filled('ai_summary')) {
            $aiData = [
                'ai_summary' => $request->ai_summary,
                'ai_causes' => $request->ai_causes,
                'ai_recommendations' => $request->ai_recommendations,
                'ai_confidence' => $request->ai_confidence,
                'priority' => $request->priority ?: 'low',
            ];
        } else {
            // Jika manual, panggil AI secara sinkron
            $aiData = $this->generateTicketAIFields($request->subject, $request->description, $request->category);
        }

        $ticket = Ticket::create([
            'user_id' => auth()->id(),
            'subject' => $request->subject,
            'description' => $request->description,
            'category' => $request->category,
            'priority' => $aiData['priority'] ?: 'low',
            'attachment' => $attachmentPath,
            'ai_summary' => $aiData['ai_summary'],
            'ai_causes' => $aiData['ai_causes'],
            'ai_recommendations' => $aiData['ai_recommendations'],
            'ai_confidence' => $aiData['ai_confidence'],
        ]);

        // Kirim notifikasi ke support dan admin
        $recipients = User::whereIn('role', ['support', 'admin'])->get();
        Notification::send($recipients, new TicketCreatedNotification($ticket));

        return redirect()->route('tickets.index')->with('success', 'Ticket berhasil dibuat');
    }

    public function storeMessage(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $ticket = Ticket::findOrFail($id);
        $user = auth()->user();

        // Otorisasi: Hanya pembuat tiket, staff support, atau admin yang bisa berkirim pesan
        if ($ticket->user_id !== $user->id && $user->role !== 'support' && $user->role !== 'admin') {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Forbidden'], 403);
            }
            abort(403, 'Anda tidak memiliki akses ke tiket ini.');
        }

        $msg = TicketMessage::create([
            'ticket_id' => $ticket->id,
            'user_id'   => $user->id,
            'message'   => $request->message,
        ]);

        $msg->load('user');

        // Kirim notifikasi pesan baru
        if ($user->id === $ticket->user_id) {
            if ($ticket->assigned_to && $ticket->assignedSupport) {
                $ticket->assignedSupport->notify(new NewTicketMessageNotification($ticket, $msg));
            } else {
                $recipients = User::whereIn('role', ['support', 'admin'])->get();
                foreach ($recipients as $recipient) {
                    if ($recipient->id !== $user->id) {
                        $recipient->notify(new NewTicketMessageNotification($ticket, $msg));
                    }
                }
            }
        } else {
            if ($ticket->user && $ticket->user_id !== $user->id) {
                $ticket->user->notify(new NewTicketMessageNotification($ticket, $msg));
            }
        }

        if ($request->expectsJson()) {
            return response()->json([
                'id'          => $msg->id,
                'message'     => $msg->message,
                'user_id'     => $msg->user_id,
                'user_name'   => $msg->user->name,
                'user_role'   => $msg->user->role,
                'created_at'  => $msg->created_at->format('d-m-Y H:i'),
            ]);
        }

        return redirect()->route('tickets.show', $ticket->id)
            ->with('success', 'Pesan berhasil dikirim.');
    }

    public function getMessages(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);
        $user   = auth()->user();

        // Otorisasi
        if ($ticket->user_id !== $user->id && $user->role !== 'support' && $user->role !== 'admin') {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        $after = $request->query('after', 0); // ID terakhir yang sudah diterima klien

        $messages = TicketMessage::with('user')
            ->where('ticket_id', $ticket->id)
            ->where('id', '>', $after)
            ->orderBy('id')
            ->get()
            ->map(fn($msg) => [
                'id'         => $msg->id,
                'message'    => $msg->message,
                'user_id'    => $msg->user_id,
                'user_name'  => $msg->user->name,
                'user_role'  => $msg->user->role,
                'created_at' => $msg->created_at->format('d-m-Y H:i'),
            ]);

        return response()->json($messages);
    }

    public function close($id)
    {
        $ticket = Ticket::findOrFail($id);
        $user = auth()->user();

        // Otorisasi: Hanya pembuat tiket (user) atau admin yang bisa mengonfirmasi/menutup tiket
        if ($ticket->user_id !== $user->id && $user->role !== 'admin') {
            abort(403, 'Anda tidak memiliki akses untuk menutup tiket ini.');
        }

        if ($ticket->status !== 'resolved') {
            return redirect()->route('tickets.show', $ticket->id)
                ->with('error', 'Tiket hanya dapat ditutup setelah status diselesaikan.');
        }

        $oldStatus = $ticket->status;
        $ticket->status = 'closed';

        // Jalankan ringkasan penyelesaian otomatis jika belum ada
        if (empty($ticket->resolution_summary)) {
            $ticket->resolution_summary = $this->generateResolutionSummary($ticket, 'User mengonfirmasi penyelesaian tiket. Status diubah menjadi Ditutup.');
        }

        $ticket->save();

        // Catat riwayat perubahan tiket
        \App\Models\TicketHistory::create([
            'ticket_id' => $ticket->id,
            'user_id' => $user->id,
            'old_status' => $oldStatus,
            'new_status' => 'closed',
            'notes' => 'User mengonfirmasi penyelesaian tiket. Status diubah menjadi Ditutup.',
        ]);

        // Kirim notifikasi ke teknisi yang ditugaskan
        if ($ticket->assigned_to && $ticket->assignedSupport && $ticket->assigned_to !== $user->id) {
            $ticket->assignedSupport->notify(new TicketClosedNotification($ticket, $user));
        }

        return redirect()->route('tickets.show', $ticket->id)
            ->with('success', 'Penyelesaian tiket berhasil dikonfirmasi.');
    }

    public function reopen($id)
    {
        $ticket = Ticket::findOrFail($id);
        $user = auth()->user();

        // Otorisasi: Hanya pembuat tiket atau admin yang bisa membuka kembali tiket
        if ($ticket->user_id !== $user->id && $user->role !== 'admin') {
            abort(403, 'Anda tidak memiliki akses untuk membuka kembali tiket ini.');
        }

        if ($ticket->status !== 'closed') {
            return redirect()->route('tickets.show', $ticket->id)
                ->with('error', 'Hanya tiket yang ditutup yang dapat dibuka kembali.');
        }

        // Cek limit waktu 48 jam
        $closedHistory = TicketHistory::where('ticket_id', $ticket->id)
            ->where('new_status', 'closed')
            ->latest()
            ->first();
        $closedTime = $closedHistory ? $closedHistory->created_at : $ticket->updated_at;

        if (now()->diffInHours($closedTime) > 48) {
            return redirect()->route('tickets.show', $ticket->id)
                ->with('error', 'Batas waktu untuk membuka kembali tiket ini telah habis (maksimal 48 jam setelah ditutup).');
        }

        $oldStatus = $ticket->status;
        $newStatus = $ticket->assigned_to ? 'progress' : 'open';
        $ticket->status = $newStatus;
        $ticket->save();

        TicketHistory::create([
            'ticket_id' => $ticket->id,
            'user_id' => $user->id,
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
            'notes' => 'User membuka kembali tiket yang ditutup. Status diubah kembali menjadi ' . ($newStatus === 'progress' ? 'Sedang Diproses' : 'Dibuka') . '.',
        ]);

        // Kirim notifikasi tiket dibuka kembali
        if ($ticket->assigned_to && $ticket->assignedSupport && $ticket->assigned_to !== $user->id) {
            $ticket->assignedSupport->notify(new TicketReopenedNotification($ticket, $user));
        } else {
            $recipients = User::whereIn('role', ['support', 'admin'])->get();
            foreach ($recipients as $recipient) {
                if ($recipient->id !== $user->id) {
                    $recipient->notify(new TicketReopenedNotification($ticket, $user));
                }
            }
        }

        return redirect()->route('tickets.show', $ticket->id)
            ->with('success', 'Tiket berhasil dibuka kembali.');
    }

    /**
     * Generate AI analysis fields for manual tickets.
     */
    private function generateTicketAIFields($subject, $description, $category): array
    {
        try {
            $apiKey = env('OPENROUTER_API_KEY', '');
            if (empty($apiKey)) {
                return [
                    'ai_summary' => 'Ringkasan masalah tidak tersedia (API key belum dikonfigurasi).',
                    'ai_causes' => "- Tidak dapat menganalisis kemungkinan penyebab.",
                    'ai_recommendations' => "1. Lakukan pengecekan manual pada perangkat/sistem terkait.",
                    'ai_confidence' => 'N/A',
                    'priority' => 'low'
                ];
            }

            $systemPrompt = "Anda adalah asisten analisis IT Helpdesk yang cerdas. "
                . "Tugas Anda adalah menganalisis tiket bantuan yang ditulis secara manual oleh pengguna (berisi Judul, Deskripsi, dan Kategori), "
                . "kemudian menyusun analisis masalah dalam format JSON yang valid.\n\n"
                . "Format JSON harus memiliki key persis seperti berikut:\n"
                . "{\n"
                . "  \"ai_summary\": \"Ringkasan masalah singkat dalam 1-2 kalimat\",\n"
                . "  \"ai_causes\": \"Daftar kemungkinan penyebab masalah (pisahkan dengan bullet point atau baris baru)\",\n"
                . "  \"ai_recommendations\": \"Daftar rekomendasi langkah penanganan terstruktur untuk teknisi (pisahkan dengan bullet point atau baris baru)\",\n"
                . "  \"ai_confidence\": \"Persentase keyakinan rekomendasi ini (contoh: '80%')\",\n"
                . "  \"priority\": \"Saran prioritas (pilih salah satu dari: low, medium, high)\"\n"
                . "}\n\n"
                . "PENTING:\n"
                . "1. Berikan HANYA teks JSON yang valid. Jangan sertakan pembungkus markdown ```json atau ```, dan jangan berikan penjelasan di luar JSON tersebut.\n"
                . "2. Prioritas harus salah satu dari: low, medium, high.\n"
                . "3. Analisis harus ditulis dalam bahasa Indonesia yang formal.";

            $model = env('OPENROUTER_MODEL', 'gpt-4o-mini');

            $response = \Illuminate\Support\Facades\Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->timeout(30)->withoutVerifying()->post(
                'https://openrouter.ai/api/v1/chat/completions',
                [
                    'model' => $model,
                    'messages' => [
                        ['role' => 'system', 'content' => $systemPrompt],
                        ['role' => 'user', 'content' => "Judul: $subject\nDeskripsi: $description\nKategori: $category"]
                    ],
                    'temperature' => 0.4,
                ]
            );

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['choices'][0]['message']['content'])) {
                    $content = trim($data['choices'][0]['message']['content']);
                    if (str_starts_with($content, '```')) {
                        $content = preg_replace('/^```(?:json)?\n?|```$/i', '', $content);
                    }
                    $content = trim($content);
                    $decoded = json_decode($content, true);
                    if (json_last_error() === JSON_ERROR_NONE) {
                        return [
                            'ai_summary' => $decoded['ai_summary'] ?? '',
                            'ai_causes' => $decoded['ai_causes'] ?? '',
                            'ai_recommendations' => $decoded['ai_recommendations'] ?? '',
                            'ai_confidence' => $decoded['ai_confidence'] ?? '80%',
                            'priority' => strtolower($decoded['priority'] ?? 'low')
                        ];
                    }
                }
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Synchronous Ticket AI Analysis Failed: ' . $e->getMessage());
        }

        return [
            'ai_summary' => 'Gagal menghasilkan ringkasan otomatis karena gangguan koneksi AI.',
            'ai_causes' => '- Analisis penyebab tidak tersedia.',
            'ai_recommendations' => '1. Silakan periksa detail kendala secara manual.',
            'ai_confidence' => 'N/A',
            'priority' => 'low'
        ];
    }

    /**
     * Find similar tickets using Gemini AI.
     */
    private function findSimilarTickets($ticket): array
    {
        try {
            // Ambil tiket yang sudah diselesaikan/ditutup dan memiliki resolution_summary
            $resolvedTickets = Ticket::whereIn('status', ['resolved', 'closed'])
                ->whereNotNull('resolution_summary')
                ->where('id', '!=', $ticket->id)
                ->latest()
                ->take(15) // Batasi 15 tiket terakhir agar token tidak bengkak
                ->get(['id', 'subject', 'category', 'resolution_summary']);

            if ($resolvedTickets->isEmpty()) {
                return [];
            }

            $apiKey = env('OPENROUTER_API_KEY', '');
            if (empty($apiKey)) {
                return [];
            }

            // Susun teks daftar tiket resolved untuk AI
            $candidatesText = "";
            foreach ($resolvedTickets as $candidate) {
                $candidatesText .= "ID: {$candidate->id} | Kategori: {$candidate->category} | Judul: {$candidate->subject}\n";
                // Bersihkan ringkasan resolusi agar ringkas
                $resolution = \Illuminate\Support\Str::limit($candidate->resolution_summary, 150);
                $candidatesText .= "Resolusi: {$resolution}\n---\n";
            }

            $systemPrompt = "Anda adalah asisten pencari kasus IT Helpdesk yang cerdas. "
                . "Tugas Anda adalah membandingkan sebuah tiket kendala aktif dengan daftar tiket lama yang sudah diselesaikan. "
                . "Temukan maksimal 3 tiket paling serupa dari daftar tersebut yang solusinya dapat membantu menyelesaikan tiket aktif.\n\n"
                . "Format respon harus berupa JSON array berisi objek dengan format:\n"
                . "[\n"
                . "  {\n"
                . "    \"id\": 123,\n"
                . "    \"similarity\": \"Tinggi/Sedang\",\n"
                . "    \"reason\": \"Jelaskan secara singkat alasan kesamaan dan mengapa solusi tiket ini relevan.\"\n"
                . "  }\n"
                . "]\n\n"
                . "PENTING: Kembalikan HANYA JSON array yang valid tanpa pembungkus markdown ```json. Jika tidak ada tiket yang serupa, kembalikan array kosong `[]`.";

            $model = env('OPENROUTER_MODEL', 'gpt-4o-mini');

            $response = \Illuminate\Support\Facades\Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->timeout(30)->withoutVerifying()->post(
                'https://openrouter.ai/api/v1/chat/completions',
                [
                    'model' => $model,
                    'messages' => [
                        ['role' => 'system', 'content' => $systemPrompt],
                        ['role' => 'user', 'content' => "TICKET AKTIF:\nJudul: {$ticket->subject}\nDeskripsi: {$ticket->description}\nKategori: {$ticket->category}\n\nDAFTAR KASUS LAMA:\n{$candidatesText}"]
                    ],
                    'temperature' => 0.2,
                ]
            );

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['choices'][0]['message']['content'])) {
                    $content = trim($data['choices'][0]['message']['content']);
                    if (str_starts_with($content, '```')) {
                        $content = preg_replace('/^```(?:json)?\n?|```$/i', '', $content);
                    }
                    $content = trim($content);
                    $matches = json_decode($content, true);

                    if (json_last_error() === JSON_ERROR_NONE && is_array($matches)) {
                        $result = [];
                        foreach ($matches as $match) {
                            $matchId = $match['id'] ?? null;
                            if ($matchId) {
                                $matchedTicket = Ticket::find($matchId);
                                if ($matchedTicket) {
                                    $result[] = [
                                        'ticket' => $matchedTicket,
                                        'similarity' => $match['similarity'] ?? 'Sedang',
                                        'reason' => $match['reason'] ?? ''
                                    ];
                                }
                            }
                        }
                        return $result;
                    }
                }
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Find Similar Tickets Failed: ' . $e->getMessage());
        }

        return [];
    }

    /**
     * Generate resolution summary using Gemini AI.
     */
    private function generateResolutionSummary($ticket, $techNotes = null): string
    {
        try {
            $apiKey = env('OPENROUTER_API_KEY', '');
            if (empty($apiKey)) {
                return "Masalah: {$ticket->subject}\nPenyebab: Tidak dapat menganalisis (API key belum dikonfigurasi).\nSolusi: Tiket diselesaikan oleh teknisi.\nStatus: Selesai.";
            }

            // Ambil percakapan diskusi tiket
            $discussionMessages = $ticket->messages()->orderBy('created_at', 'asc')->get();
            $discussionText = "";
            foreach ($discussionMessages as $msg) {
                $role = $msg->user->role === 'support' ? 'Teknisi' : ($msg->user->role === 'admin' ? 'Admin' : 'User');
                $discussionText .= "[$role - {$msg->user->name}]: {$msg->message}\n";
            }

            $systemPrompt = "Anda adalah asisten dokumentasi IT Helpdesk. "
                . "Tugas Anda adalah menganalisis riwayat tiket, keluhan awal, catatan teknisi, dan seluruh jalannya diskusi tiket bantuan ini, "
                . "kemudian menyusun sebuah Ringkasan Penyelesaian Akhir yang terstruktur.\n\n"
                . "Ringkasan harus berformat persis seperti berikut (dalam bahasa Indonesia):\n"
                . "Masalah:\n[Ringkasan singkat masalah awal]\n\n"
                . "Penyebab:\n[Kemungkinan atau penyebab pasti yang diidentifikasi]\n\n"
                . "Solusi:\n[Langkah-langkah yang berhasil dilakukan untuk menyelesaikan masalah]\n\n"
                . "Status:\nSelesai\n\n"
                . "PENTING: Jangan gunakan format markdown lain, langsung berikan teks terstruktur sesuai format di atas.";

            $model = env('OPENROUTER_MODEL', 'gpt-4o-mini');

            $response = \Illuminate\Support\Facades\Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->timeout(30)->withoutVerifying()->post(
                'https://openrouter.ai/api/v1/chat/completions',
                [
                    'model' => $model,
                    'messages' => [
                        ['role' => 'system', 'content' => $systemPrompt],
                        ['role' => 'user', 'content' => "TICKET DETAILS:\nJudul: {$ticket->subject}\nDeskripsi: {$ticket->description}\nKategori: {$ticket->category}\n\nCATATAN TEKNISI:\n" . ($techNotes ?: 'Tidak ada catatan khusus.') . "\n\nDISKUSI OBROLAN:\n" . ($discussionText ?: 'Tidak ada obrolan.')]
                    ],
                    'temperature' => 0.3,
                ]
            );

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['choices'][0]['message']['content'])) {
                    return trim($data['choices'][0]['message']['content']);
                }
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Generate Resolution Summary Failed: ' . $e->getMessage());
        }

        return "Masalah: {$ticket->subject}\nPenyebab: Diidentifikasi oleh teknisi secara langsung.\nSolusi: Langkah penanganan diselesaikan berdasarkan diskusi.\nStatus: Selesai.";
    }
}

