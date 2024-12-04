<?php

namespace App\Services\V1;

use App\Models\Transaction;
use App\Models\Vault;
use App\Services\Service;

class TransactionService extends Service
{
    public function create(Vault $vault, array $data): Transaction
    {
        return $vault->transactions()->create($data);
    }

    public function update(Transaction $transaction, array $data): bool
    {
        return $transaction->update($data);
    }

    public function delete(Transaction $transaction): bool
    {
        return $transaction->deleteOrFail();
    }
}
