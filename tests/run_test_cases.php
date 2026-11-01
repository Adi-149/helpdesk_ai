<?php
require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Services\KnowledgeBaseService;
use Illuminate\Support\Facades\Http;

$testCases = [
    [
        'id' => 'C01',
        'category' => 'Hardware POS',
        'message' => 'POS terminal does not power on after the power button is pressed.'
    ]
];

$apiKey = env('OPENROUTER_API_KEY');
$model = env('OPENROUTER_MODEL', 'gpt-4o-mini');
$kbService = app(KnowledgeBaseService::class);

foreach ($testCases as $tc) {
    // 1. Chatbot response
    $kbResults = $kbService->searchForChatbot($tc['message'], 'user');
    $kbContext = $kbService->buildContextForAI($kbResults);

    $systemPrompt = "Anda adalah asisten AI khusus IT Helpdesk yang cerdas dan profesional. "
        . "Tugas UTAMA Anda adalah HANYA membantu pengguna dengan pertanyaan atau masalah seputar TEKNOLOGI (seperti komputer, jaringan, software, hardware, internet, programming, dan troubleshooting IT). "
        . "JIKA pengguna bertanya di luar topik teknologi (misalnya: resep makanan, politik, hiburan, olahraga, kehidupan sehari-hari, dll), TOLAK dengan sopan dan jelaskan bahwa Anda hanya dapat membantu seputar masalah teknologi atau IT Helpdesk. "
        . "Berikan jawaban yang akurat dan solutif. PENTING: Jawablah dengan SINGKAT, PADAT, dan LANGSUNG KE INTINYA (to-the-point). Jangan bertele-tele. "
        . "PENTING: Jangan gunakan format Markdown apa pun (jangan gunakan simbol seperti ***, ###, atau ---). Jawab dengan teks biasa (plain text) saja."
        . " PENTING: Jika percakapan sudah di penghujung chat tetapi masalah pengguna masih belum terselesaikan atau tidak bisa diselesaikan, Anda harus menyarankan pengguna agar membuat tiket bantuan di aplikasi ini atau menghubungi nomor teknisi di \"089688267122\".";

    if (!empty($kbContext)) {
        $systemPrompt .= "\n\n" . $kbContext;
    }

    $startTime = microtime(true);

    $botResponse = Http::withHeaders([
        'Authorization' => 'Bearer ' . $apiKey,
        'Content-Type' => 'application/json',
    ])->withoutVerifying()->post('https://openrouter.ai/api/v1/chat/completions', [
        'model' => $model,
        'messages' => [
            ['role' => 'system', 'content' => $systemPrompt],
            ['role' => 'user', 'content' => $tc['message']]
        ],
        'temperature' => 0.7,
        'max_tokens' => 500,
    ]);

    $botReply = trim($botResponse->json()['choices'][0]['message']['content'] ?? '');

    // 2. Ticket analysis
    $analysisPrompt = "Anda adalah asisten analisis IT Helpdesk yang cerdas. "
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

    $conversationText = "[User]: " . $tc['message'] . "\n[Asisten AI]: " . $botReply . "\n";

    $analysisResponse = Http::withHeaders([
        'Authorization' => 'Bearer ' . $apiKey,
        'Content-Type' => 'application/json',
    ])->withoutVerifying()->post('https://openrouter.ai/api/v1/chat/completions', [
        'model' => $model,
        'messages' => [
            ['role' => 'system', 'content' => $analysisPrompt],
            ['role' => 'user', 'content' => "Berikut adalah riwayat percakapan untuk dianalisis:\n\n" . $conversationText]
        ],
        'temperature' => 0.3,
    ]);

    $rawContent = trim($analysisResponse->json()['choices'][0]['message']['content'] ?? '');
    if (str_starts_with($rawContent, '```')) {
        $rawContent = preg_replace('/^```(?:json)?\n?|```$/i', '', $rawContent);
    }
    $ticket = json_decode(trim($rawContent), true);

    echo "=== CASE " . $tc['id'] . " ===\n";
    echo "Bot Reply: " . $botReply . "\n";
    echo "Subject: " . ($ticket['subject'] ?? '-') . "\n";
    echo "Category: " . ($ticket['category'] ?? '-') . "\n";
    echo "Priority: " . ucfirst($ticket['priority'] ?? '-') . "\n";
}
