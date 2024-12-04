<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'vault_id',
        'type',
        'amount_cents',
        'description',
    ];

    public function vault(): BelongsTo
    {
        return $this->belongsTo(Vault::class, 'id', 'vault_id');
    }
}
