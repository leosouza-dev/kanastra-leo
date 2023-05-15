<?php

namespace App\src\Application\Dtos;

class PaymentDTO {
  private string $debtId;
  private string $paidAt;
  private float $paidAmount;
  private string $paidBy;

  public function __construct(string $debtId, string $paidAt, float $paidAmount, string $paidBy) {
      $this->debtId = $debtId;
      $this->paidAt = $paidAt;
      $this->paidAmount = $paidAmount;
      $this->paidBy = $paidBy;
  }

  public function getDebtId(): string {
      return $this->debtId;
  }

  public function getPaidAt(): string {
      return $this->paidAt;
  }

  public function getPaidAmount(): float {
      return $this->paidAmount;
  }

  public function getPaidBy(): string {
      return $this->paidBy;
  }
}
