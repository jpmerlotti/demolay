<?php

namespace App\Enums;

enum TransactionTypesEnum: string
{
    case Entry = 'entry';
    case Expense = 'expense';

    public function label(): string
    {
        return match ($this) {
            self::Entry => 'Entrada',
            self::Expense => 'Saída',
        };
    }

    public static function toArray(): array
    {
        $states = [];
        foreach (self::cases() as $state) {
            $states[$state->value] = $state->label();
        }
        return $states;
    }
}
