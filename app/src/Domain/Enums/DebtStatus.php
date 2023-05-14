<?php

namespace App\src\Domain\Enums;

enum DebtStatus: string
{
    case OPEN = 'open';
    case PAID = 'paid';
    case OVERDUE = 'overdue';
}
