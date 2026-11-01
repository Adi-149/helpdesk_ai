<?php
require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$apiKey = env('OPENROUTER_API_KEY');
$model = env('OPENROUTER_MODEL', 'gpt-4o-mini');

echo "API Key: " . substr($apiKey, 0, 15) . "...\n";
echo "Model: " . $model . "\n";

$response = Illuminate\Support\Facades\Http::withHeaders([
    'Authorization' => 'Bearer ' . $apiKey,
    'Content-Type' => 'application/json',
])->withoutVerifying()->post('https://openrouter.ai/api/v1/chat/completions', [
    'model' => $model,
    'messages' => [
        ['role' => 'user', 'content' => 'Halo, ini tes koneksi IT Helpdesk.']
    ],
    'max_tokens' => 50,
]);

echo "Status: " . $response->status() . "\n";
echo "Body: " . $response->body() . "\n";
