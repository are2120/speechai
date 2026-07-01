<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Summary extends Model
{
    protected $fillable = [
        'recording_id',
        'summary',
        'key_points',
        'action_items',
        'meeting_notes',
    ];

    public function recording(): BelongsTo
    {
        return $this->belongsTo(Recording::class);
    }
}
