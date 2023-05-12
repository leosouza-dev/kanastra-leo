<?php

namespace App\Domain\Debt\Enums;

enum DebtStatus: string
{
    case OPEN = 'open';
    case PAID = 'paid';
    case OVERDUE = 'overdue';
}
