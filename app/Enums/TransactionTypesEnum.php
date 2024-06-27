<?php

namespace App\Enums;

enum TransactionTypesEnum: string
{
    case Entrada = 'entry';
    case Saída = 'expense';
}
