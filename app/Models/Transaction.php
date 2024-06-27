<?php

namespace App\Models;

use App\Enums\TransactionTypesEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'amount_cents',
        'description',
    ];

    public static function getBalance(): string
    {
        // dd(Transaction::query()->where('type', 'entry')->get('amount_cents'));
        $entrys = Transaction::where('type', 'entry')->get('amount_cents');
        $expenses = Transaction::where('type', 'expense')->get('amount_cents');
        $balance = 0;
        foreach($entrys as $entry) {
            $balance += $entry['amount_cents'];
        }
        foreach($expenses as $expense) {
            $balance -= $expense['amount_cents'];
        }
        return number_format(($balance/100), 2, ',', ' ');
    }
}
