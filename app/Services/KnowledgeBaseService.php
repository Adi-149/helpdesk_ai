<?php

namespace App\Services;

use App\Models\KnowledgeBase;
use Illuminate\Support\Collection;

class KnowledgeBaseService
{
    /**
     * Cari data knowledge base yang relevan untuk chatbot.
     *
     * Alur:
     * 1. Pecah query user menjadi kata kunci
     * 2. Cari di title, keywords, content menggunakan LIKE
     * 3. Filter berdasarkan access_level sesuai role user
     * 4. Filter hanya data is_active = true
     * 5. Beri skor berdasarkan jumlah keyword yang cocok
     * 6. Ambil maksimal 3 hasil paling relevan
     */
    public function searchForChatbot(string $query, string $userRole): Collection
    {
        // Bersihkan dan pecah query menjadi kata kunci
        $query = strtolower(trim($query));
        $keywords = $this->extractKeywords($query);

        if (empty($keywords)) {
            return collect();
        }

        // Ambil semua knowledge aktif yang dapat diakses user
        $results = KnowledgeBase::active()
            ->accessibleBy($userRole)
            ->where(function ($q) use ($keywords) {
                foreach ($keywords as $keyword) {
                    $q->orWhere('title', 'LIKE', "%{$keyword}%")
                      ->orWhere('keywords', 'LIKE', "%{$keyword}%")
                      ->orWhere('content', 'LIKE', "%{$keyword}%");
                }
            })
            ->get();

        if ($results->isEmpty()) {
            return collect();
        }

        // Hitung skor relevansi berdasarkan jumlah keyword match
        $scored = $results->map(function ($item) use ($keywords) {
            $score = 0;
            $titleLower = strtolower($item->title);
            $keywordsLower = strtolower($item->keywords);
            $contentLower = strtolower($item->content);

            foreach ($keywords as $keyword) {
                // Title match punya bobot lebih tinggi
                if (str_contains($titleLower, $keyword)) {
                    $score += 3;
                }
                // Keywords match punya bobot sedang
                if (str_contains($keywordsLower, $keyword)) {
                    $score += 2;
                }
                // Content match punya bobot rendah
                if (str_contains($contentLower, $keyword)) {
                    $score += 1;
                }
            }

            $item->relevance_score = $score;
            return $item;
        });

        // Urutkan berdasarkan skor dan ambil top 3
        return $scored->sortByDesc('relevance_score')
            ->take(3)
            ->filter(fn($item) => $item->relevance_score > 0)
            ->values();
    }

    /**
     * Format hasil pencarian menjadi konteks teks untuk dikirim ke AI.
     */
    public function buildContextForAI(Collection $results): string
    {
        if ($results->isEmpty()) {
            return '';
        }

        $context = "=== DATA KNOWLEDGE BASE INTERNAL PONDOK PESANTREN SUNAN DRAJAT ===\n";
        $context .= "Gunakan data berikut sebagai SUMBER UTAMA untuk menjawab pertanyaan pengguna.\n\n";

        foreach ($results as $index => $item) {
            $num = $index + 1;
            $context .= "--- Informasi #{$num} ---\n";
            $context .= "Judul: {$item->title}\n";
            $context .= "Kategori: " . (KnowledgeBase::CATEGORIES[$item->category] ?? $item->category) . "\n";
            $context .= "Isi:\n{$item->content}\n\n";
        }

        $context .= "=== AKHIR DATA KNOWLEDGE BASE ===\n";
        $context .= "INSTRUKSI: Jawab pertanyaan pengguna BERDASARKAN data di atas. ";
        $context .= "Di akhir jawaban, cantumkan sumber dengan format: [Sumber: <judul informasi>]\n";

        return $context;
    }

    /**
     * Ekstrak kata kunci dari query pengguna.
     * Menghapus stop words bahasa Indonesia yang umum.
     */
    private function extractKeywords(string $query): array
    {
        // Stop words bahasa Indonesia
        $stopWords = [
            'apa', 'dan', 'di', 'ke', 'dari', 'yang', 'untuk', 'dengan',
            'ini', 'itu', 'adalah', 'pada', 'atau', 'juga', 'saya', 'ada',
            'tidak', 'bisa', 'akan', 'sudah', 'kalau', 'jika', 'mau', 'nya',
            'saat', 'sini', 'dong', 'ya', 'kok', 'deh', 'lah', 'kan',
            'tolong', 'mohon', 'minta', 'tanya', 'gimana', 'bagaimana',
            'dimana', 'siapa', 'kapan', 'kenapa', 'mengapa', 'berapa',
            'cara', 'apakah', 'the', 'a', 'an', 'is', 'it',
        ];

        // Hapus tanda baca dan pecah menjadi kata
        $cleaned = preg_replace('/[^\p{L}\p{N}\s]/u', ' ', $query);
        $words = preg_split('/\s+/', $cleaned, -1, PREG_SPLIT_NO_EMPTY);

        // Filter stop words dan kata terlalu pendek
        $keywords = array_filter($words, function ($word) use ($stopWords) {
            return strlen($word) >= 2 && !in_array($word, $stopWords);
        });

        return array_values($keywords);
    }
}
