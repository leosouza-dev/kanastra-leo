<?php

namespace App\src\Infrastructure\Repositories;

use App\src\Application\Repositories\DebtRepositoryInterface;
use App\src\Domain\Entities\Debt;
use App\src\Domain\Enums\DebtStatus;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Nette\Utils\DateTime;

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

  public function findDebtsWithUnpaidStatus(): Collection
  {
    $debtsWithUnpaidStatus = [];
      try {
          $query = DB::table('debts')
              ->where('status', '!=', DebtStatus::PAID);
          $results = $query->get();
  
          $debtsWithUnpaidStatus = collect($results)->map(function ($row) {
              return new Debt(
                  $row->name,
                  $row->government_id,
                  $row->email,
                  $row->debt_id,
                  $row->debt_amount,
                  new DateTime($row->debt_due_date),
                  $row->paid_at ? new DateTime($row->paid_at) : null,
                  $row->paid_amount,
                  $row->paid_by,
                  $row->status
              );
          });
      } catch (\Exception $e) {
          Log::error('Error while query to the database: ' . $e->getMessage());
      }
      return $debtsWithUnpaidStatus;
  }
}

