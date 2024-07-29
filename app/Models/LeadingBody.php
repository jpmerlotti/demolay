<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeadingBody extends Model
{
    use HasFactory;

    protected $fillable = [
        'leading_id',
        'demolay_id',
        'role'
    ];

    public function leading(): BelongsTo
    {
        return $this->belongsTo(Leading::class);
    }
}
