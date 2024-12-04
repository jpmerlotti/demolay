<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vault extends Model
{
    use HasFactory;

    protected $fillable = [
        'chapter_id',
    ];

    public function getBalance(): string
    {
        $entrys = $this->getEntrys()->get('amount_cents');
        $expenses = $this->getExpenses()->get('amount_cents');
        $balance = 0;
        foreach ($entrys as $entry) {
            $balance += $entry['amount_cents'];
        }
        foreach ($expenses as $expense) {
            $balance -= $expense['amount_cents'];
        }

        return number_format($balance / 100, '2', ',', '.');
    }

    public function getEntrys()
    {
        return $this->transactions()->where('type', 'entry');
    }

    public function getExpenses()
    {
        return $this->transactions()->where('type', 'expense');
    }

    public function chapter(): BelongsTo
    {
        return $this->belongsTo(Chapter::class, 'id', 'chapter_id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
