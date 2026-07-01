<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Recording extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'file_path',
        'file_type',
        'language',
        'status',
        'duration',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transcript(): HasOne
    {
        return $this->hasOne(Transcript::class);
    }

    public function summary(): HasOne
    {
        return $this->hasOne(Summary::class);
    }
}
