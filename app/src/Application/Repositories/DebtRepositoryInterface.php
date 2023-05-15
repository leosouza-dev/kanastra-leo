<?php

namespace App\src\Application\Repositories;

use App\src\Domain\Entities\Debt;
use Illuminate\Support\Collection;

interface DebtRepositoryInterface
{
    public function createDebt(Debt $debt): Debt;
    public function findDebtsWithUnpaidStatus(): Collection;
    public function getById(string $id) : Debt;
    public function update(Debt $debt) : Debt;
}
