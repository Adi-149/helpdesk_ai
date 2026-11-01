<?php
$json = file_get_contents(__DIR__ . '/test_results.json');
$cases = json_decode($json, true);

$csvPath = __DIR__ . '/test_results.csv';
$fp = fopen($csvPath, 'w');
fprintf($fp, chr(0xEF).chr(0xBB).chr(0xBF)); // UTF-8 BOM

fputcsv($fp, ['Case ID', 'Category', 'PESAN', 'RESPON']);

// Contoh row
$contohRespon = "Manual: 65 detik\nAI: 32 detik\nSubject: POS tidak dapat menyala\nCategory: Hardware POS\nPriority: High\nPesan Balasan: Pastikan kabel power terpasang dengan baik. Coba restart terminal POS.\nPerlu diedit: Tidak";
fputcsv($fp, ['0', 'CONTOH', 'POS tidak dapat menyala', $contohRespon]);

foreach ($cases as $c) {
    $respon = "Manual: {$c['manual_sec']} detik\n"
            . "AI: {$c['ai_sec']} detik\n"
            . "Subject: {$c['subject']}\n"
            . "Category: {$c['detected_category']}\n"
            . "Priority: {$c['priority']}\n"
            . "Pesan Balasan: {$c['pesan_balasan']}\n"
            . "Perlu diedit: {$c['perlu_diedit']}";

    fputcsv($fp, [
        $c['case_id'],
        $c['category'],
        $c['pesan'],
        $respon
    ]);
}

fclose($fp);
echo "CSV created successfully at: " . $csvPath . "\n";
