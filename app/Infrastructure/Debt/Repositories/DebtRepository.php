<?php

namespace App\Infrastructure\Debt\Repositories;

use App\Domain\Debt\Entities\Debt;
use App\Domain\Debt\Repositories\DebtRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DebtRepository implements DebtRepositoryInterface
{
  public function createDebt(Debt $debt): Debt
  {
    try {
      $data = [
          'name' => $debt->getName(),
          'government_id' => $debt->getGovernmentId(),
          'email' => $debt->getEmail(),
          'debt_id' => $debt->getDebtId(),
          'debt_amount' => $debt->getDebtAmount(),
          'debt_due_date' => $debt->getDebtDueDate()->format('Y-m-d H:i:s'),
          'paid_at' => $debt->getPaidAt() ? $debt->getPaidAt()->format('Y-m-d H:i:s') : null,
          'paid_amount' => $debt->getPaidAmount(),
          'paid_by' => $debt->getPaidBy(),
          'status' => $debt->getStatus(),
      ];
      DB::table('debts')->insert($data);
    } catch (\Exception $e) {
      Log::error('Error while saving to the database: ' . $e->getMessage());
    }
    return $debt;
  }
}

