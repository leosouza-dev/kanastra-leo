<?php

namespace App\Domain\Debt\Enums;

// enum DebtStatus
// {
//     public const OPEN = 'open';
//     public const PAID = 'paid';
//     public const OVERDUE = 'overdue';
// }

enum DebtStatus: string
{
    case OPEN = 'open';
    case PAID = 'paid';
    case OVERDUE = 'overdue';
}
