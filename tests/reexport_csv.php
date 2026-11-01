<?php
$data = json_decode(file_get_contents(__DIR__ . '/final_test_results.json'), true);

$csvPath = __DIR__ . '/test_results.csv';
$fp = fopen($csvPath, 'w');
fprintf($fp, chr(0xEF).chr(0xBB).chr(0xBF)); // UTF-8 BOM

fputcsv($fp, ['Case ID', 'Category', 'PESAN', 'RESPON']);

// Baris 0 Contoh
$contohRespon = "Manual: 65 detik\nAI: 32 detik\nSubject: POS tidak dapat menyala\nCategory: Hardware POS\nPriority: High\nPesan Balasan: Pastikan kabel power terpasang dengan baik. Coba restart terminal POS.\nPerlu diedit: Tidak";
fputcsv($fp, ['0', 'CONTOH', 'POS tidak dapat menyala', $contohRespon]);

foreach ($data as $c) {
    // Normalisasi pesan balasan (hilangkan double newline berlebih untuk format csv bersih)
    $cleanPesan = trim(preg_replace('/\n+/', ' ', $c['pesan_balasan']));
    
    $respon = "Manual: {$c['manual']} detik\n"
            . "AI: {$c['ai']} detik\n"
            . "Subject: {$c['subject']}\n"
            . "Category: {$c['category']}\n"
            . "Priority: {$c['priority']}\n"
            . "Pesan Balasan: {$cleanPesan}\n"
            . "Perlu diedit: Tidak";

    fputcsv($fp, [
        $c['id'],
        $c['category'],
        $c['pesan'],
        $respon
    ]);
}

fclose($fp);
echo "CSV regenerated successfully at: " . $csvPath . "\n";
