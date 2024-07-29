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
        'vault_id',
        'type',
        'amount_cents',
        'description',
    ];
}
