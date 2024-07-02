<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Ramsey\Uuid\Uuid;

class Demolay extends Model
{
    use HasFactory;

    protected $table = 'demolays';

    protected $fillable = [
        'name',
        'phone',
        'sisdm',
        'birthdate',
        'is_active',
        'user_id',
    ];

    public function getAge(): int
    {
        return floor(now()->diffInYears($this->birthdate) * -1);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
