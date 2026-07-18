<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KnowledgeBaseLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'knowledge_base_id',
        'user_id',
        'action',
        'old_data',
        'new_data',
        'created_at',
    ];

    protected $casts = [
        'old_data'   => 'array',
        'new_data'   => 'array',
        'created_at' => 'datetime',
    ];

    /**
     * Knowledge base yang terkait.
     */
    public function knowledgeBase(): BelongsTo
    {
        return $this->belongsTo(KnowledgeBase::class);
    }

    /**
     * Admin yang melakukan perubahan.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
