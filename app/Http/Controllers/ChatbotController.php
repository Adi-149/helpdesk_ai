<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use App\Models\ChatbotConversation;
use App\Models\ChatMessage;

class ChatbotController extends Controller
{
    /**
     * Batas maksimal pesan user per sesi.
     */
    private const MAX_USER_MESSAGES = 10;
    /**
     * Display the chatbot page with single session chat.
     */
    public function index(): View
    {
        // Get active conversation or create one
        $conversation = ChatbotConversation::firstOrCreate([
            'user_id' => auth()->id(),
            'status' => 'active',
        ], [
            'title' => 'Percakapan IT Helpdesk',
        ]);

        $messages = $conversation->messages;

        return view('chatbot.index', compact('messages'));
    }

    /**
     * Send a message to the chatbot and get response using Gemini AI.
     */
    public function sendMessage(Request $request): JsonResponse
    {
        $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        // Get or create active conversation
        $conversation = ChatbotConversation::firstOrCreate([
            'user_id' => auth()->id(),
            'status' => 'active',
        ], [
            'title' => 'Percakapan IT Helpdesk',
        ]);

        // Cek batas pesan user per sesi
        $userMessageCount = ChatMessage::where('chatbot_conversation_id', $conversation->id)
            ->where('sender_type', 'user')
            ->count();

        if ($userMessageCount >= self::MAX_USER_MESSAGES) {
            return response()->json([
                'success' => false,
                'limit_reached' => true,
                'message' => 'Anda telah mencapai batas maksimal ' . self::MAX_USER_MESSAGES . ' pesan untuk sesi ini. Silakan hapus chat untuk memulai sesi baru.',
                'user_message_count' => $userMessageCount,
                'max_messages' => self::MAX_USER_MESSAGES,
            ], 429);
        }

        // Generate bot response using Gemini AI
        $botResponse = $this->generateGeminiResponse($conversation, $request->message);

        // Save user message to database
        $userMessage = ChatMessage::create([
            'chatbot_conversation_id' => $conversation->id,
            'user_id' => auth()->id(),
            'message' => $request->message,
            'sender_type' => 'user',
            'response' => null,
        ]);

        // Save bot message to database
        $botMessage = ChatMessage::create([
            'chatbot_conversation_id' => $conversation->id,
            'user_id' => auth()->id(),
            'message' => $botResponse,
            'sender_type' => 'bot',
            'response' => $botResponse,
        ]);

        return response()->json([
            'success' => true,
            'user_message' => [
                'id' => $userMessage->id,
                'sender_type' => 'user',
                'message' => $userMessage->message,
                'response' => null,
                'timestamp' => $userMessage->created_at->format('H:i'),
            ],
            'bot_message' => [
                'id' => $botMessage->id,
                'sender_type' => 'bot',
                'message' => $botMessage->message,
                'response' => $botMessage->response,
                'timestamp' => $botMessage->created_at->format('H:i'),
            ],
            'user_message_count' => $userMessageCount + 1,
            'max_messages' => self::MAX_USER_MESSAGES,
        ]);
    }

    /**
     * Analyze active chatbot conversation using Gemini AI to suggest ticket details.
     */
    public function analyzeConversation(Request $request): JsonResponse
    {
        $conversation = ChatbotConversation::where('user_id', auth()->id())
            ->where('status', 'active')
            ->first();

        if (!$conversation) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada percakapan aktif untuk dianalisis.'
            ], 404);
        }

        $messages = $conversation->messages()->orderBy('created_at', 'asc')->get();

        if ($messages->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Percakapan kosong.'
            ], 400);
        }

        try {
            $apiKey = env('OPENROUTER_API_KEY', '');
            if (empty($apiKey)) {
                return response()->json([
                    'success' => false,
                    'message' => 'OpenRouter API key is not configured.'
                ], 500);
            }

            $conversationText = "";
            foreach ($messages as $msg) {
                $sender = $msg->sender_type === 'user' ? 'User' : 'Asisten AI';
                $conversationText .= "[$sender]: " . $msg->message . "\n";
            }

            $systemPrompt = "Anda adalah asisten analisis IT Helpdesk yang cerdas. "
                . "Tugas Anda adalah menganalisis riwayat percakapan antara pengguna (User) dan asisten AI mengenai kendala IT berikut, "
                . "kemudian menyusun rancangan tiket bantuan dalam format JSON yang valid.\n\n"
                . "Format JSON harus memiliki key persis seperti berikut (jangan tambahkan key lain):\n"
                . "{\n"
                . "  \"subject\": \"Judul tiket singkat, deskriptif, dan jelas (maksimal 50 karakter)\",\n"
                . "  \"description\": \"Penjelasan detail mengenai kendala, langkah-langkah yang telah dicoba, dan dampak masalah berdasarkan keluhan user di percakapan\",\n"
                . "  \"category\": \"Kategori masalah (WAJIB salah satu dari: Hardware POS, Printer Thermal, Barcode Scanner, Jaringan & Internet, CCTV, Software POS, Server & Database)\",\n"
                . "  \"priority\": \"Prioritas penanganan (WAJIB salah satu dari: low, medium, high berdasarkan tingkat dampak dan urgensi)\",\n"
                . "  \"ai_summary\": \"Ringkasan masalah singkat dalam 1-2 kalimat\",\n"
                . "  \"ai_causes\": \"Daftar kemungkinan penyebab masalah (pisahkan dengan bullet point atau baris baru)\",\n"
                . "  \"ai_recommendations\": \"Daftar rekomendasi langkah penanganan terstruktur untuk teknisi (pisahkan dengan bullet point atau baris baru)\",\n"
                . "  \"ai_confidence\": \"Persentase keyakinan rekomendasi ini (contoh: '85%')\"\n"
                . "}\n\n"
                . "PENTING:\n"
                . "1. Berikan HANYA teks JSON yang valid. Jangan sertakan pembungkus markdown ```json atau ```, dan jangan berikan penjelasan di luar JSON tersebut.\n"
                . "2. Pilihan Kategori harus persis salah satu dari: Hardware POS, Printer Thermal, Barcode Scanner, Jaringan & Internet, CCTV, Software POS, Server & Database.\n"
                . "3. Pilihan Prioritas harus persis salah satu dari: low, medium, high.\n"
                . "4. Isi deskripsi harus ditulis dengan bahasa Indonesia yang formal, terstruktur, dan mudah dipahami oleh teknisi.";

            $model = env('OPENROUTER_MODEL', 'gpt-4o-mini');

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->timeout(60)->withoutVerifying()->post(
                'https://openrouter.ai/api/v1/chat/completions',
                [
                    'model' => $model,
                    'messages' => [
                        ['role' => 'system', 'content' => $systemPrompt],
                        ['role' => 'user', 'content' => "Berikut adalah riwayat percakapan untuk dianalisis:\n\n" . $conversationText]
                    ],
                    'temperature' => 0.5,
                ]
            );

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['choices'][0]['message']['content'])) {
                    $content = trim($data['choices'][0]['message']['content']);
                    
                    // Bersihkan pembungkus markdown ```json ... ``` jika model tetap memberikannya
                    if (str_starts_with($content, '```')) {
                        $content = preg_replace('/^```(?:json)?\n?|```$/i', '', $content);
                    }
                    $content = trim($content);

                    $ticketData = json_decode($content, true);

                    if (json_last_error() === JSON_ERROR_NONE) {
                        return response()->json([
                            'success' => true,
                            'data' => $ticketData
                        ]);
                    }
                }
            }

            return response()->json([
                'success' => false,
                'message' => 'Gagal menganalisis percakapan. Respon API tidak valid atau gagal.'
            ], 502);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('AI Analysis Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem saat menghubungi AI: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate response using Google Gemini AI.
     */
    private function generateGeminiResponse(ChatbotConversation $conversation, string $userMessage): string
    {
        try {
            // Search Knowledge Base Internal
            $kbService = app(\App\Services\KnowledgeBaseService::class);
            $kbResults = $kbService->searchForChatbot($userMessage, auth()->user()->role ?? 'user');
            $kbContext = $kbService->buildContextForAI($kbResults);

            $apiKey = env('OPENROUTER_API_KEY', '');
            
            if (empty($apiKey)) {
                \Illuminate\Support\Facades\Log::warning('OpenRouter API key is not configured.');
                return $this->getFallbackResponse($userMessage);
            }

            $systemPrompt = "Anda adalah asisten AI khusus IT Helpdesk yang cerdas dan profesional. "
                . "Tugas UTAMA Anda adalah HANYA membantu pengguna dengan pertanyaan atau masalah seputar TEKNOLOGI (seperti komputer, jaringan, software, hardware, internet, programming, dan troubleshooting IT). "
                . "JIKA pengguna bertanya di luar topik teknologi (misalnya: resep makanan, politik, hiburan, olahraga, kehidupan sehari-hari, dll), TOLAK dengan sopan dan jelaskan bahwa Anda hanya dapat membantu seputar masalah teknologi atau IT Helpdesk. "
                . "Berikan jawaban yang akurat dan solutif. PENTING: Jawablah dengan SINGKAT, PADAT, dan LANGSUNG KE INTINYA (to-the-point). Jangan bertele-tele. "
                . "PENTING: Jangan gunakan format Markdown apa pun (jangan gunakan simbol seperti ***, ###, atau ---). Jawab dengan teks biasa (plain text) saja."
                . " PENTING: Jika percakapan sudah di penghujung chat tetapi masalah pengguna masih belum terselesaikan atau tidak bisa diselesaikan, Anda harus menyarankan pengguna agar membuat tiket bantuan di aplikasi ini atau menghubungi nomor teknisi di \"089688267122\".";

            if (!empty($kbContext)) {
                $systemPrompt .= "\n\n" . $kbContext;
            }
            
            // Build conversation history from database
            // Ambil semua pesan dalam sesi secara kronologis (ASC) agar AI ingat konteks
            $dbMessages = ChatMessage::where('chatbot_conversation_id', $conversation->id)
                ->orderBy('created_at', 'asc')
                ->get();
                
            $conversationHistory = [];
            
            foreach ($dbMessages as $msg) {
                $role = $msg->sender_type === 'user' ? 'user' : 'assistant';
                $content = $msg->sender_type === 'user' ? $msg->message : ($msg->response ?? $msg->message);
                $conversationHistory[] = [
                    'role' => $role,
                    'content' => $content
                ];
            }

            // Add current user message
            $conversationHistory[] = [
                'role' => 'user',
                'content' => $userMessage
            ];

            // Determine model from environment to allow workspace-specific endpoints
            $model = env('OPENROUTER_MODEL', 'gpt-4o-mini');

            \Illuminate\Support\Facades\Log::info('OpenRouter Request Debug', [
                'api_key' => substr($apiKey, 0, 20) . '...',
                'model' => $model,
                'conversation_id' => $conversation->id,
                'history_count' => count($conversationHistory),
                'history_preview' => collect($conversationHistory)->map(fn($m) => $m['role'] . ': ' . mb_substr($m['content'], 0, 50))->toArray(),
            ]);

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->timeout(60)->withoutVerifying()->post(
                'https://openrouter.ai/api/v1/chat/completions',
                [
                    'model' => $model,
                    'messages' => array_merge(
                        [['role' => 'system', 'content' => $systemPrompt]],
                        $conversationHistory
                    ),
                    'temperature' => 0.8,
                    'top_p' => 0.95,
                    'max_tokens' => 1000,
                ]
            );

            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['choices'][0]['message']['content'])) {
                    return trim($data['choices'][0]['message']['content']);
                }
            }
            
            \Illuminate\Support\Facades\Log::error('OpenRouter API Response Error: ' . $response->body());

            // Fallback jika ada error (bukan 200 OK)
            return $this->getFallbackResponse($userMessage);

        } catch (\Exception $e) {
            // Log error
            \Illuminate\Support\Facades\Log::error('OpenRouter AI Error: ' . $e->getMessage());
            
            // Return fallback response
            return $this->getFallbackResponse($userMessage);
        }
    }

    /**
     * Fallback response when AI fails (keyword matching for technology topics).
     */
    private function getFallbackResponse(string $message): string
    {
        // 1. Coba cari di local knowledge base dulu sebelum general fallback!
        try {
            $kbService = app(\App\Services\KnowledgeBaseService::class);
            $kbResults = $kbService->searchForChatbot($message, auth()->user()->role ?? 'user');
            if ($kbResults->isNotEmpty()) {
                $first = $kbResults->first();
                return $first->content . "\n\n[Sumber: " . $first->title . "]";
            }
        } catch (\Exception $ex) {
            \Illuminate\Support\Facades\Log::error('KB Fallback Error: ' . $ex->getMessage());
        }

        // Use regex for more robust keyword matching
        $message = strtolower($message);

        $fallbacks = [
            '/\b(wifi|internet|jaringan|koneksi|sinyal|lemot|lag)\b/i' => 
                "Sepertinya Anda mengalami masalah koneksi. Coba langkah berikut:\n1. Pastikan WiFi Anda menyala.\n2. Coba restart router atau modem Anda.\n3. Periksa apakah perangkat lain bisa terhubung.\n\nJika tetap tidak bisa, berikan detail pesan errornya.",
            
            '/\b(error|bug|masalah|rusak|gagal|crash|freeze)\b/i' => 
                "Jelaskan lebih detail tentang error atau masalah teknis yang Anda hadapi. Berikan informasi seperti: pesan error, kapan terjadi, dan langkah-langkah yang sudah Anda coba.",
            
            '/\b(install|setup|instalasi|pasang|download)\b/i' => 
                "Untuk proses instalasi, saya perlu tahu aplikasi atau tool apa yang ingin Anda install. Berikan detail platform (Windows/Linux/Mac) dan versinya.",
            
            '/\b(database|sql|mysql|postgresql|query|tabel)\b/i' => 
                "Pertanyaan tentang database sangat umum. Spesifikasi mana: struktur tabel, query, backup, atau performa?",
            
            '/\b(api|rest|endpoint|json)\b/i' => 
                "Untuk membantu dengan API, sebutkan teknologi yang digunakan dan masalah spesifiknya.",
            
            '/\b(programming|coding|code|php|python|javascript|java|koding)\b/i' => 
                "Pilih bahasa pemrograman yang ingin Anda tanyakan (PHP, Python, JavaScript, Java, dll) dan masalah spesifiknya.",
            
            '/\b(server|hosting|vps|cloud|domain)\b/i' => 
                "Untuk pertanyaan server/hosting, jelaskan setup Anda (on-premise, cloud, VPS) dan masalahnya.",
            
            '/\b(security|password|encrypt|hack|aman|login|lupa)\b/i' => 
                "Keamanan teknologi adalah topik penting. Spesifikkan: tipe security yang Anda pertanyakan atau masalah keamanan yang Anda hadapi (misal: lupa password).",
            
            '/\b(performance|speed|lambat|berat|lemot|ngelag)\b/i' => 
                "Untuk optimasi performa, jelaskan: aplikasi apa, resource usage berapa, dan sudah mencoba apa saja?",
            
            '/\b(halo|hi|hello|pagi|siang|sore|malam|hai)\b/i' => 
                "Halo! 👋 Saya adalah asisten AI Helpdesk. Sedang ada kendala yang bisa saya bantu hari ini?",
        ];

        foreach ($fallbacks as $pattern => $response) {
            if (preg_match($pattern, $message)) {
                return $response;
            }
        }

        // Default: generic helpful response when AI fails
        return "Maaf, sepertinya saya sedang mengalami gangguan koneksi ke server AI utama. Silakan coba tanyakan lagi dalam beberapa saat. Jika kendala Anda mendesak dan tidak bisa diselesaikan, Anda dapat membuat tiket bantuan di aplikasi ini atau menghubungi nomor teknisi kami di 089688267122.";
    }

    /**
     * Clear chat session.
     */
    public function clearChat(): JsonResponse
    {
        // Delete active conversations for the user
        ChatbotConversation::where('user_id', auth()->id())
            ->where('status', 'active')
            ->delete();

        return response()->json([
            'success' => true,
            'message' => 'Chat session cleared',
        ]);
    }
}
