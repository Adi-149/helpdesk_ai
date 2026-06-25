<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;



class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subject',
        'description',
        'category',
        'priority',
        'status',
        'assigned_to',
        'attachment',
        'ai_summary',
        'ai_causes',
        'ai_recommendations',
        'ai_confidence',
        'resolution_summary',
    ];

public function user()
{
    return $this->belongsTo(User::class);
}

public function assignedSupport()
{
    return $this->belongsTo(User::class, 'assigned_to');
}

public function histories()
{
    return $this->hasMany(TicketHistory::class);
}

public function messages()
{
    return $this->hasMany(TicketMessage::class);
}


}
