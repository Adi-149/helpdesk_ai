<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class KnowledgeBase extends Model
{
    protected $table = 'knowledge_base';

    protected $fillable = [
        'category',
        'title',
        'keywords',
        'content',
        'access_level',
        'is_active',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Daftar kategori yang tersedia.
     */
    public const CATEGORIES = [
        'wifi'       => 'WiFi',
        'lokasi'     => 'Lokasi',
        'perangkat'  => 'Perangkat',
        'sop'        => 'SOP',
        'faq'        => 'FAQ',
        'kontak'     => 'Kontak',
        'unit_usaha' => 'Unit Usaha',
        'pendidikan' => 'Pendidikan',
        'server'     => 'Server',
        'jaringan'   => 'Jaringan',
    ];

    /**
     * Daftar access level.
     */
    public const ACCESS_LEVELS = [
        'user'    => 'User',
        'teknisi' => 'Teknisi',
        'admin'   => 'Admin',
    ];

    /**
     * Admin yang membuat data knowledge ini.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Admin yang terakhir mengubah data knowledge ini.
     */
    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Log perubahan data knowledge ini.
     */
    public function logs(): HasMany
    {
        return $this->hasMany(KnowledgeBaseLog::class);
    }

    /**
     * Scope: hanya data aktif.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: filter berdasarkan hak akses role user.
     *
     * - user   → hanya access_level 'user'
     * - support (teknisi) → access_level 'user' dan 'teknisi'
     * - admin  → semua
     */
    public function scopeAccessibleBy(Builder $query, string $role): Builder
    {
        if ($role === 'admin') {
            return $query;
        }

        if ($role === 'support') {
            return $query->whereIn('access_level', ['user', 'teknisi']);
        }

        // role 'user' - hanya akses data dengan level 'user'
        return $query->where('access_level', 'user');
    }

    /**
     * Scope: pencarian berdasarkan kata kunci di title, keywords, dan content.
     */
    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        if (empty($term)) {
            return $query;
        }

        return $query->where(function (Builder $q) use ($term) {
            $q->where('title', 'LIKE', "%{$term}%")
              ->orWhere('keywords', 'LIKE', "%{$term}%")
              ->orWhere('content', 'LIKE', "%{$term}%");
        });
    }
}
