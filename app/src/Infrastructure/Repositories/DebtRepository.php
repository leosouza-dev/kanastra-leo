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
  public function createDebt(Debt $debt)
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
      throw $e;
    }
  }

  public function findDebtsWithUnpaidStatus(): Collection
  {
    $debtsWithUnpaidStatus = [];
    try {
      $query = DB::table('debts')
        ->where('status', '!=', DebtStatus::PAID);
      $results = $query->get();


      $debtsWithUnpaidStatus = collect($results)->map(function ($row) {
        $status = match ($row->status) {
          'OPEN' => DebtStatus::OPEN,
          'PAID' => DebtStatus::PAID,
          'OVERDUE' => DebtStatus::OVERDUE,
          default => null,
        };

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
          $status
        );
      });
    } catch (\Exception $e) {
      Log::error('Error while query to the database: ' . $e->getMessage());
    }
    return $debtsWithUnpaidStatus;
  }

  public function getById(string $id): Debt
  {
    try {
      $result = DB::table('debts')
        ->where('debt_id', $id)
        ->first();

      if ($result) {
        $status = match ($result->status) {
          'OPEN' => DebtStatus::OPEN,
          'PAID' => DebtStatus::PAID,
          'OVERDUE' => DebtStatus::OVERDUE,
          default => null,
        };

        return new Debt(
          $result->name,
          $result->government_id,
          $result->email,
          $result->debt_id,
          $result->debt_amount,
          new DateTime($result->debt_due_date),
          $result->paid_at ? new DateTime($result->paid_at) : null,
          $result->paid_amount,
          $result->paid_by,
          $status
        );
      }
    } catch (\Exception $e) {
      Log::error('Error while querying the database: ' . $e->getMessage());
    }

    throw new \Exception('Debt not found');
  }

  public function update(Debt $debt): Debt
  {
    try {
      $data = [
        'name' => $debt->getName(),
        'government_id' => $debt->getGovernmentId(),
        'email' => $debt->getEmail(),
        'debt_amount' => $debt->getDebtAmount(),
        'debt_due_date' => $debt->getDebtDueDate()->format('Y-m-d H:i:s'),
        'paid_at' => $debt->getPaidAt() ? $debt->getPaidAt()->format('Y-m-d H:i:s') : null,
        'paid_amount' => $debt->getPaidAmount(),
        'paid_by' => $debt->getPaidBy(),
        'status' => $debt->getStatus(),
      ];

      DB::table('debts')
        ->where('debt_id', $debt->getDebtId())
        ->update($data);

      return $debt;
    } catch (\Exception $e) {
      Log::error('Error while updating the database: ' . $e->getMessage());
    }

    throw new \Exception('Failed to update debt');
  }
}