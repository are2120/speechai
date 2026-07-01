<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transcript extends Model
{
    protected $fillable = [
        'recording_id',
        'content',
        'segments',
        'keywords',
        'sentiment',
        'language',
    ];

    protected function casts(): array
    {
        return [
            'segments' => 'array',
            'keywords' => 'array',
        ];
    }

    public function recording(): BelongsTo
    {
        return $this->belongsTo(Recording::class);
    }
}
