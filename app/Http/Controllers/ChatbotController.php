<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

class ChatbotController extends Controller
{
    /**
     * Display the chatbot page with single session chat.
     */
    public function index(): View
    {
        // Get messages from session, initialize if not exists
        $messages = session()->get('chatbot_messages', []);

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

        // Get current messages from session
        $messages = session()->get('chatbot_messages', []);

        // Create user message
        $userMessage = [
            'id' => uniqid(),
            'sender_type' => 'user',
            'message' => $request->message,
            'response' => null,
            'timestamp' => now()->format('H:i'),
        ];

        // Generate bot response using Gemini AI
        $botResponse = $this->generateGeminiResponse($request->message);

        // Create bot message
        $botMessage = [
            'id' => uniqid(),
            'sender_type' => 'bot',
            'message' => $botResponse,
            'response' => null,
            'timestamp' => now()->format('H:i'),
        ];

        // Add to messages array
        $messages[] = $userMessage;
        $messages[] = $botMessage;

        // Store in session
        session()->put('chatbot_messages', $messages);

        return response()->json([
            'success' => true,
            'user_message' => $userMessage,
            'bot_message' => $botMessage,
        ]);
    }

    /**
     * Generate response using Google Gemini AI.
     */
    private function generateGeminiResponse(string $userMessage): string
    {
        try {
            $apiKey = config('services.gemini.key', env('GEMINI_API_KEY', ''));
            
            if (empty($apiKey)) {
                \Illuminate\Support\Facades\Log::warning('Gemini API key is not configured.');
                return $this->getFallbackResponse($userMessage);
            }

            $systemPrompt = config('chatbot.system_prompt', "Anda adalah asisten AI khusus IT Helpdesk yang cerdas dan profesional. "
                . "Tugas UTAMA Anda adalah HANYA membantu pengguna dengan pertanyaan atau masalah seputar TEKNOLOGI (seperti komputer, jaringan, software, hardware, internet, programming, dan troubleshooting IT). "
                . "JIKA pengguna bertanya di luar topik teknologi (misalnya: resep makanan, politik, hiburan, olahraga, kehidupan sehari-hari, dll), TOLAK dengan sopan dan jelaskan bahwa Anda hanya dapat membantu seputar masalah teknologi atau IT Helpdesk. "
                . "Berikan jawaban yang akurat dan solutif. PENTING: Jawablah dengan SINGKAT, PADAT, dan LANGSUNG KE INTINYA (to-the-point). Jangan bertele-tele. "
                . "PENTING: Jangan gunakan format Markdown apa pun (jangan gunakan simbol seperti ***, ###, atau ---). Jawab dengan teks biasa (plain text) saja.");
            
            // Build conversation history from session
            $messages = session()->get('chatbot_messages', []);
            $history = "";
            if (!empty($messages)) {
                $history = "Riwayat Percakapan Sebelumnya:\n";
                // Ambil 6 pesan terakhir agar AI ingat konteks tanpa terlalu menghabiskan token
                $recentMessages = array_slice($messages, -6);
                foreach ($recentMessages as $msg) {
                    $role = $msg['sender_type'] === 'user' ? 'Pengguna' : 'AI';
                    $history .= "{$role}: {$msg['message']}\n";
                }
                $history .= "\n";
            }

            $fullPrompt = $systemPrompt . "\n\n" . $history . "Pertanyaan pengguna saat ini: " . $userMessage . "\n\nJawaban AI:";

            // Call Gemini API (with withoutVerifying to prevent local SSL errors on Windows)
            $response = Http::timeout(60)->withoutVerifying()->post(
                'https://generativelanguage.googleapis.com/v1beta/models/gemini-3-flash:generateContent?key=' . $apiKey,
                [
                    'contents' => [
                        [
                            'parts' => [
                                [
                                    'text' => $fullPrompt
                                ]
                            ]
                        ]
                    ],
                    'generationConfig' => [
                        'temperature' => 0.8,
                        'topP' => 0.95,
                        'topK' => 40,
                        'maxOutputTokens' => 8192,
                    ]
                ]
            );

            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
                    return trim($data['candidates'][0]['content']['parts'][0]['text']);
                }
            }
            
            \Illuminate\Support\Facades\Log::error('Gemini API Response Error: ' . $response->body());

            // Fallback jika ada error (bukan 200 OK)
            return $this->getFallbackResponse($userMessage);

        } catch (\Exception $e) {
            // Log error
            \Illuminate\Support\Facades\Log::error('Gemini AI Error: ' . $e->getMessage());
            
            // Return fallback response
            return $this->getFallbackResponse($userMessage);
        }
    }

    /**
     * Fallback response when AI fails (keyword matching for technology topics).
     */
    private function getFallbackResponse(string $message): string
    {
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

        // Default: generic helpful response when API fails
        return "Maaf, sepertinya saya sedang mengalami gangguan koneksi ke server AI utama. Silakan coba tanyakan lagi dalam beberapa saat, atau hubungi tim support jika mendesak.";
    }

    /**
     * Clear chat session.
     */
    public function clearChat(): JsonResponse
    {
        session()->forget('chatbot_messages');

        return response()->json([
            'success' => true,
            'message' => 'Chat session cleared',
        ]);
    }
}
