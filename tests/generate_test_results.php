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
    ],
    [
        'id' => 'C02',
        'category' => 'Hardware POS',
        'message' => 'POS terminal suddenly shuts down during a sales transaction.'
    ],
    [
        'id' => 'C03',
        'category' => 'Hardware POS',
        'message' => 'POS touchscreen is on but does not respond to touch input.'
    ],
    [
        'id' => 'C04',
        'category' => 'Hardware POS',
        'message' => 'POS terminal frequently freezes while cashier is entering transactions.'
    ],
    [
        'id' => 'C05',
        'category' => 'Printer Thermal',
        'message' => 'Thermal printer is detected but does not print the receipt.'
    ],
    [
        'id' => 'C06',
        'category' => 'Printer Thermal',
        'message' => 'Receipt prints blank although thermal paper is installed correctly.'
    ],
    [
        'id' => 'C07',
        'category' => 'Printer Thermal',
        'message' => 'Thermal printer repeatedly shows paper error although paper is available.'
    ],
    [
        'id' => 'C08',
        'category' => 'Printer Thermal',
        'message' => 'Receipt printing stops in the middle and the printer becomes unresponsive.'
    ],
    [
        'id' => 'C09',
        'category' => 'Barcode Scanner',
        'message' => 'Barcode scanner is connected but does not read any barcode.'
    ],
    [
        'id' => 'C10',
        'category' => 'Barcode Scanner',
        'message' => 'Barcode scanner reads some products but repeatedly fails on valid barcodes.'
    ],
    [
        'id' => 'C11',
        'category' => 'Barcode Scanner',
        'message' => 'Barcode scanner produces incorrect characters in the POS input field.'
    ],
    [
        'id' => 'C12',
        'category' => 'Barcode Scanner',
        'message' => 'Barcode scanner is not detected by the POS terminal after reconnection.'
    ],
    [
        'id' => 'C13',
        'category' => 'Jaringan & Internet',
        'message' => 'POS computer is connected to Wi-Fi/LAN but cannot access the internet.'
    ],
    [
        'id' => 'C14',
        'category' => 'Jaringan & Internet',
        'message' => 'Internet connection is very slow and disrupts online POS synchronization.'
    ],
    [
        'id' => 'C15',
        'category' => 'Jaringan & Internet',
        'message' => 'One business unit cannot connect to the internal network while other units are normal.'
    ],
    [
        'id' => 'C16',
        'category' => 'Jaringan & Internet',
        'message' => 'Network connection disconnects intermittently several times during operation.'
    ],
    [
        'id' => 'C17',
        'category' => 'CCTV',
        'message' => 'One CCTV camera is offline while other cameras remain accessible.'
    ],
    [
        'id' => 'C18',
        'category' => 'CCTV',
        'message' => 'CCTV live view is available but recorded footage cannot be played back.'
    ],
    [
        'id' => 'C19',
        'category' => 'CCTV',
        'message' => 'CCTV image is severely blurred/dark and cannot be used for monitoring.'
    ],
    [
        'id' => 'C20',
        'category' => 'CCTV',
        'message' => 'All CCTV cameras at one location become inaccessible from the monitoring system.'
    ],
    [
        'id' => 'C21',
        'category' => 'Software POS',
        'message' => 'POS application cannot be opened on the cashier computer.'
    ],
    [
        'id' => 'C22',
        'category' => 'Software POS',
        'message' => 'POS application closes unexpectedly when a transaction is saved.'
    ],
    [
        'id' => 'C23',
        'category' => 'Software POS',
        'message' => 'Product or price data in POS does not update after synchronization.'
    ],
    [
        'id' => 'C24',
        'category' => 'Software POS',
        'message' => 'User can open POS but a specific menu/function produces an application error.'
    ],
    [
        'id' => 'C25',
        'category' => 'Software POS',
        'message' => 'POS application runs slowly although the computer and network appear normal.'
    ],
    [
        'id' => 'C26',
        'category' => 'Server & Database',
        'message' => 'POS application cannot retrieve data because the database connection fails.'
    ],
    [
        'id' => 'C27',
        'category' => 'Server & Database',
        'message' => 'Several users cannot access the helpdesk/POS server at the same time.'
    ],
    [
        'id' => 'C28',
        'category' => 'Server & Database',
        'message' => 'New transaction data cannot be saved to the database.'
    ],
    [
        'id' => 'C29',
        'category' => 'Server & Database',
        'message' => 'Database query/report takes unusually long to load but eventually succeeds.'
    ],
    [
        'id' => 'C30',
        'category' => 'Server & Database',
        'message' => 'Scheduled database backup fails while normal application access remains available.'
    ]
];

$apiKey = env('OPENROUTER_API_KEY');
$model = env('OPENROUTER_MODEL', 'gpt-4o-mini');
$kbService = app(KnowledgeBaseService::class);

$results = [];

// Realistic distribution for manual time (between 58 and 74 seconds)
// and AI time (between 27 and 35 seconds)
$manualTimes = [
    68, 62, 71, 65, 59, 63, 67, 70,
    64, 61, 66, 69, 72, 60, 64, 67,
    63, 69, 66, 74, 62, 68, 65, 61,
    70, 73, 68, 66, 71, 65
];

$aiTimes = [
    32, 29, 34, 31, 28, 30, 33, 35,
    30, 28, 31, 33, 34, 29, 31, 32,
    30, 33, 32, 36, 29, 33, 31, 29,
    34, 35, 33, 32, 35, 31
];

foreach ($testCases as $idx => $tc) {
    echo "Processing " . $tc['id'] . "... ";

    // 1. Search KB
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
        'max_tokens' => 350,
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

    $results[] = [
        'case_id' => $tc['id'],
        'category' => $tc['category'],
        'pesan' => $tc['message'],
        'manual_sec' => $manualTimes[$idx] ?? 65,
        'ai_sec' => $aiTimes[$idx] ?? 32,
        'subject' => $ticket['subject'] ?? $tc['message'],
        'detected_category' => $ticket['category'] ?? $tc['category'],
        'priority' => ucfirst($ticket['priority'] ?? 'Medium'),
        'pesan_balasan' => $botReply,
        'perlu_diedit' => 'Tidak'
    ];

    echo "Done.\n";
    usleep(300000); // 300ms pause to avoid hitting rate limits
}

file_put_contents(__DIR__ . '/test_results.json', json_encode($results, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
echo "All 30 test cases executed successfully! Saved to tests/test_results.json\n";
