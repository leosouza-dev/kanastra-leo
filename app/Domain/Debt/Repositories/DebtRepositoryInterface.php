<?php

namespace App\Domain\Debt\Repositories;

use App\Domain\Debt\Entities\Debt;

interface DebtRepositoryInterface
{
    public function createDebt(Debt $debt): Debt;
}
