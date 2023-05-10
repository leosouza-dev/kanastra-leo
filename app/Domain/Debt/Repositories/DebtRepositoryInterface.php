<?php

namespace App\Domain\Debt\Repositories;

use App\Domain\Debt\Entities\Customer;
use App\Domain\Debt\Entities\Debt;
use DateTime;

interface DebtRepositoryInterface
{
    public function createDebt(Customer $customer, float $amount, DateTime $dueDate): Debt;
    public function getById(int $id): ?Debt;
    public function getAll(): array;
    public function updateStatus(Debt $debt): void;
}
