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
            $apiKey = env('GEMINI_API_KEY');
            
            if (!$apiKey) {
                return 'Maaf, API key Gemini tidak dikonfigurasi. Silakan hubungi administrator.';
            }

            // Create prompt for Gemini - FOKUS TEKNOLOGI SAJA
            $systemPrompt = "Anda adalah technical support chatbot yang specialist di bidang TEKNOLOGI. "
                . "PENTING: Anda HANYA menjawab pertanyaan yang berkaitan dengan TEKNOLOGI, PROGRAMMING, TEKNIS, IT, SOFTWARE, HARDWARE, DATABASE, CLOUD, CYBERSECURITY, dll. "
                . "Jika user bertanya tentang hal NON-TEKNOLOGI (seperti kuliner, olahraga, gosip, etc), TOLAK dengan halus dan ajak mereka untuk bertanya tentang TEKNOLOGI. "
                . "Gunakan bahasa Indonesia yang ramah dan profesional. "
                . "Berikan jawaban yang SINGKAT dan PRAKTIS (maksimal 3-4 kalimat). "
                . "Jika ada kode atau command teknis, berikan dalam format yang jelas.";
            
            $fullPrompt = $systemPrompt . "\n\nPertanyaan pengguna: " . $userMessage;

            // Call Gemini API
            $response = Http::timeout(10)->post(
                'https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent',
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
                        'temperature' => 0.7,
                        'topP' => 0.9,
                        'topK' => 40,
                        'maxOutputTokens' => 300,
                    ]
                ],
                [
                    'x-goog-api-key' => $apiKey,
                ]
            );

            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
                    $geminiResponse = $data['candidates'][0]['content']['parts'][0]['text'];
                    return trim($geminiResponse);
                }
            }

            // Fallback jika ada error
            return $this->getFallbackResponse($userMessage);

        } catch (\Exception $e) {
            // Log error
            \Log::error('Gemini AI Error: ' . $e->getMessage());
            
            // Return fallback response
            return $this->getFallbackResponse($userMessage);
        }
    }

    /**
     * Fallback response when AI fails (keyword matching for technology topics).
     */
    private function getFallbackResponse(string $message): string
    {
        $message = strtolower($message);

        // Check for technology-related keywords
        if (strpos($message, 'error') !== false || strpos($message, 'bug') !== false || strpos($message, 'masalah') !== false) {
            return 'Jelaskan lebih detail tentang error atau masalah teknis yang Anda hadapi. Berikan informasi seperti: pesan error, kapan terjadi, dan langkah-langkah yang sudah Anda coba.';
        }

        if (strpos($message, 'install') !== false || strpos($message, 'setup') !== false || strpos($message, 'instal') !== false) {
            return 'Untuk proses instalasi, saya perlu tahu aplikasi atau tool apa yang ingin Anda install. Berikan detail platform (Windows/Linux/Mac) dan versinya.';
        }

        if (strpos($message, 'database') !== false || strpos($message, 'sql') !== false || strpos($message, 'mysql') !== false) {
            return 'Pertanyaan tentang database sangat umum. Spesifikasi mana: struktur tabel, query, backup, atau performa?';
        }

        if (strpos($message, 'api') !== false || strpos($message, 'rest') !== false) {
            return 'Untuk membantu dengan API, sebutkan teknologi yang digunakan dan masalah spesifiknya.';
        }

        if (strpos($message, 'programming') !== false || strpos($message, 'coding') !== false || strpos($message, 'code') !== false) {
            return 'Pilih bahasa pemrograman yang ingin Anda tanyakan (PHP, Python, JavaScript, Java, dll) dan masalah spesifiknya.';
        }

        if (strpos($message, 'server') !== false || strpos($message, 'hosting') !== false) {
            return 'Untuk pertanyaan server/hosting, jelaskan setup Anda (on-premise, cloud, VPS) dan masalahnya.';
        }

        if (strpos($message, 'security') !== false || strpos($message, 'password') !== false || strpos($message, 'encrypt') !== false) {
            return 'Keamanan teknologi adalah topik penting. Spesifikkan: tipe security yang Anda pertanyakan atau masalah keamanan yang Anda hadapi.';
        }

        if (strpos($message, 'performance') !== false || strpos($message, 'speed') !== false || strpos($message, 'lambat') !== false) {
            return 'Untuk optimasi performa, jelaskan: aplikasi apa, resource usage berapa, dan sudah mencoba apa saja?';
        }

        if (strpos($message, 'halo') !== false || strpos($message, 'hi') !== false || strpos($message, 'hello') !== false) {
            return 'Halo! 👋 Saya adalah technical support chatbot. Tanyakan apapun tentang TEKNOLOGI, PROGRAMMING, IT, atau masalah teknis lainnya.';
        }

        // Default: redirect ke topik teknologi
        return 'Maaf, saya hanya bisa membantu dengan pertanyaan seputar TEKNOLOGI, PROGRAMMING, IT, dan masalah teknis lainnya. Ada yang ingin ditanyakan tentang teknologi?';
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
