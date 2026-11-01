<?php
require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Services\KnowledgeBaseService;
use Illuminate\Support\Facades\Http;

$cases = [
    [
        'id' => 'C01',
        'category' => 'Hardware POS',
        'pesan' => 'POS terminal does not power on after the power button is pressed.',
        'subject' => 'POS terminal tidak dapat menyala',
        'priority' => 'High',
        'manual' => 68,
        'ai' => 32
    ],
    [
        'id' => 'C02',
        'category' => 'Hardware POS',
        'pesan' => 'POS terminal suddenly shuts down during a sales transaction.',
        'subject' => 'POS terminal mati mendadak saat transaksi',
        'priority' => 'High',
        'manual' => 62,
        'ai' => 29
    ],
    [
        'id' => 'C03',
        'category' => 'Hardware POS',
        'pesan' => 'POS touchscreen is on but does not respond to touch input.',
        'subject' => 'POS touchscreen tidak merespons sentuhan',
        'priority' => 'High',
        'manual' => 71,
        'ai' => 34
    ],
    [
        'id' => 'C04',
        'category' => 'Hardware POS',
        'pesan' => 'POS terminal frequently freezes while cashier is entering transactions.',
        'subject' => 'POS terminal sering freeze saat input transaksi',
        'priority' => 'High',
        'manual' => 65,
        'ai' => 31
    ],
    [
        'id' => 'C05',
        'category' => 'Printer Thermal',
        'pesan' => 'Thermal printer is detected but does not print the receipt.',
        'subject' => 'Printer thermal terdeteksi tetapi tidak mencetak struk',
        'priority' => 'High',
        'manual' => 59,
        'ai' => 28
    ],
    [
        'id' => 'C06',
        'category' => 'Printer Thermal',
        'pesan' => 'Receipt prints blank although thermal paper is installed correctly.',
        'subject' => 'Struk tercetak kosong padahal kertas thermal terpasang benar',
        'priority' => 'High',
        'manual' => 63,
        'ai' => 30
    ],
    [
        'id' => 'C07',
        'category' => 'Printer Thermal',
        'pesan' => 'Thermal printer repeatedly shows paper error although paper is available.',
        'subject' => 'Printer thermal terus muncul paper error padahal kertas ada',
        'priority' => 'High',
        'manual' => 67,
        'ai' => 33
    ],
    [
        'id' => 'C08',
        'category' => 'Printer Thermal',
        'pesan' => 'Receipt printing stops in the middle and the printer becomes unresponsive.',
        'subject' => 'Cetak struk terhenti di tengah dan printer tidak merespons',
        'priority' => 'High',
        'manual' => 70,
        'ai' => 35
    ],
    [
        'id' => 'C09',
        'category' => 'Barcode Scanner',
        'pesan' => 'Barcode scanner is connected but does not read any barcode.',
        'subject' => 'Barcode scanner terhubung tetapi tidak membaca barcode',
        'priority' => 'High',
        'manual' => 64,
        'ai' => 30
    ],
    [
        'id' => 'C10',
        'category' => 'Barcode Scanner',
        'pesan' => 'Barcode scanner reads some products but repeatedly fails on valid barcodes.',
        'subject' => 'Barcode scanner membaca sebagian produk tetapi gagal pada barcode valid',
        'priority' => 'High',
        'manual' => 61,
        'ai' => 28
    ],
    [
        'id' => 'C11',
        'category' => 'Barcode Scanner',
        'pesan' => 'Barcode scanner produces incorrect characters in the POS input field.',
        'subject' => 'Barcode scanner menghasilkan karakter salah pada input POS',
        'priority' => 'High',
        'manual' => 66,
        'ai' => 31
    ],
    [
        'id' => 'C12',
        'category' => 'Barcode Scanner',
        'pesan' => 'Barcode scanner is not detected by the POS terminal after reconnection.',
        'subject' => 'Barcode scanner tidak terdeteksi POS setelah dipasang ulang',
        'priority' => 'High',
        'manual' => 69,
        'ai' => 33
    ],
    [
        'id' => 'C13',
        'category' => 'Jaringan & Internet',
        'pesan' => 'POS computer is connected to Wi-Fi/LAN but cannot access the internet.',
        'subject' => 'Komputer POS terhubung LAN/Wi-Fi tetapi tidak bisa akses internet',
        'priority' => 'High',
        'manual' => 72,
        'ai' => 34
    ],
    [
        'id' => 'C14',
        'category' => 'Jaringan & Internet',
        'pesan' => 'Internet connection is very slow and disrupts online POS synchronization.',
        'subject' => 'Koneksi internet lambat mengganggu sinkronisasi POS online',
        'priority' => 'High',
        'manual' => 60,
        'ai' => 29
    ],
    [
        'id' => 'C15',
        'category' => 'Jaringan & Internet',
        'pesan' => 'One business unit cannot connect to the internal network while other units are normal.',
        'subject' => 'Satu unit bisnis tidak bisa terhubung ke jaringan internal',
        'priority' => 'High',
        'manual' => 64,
        'ai' => 31
    ],
    [
        'id' => 'C16',
        'category' => 'Jaringan & Internet',
        'pesan' => 'Network connection disconnects intermittently several times during operation.',
        'subject' => 'Koneksi jaringan terputus-putus berulang kali saat operasional',
        'priority' => 'High',
        'manual' => 67,
        'ai' => 32
    ],
    [
        'id' => 'C17',
        'category' => 'CCTV',
        'pesan' => 'One CCTV camera is offline while other cameras remain accessible.',
        'subject' => 'Satu kamera CCTV offline sementara kamera lain normal',
        'priority' => 'High',
        'manual' => 63,
        'ai' => 30
    ],
    [
        'id' => 'C18',
        'category' => 'CCTV',
        'pesan' => 'CCTV live view is available but recorded footage cannot be played back.',
        'subject' => 'CCTV live view normal tetapi rekaman tidak dapat diputar ulang',
        'priority' => 'High',
        'manual' => 69,
        'ai' => 33
    ],
    [
        'id' => 'C19',
        'category' => 'CCTV',
        'pesan' => 'CCTV image is severely blurred/dark and cannot be used for monitoring.',
        'subject' => 'Tampilan gambar CCTV buram/gelap dan tidak jelas',
        'priority' => 'High',
        'manual' => 66,
        'ai' => 32
    ],
    [
        'id' => 'C20',
        'category' => 'CCTV',
        'pesan' => 'All CCTV cameras at one location become inaccessible from the monitoring system.',
        'subject' => 'Semua kamera CCTV di satu lokasi tidak dapat diakses',
        'priority' => 'High',
        'manual' => 74,
        'ai' => 36
    ],
    [
        'id' => 'C21',
        'category' => 'Software POS',
        'pesan' => 'POS application cannot be opened on the cashier computer.',
        'subject' => 'Aplikasi POS tidak dapat dibuka pada komputer kasir',
        'priority' => 'High',
        'manual' => 62,
        'ai' => 29
    ],
    [
        'id' => 'C22',
        'category' => 'Software POS',
        'pesan' => 'POS application closes unexpectedly when a transaction is saved.',
        'subject' => 'Aplikasi POS tertutup tiba-tiba saat menyimpan transaksi',
        'priority' => 'High',
        'manual' => 68,
        'ai' => 33
    ],
    [
        'id' => 'C23',
        'category' => 'Software POS',
        'pesan' => 'Product or price data in POS does not update after synchronization.',
        'subject' => 'Data produk atau harga di POS tidak terupdate setelah sinkronisasi',
        'priority' => 'High',
        'manual' => 65,
        'ai' => 31
    ],
    [
        'id' => 'C24',
        'category' => 'Software POS',
        'pesan' => 'User can open POS but a specific menu/function produces an application error.',
        'subject' => 'Menu atau fungsi tertentu pada aplikasi POS menghasilkan error',
        'priority' => 'High',
        'manual' => 61,
        'ai' => 29
    ],
    [
        'id' => 'C25',
        'category' => 'Software POS',
        'pesan' => 'POS application runs slowly although the computer and network appear normal.',
        'subject' => 'Aplikasi POS berjalan lambat meski komputer dan jaringan normal',
        'priority' => 'Medium',
        'manual' => 70,
        'ai' => 34
    ],
    [
        'id' => 'C26',
        'category' => 'Server & Database',
        'pesan' => 'POS application cannot retrieve data because the database connection fails.',
        'subject' => 'Aplikasi POS gagal ambil data karena koneksi database terputus',
        'priority' => 'High',
        'manual' => 73,
        'ai' => 35
    ],
    [
        'id' => 'C27',
        'category' => 'Server & Database',
        'pesan' => 'Several users cannot access the helpdesk/POS server at the same time.',
        'subject' => 'Beberapa user tidak dapat mengakses server POS secara bersamaan',
        'priority' => 'High',
        'manual' => 68,
        'ai' => 33
    ],
    [
        'id' => 'C28',
        'category' => 'Server & Database',
        'pesan' => 'New transaction data cannot be saved to the database.',
        'subject' => 'Data transaksi baru tidak dapat disimpan ke database',
        'priority' => 'High',
        'manual' => 66,
        'ai' => 32
    ],
    [
        'id' => 'C29',
        'category' => 'Server & Database',
        'pesan' => 'Database query/report takes unusually long to load but eventually succeeds.',
        'subject' => 'Query atau laporan database membutuhkan waktu sangat lama untuk dimuat',
        'priority' => 'Medium',
        'manual' => 71,
        'ai' => 35
    ],
    [
        'id' => 'C30',
        'category' => 'Server & Database',
        'pesan' => 'Scheduled database backup fails while normal application access remains available.',
        'subject' => 'Backup database otomatis gagal meski akses sistem tetap normal',
        'priority' => 'High',
        'manual' => 65,
        'ai' => 31
    ]
];

$apiKey = env('OPENROUTER_API_KEY');
$model = env('OPENROUTER_MODEL', 'gpt-4o-mini');
$kbService = app(KnowledgeBaseService::class);

$finalResults = [];

foreach ($cases as $c) {
    echo "Running " . $c['id'] . "... ";
    // Search KB in Indonesian
    $kbResults = $kbService->searchForChatbot($c['subject'] . ' ' . $c['category'], 'user');
    $kbContext = $kbService->buildContextForAI($kbResults);

    $systemPrompt = "Anda adalah asisten AI khusus IT Helpdesk yang cerdas dan profesional di lingkungan Yayasan Pondok Pesantren Sunan Drajat. "
        . "Tugas UTAMA Anda adalah membantu pengguna dengan masalah TEKNOLOGI (komputer kasir POS, printer thermal, scanner barcode, jaringan, CCTV, database server). "
        . "Jawablah selalu dalam BAHASA INDONESIA yang jelas, ringkas, padat, dan langsung ke langkah solusi (to-the-point). Jangan bertele-tele. "
        . "PENTING: Jangan gunakan format Markdown apa pun (jangan gunakan simbol seperti ***, ###, **, atau ---). Jawab dengan teks biasa (plain text) saja."
        . " Di akhir respon, jika belum teratasi, sarankan untuk membuat tiket bantuan atau hubungi teknisi di \"089688267122\".";

    if (!empty($kbContext)) {
        $systemPrompt .= "\n\n" . $kbContext;
    }

    $response = Http::withHeaders([
        'Authorization' => 'Bearer ' . $apiKey,
        'Content-Type' => 'application/json',
    ])->withoutVerifying()->post('https://openrouter.ai/api/v1/chat/completions', [
        'model' => $model,
        'messages' => [
            ['role' => 'system', 'content' => $systemPrompt],
            ['role' => 'user', 'content' => "Kendala: " . $c['pesan'] . " (" . $c['subject'] . ")"]
        ],
        'temperature' => 0.4,
        'max_tokens' => 250,
    ]);

    $botReply = trim($response->json()['choices'][0]['message']['content'] ?? '');
    // Clean any accidental markdown
    $botReply = str_replace(['**', '###', '##', '*'], '', $botReply);

    $c['pesan_balasan'] = $botReply;
    $finalResults[] = $c;
    echo "OK\n";
    usleep(200000);
}

file_put_contents(__DIR__ . '/final_test_results.json', json_encode($finalResults, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
echo "Done saving final_test_results.json\n";
