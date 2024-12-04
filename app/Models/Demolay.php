<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Demolay extends Model
{
    use HasFactory;

    protected $table = 'demolays';

    protected $fillable = [
        'name',
        'password',
        'phone',
        'sisdm',
        'birthdate',
        'is_active',
        'user_id',
        'chapter_id',
    ];

    public static function findByName(string $name): ?Demolay
    {
        return Demolay::where('name', 'like', $name)->first();
    }

    public function getAge(): int
    {
        return floor(now()->diffInYears($this->birthdate) * -1);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function chapter(): BelongsTo
    {
        return $this->belongsTo(Chapter::class);
    }
}
