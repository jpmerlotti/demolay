<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model
{
    use HasFactory;

    public $fillable = [
        'title',
        'location',
        'description',
        'date',
    ];

    public function leading(): BelongsTo
    {
        return $this->belongsTo(Leading::class);
    }
}
