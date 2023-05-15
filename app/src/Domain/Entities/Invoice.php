<?php

namespace App\src\Domain\Entities;

use Nette\Utils\DateTime;

class Invoice
{
  private string $id;
  private string $barcode;
  private string $name;
  private string $governmentId;
  private string $email;
  private int $debtId;
  private float $debtAmount;
  private DateTime $debtDueDate;

  public function __construct(
      string $name,
      string $governmentId,
      string $email,
      int $debtId,
      float $debtAmount,
      DateTime $debtDueDate,
  ) {
      $this->name = $name;
      $this->governmentId = $governmentId;
      $this->email = $email;
      $this->debtId = $debtId;
      $this->debtAmount = $debtAmount;
      $this->debtDueDate = $debtDueDate;
    }
  
    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getGovernmentId(): string
    {
        return $this->governmentId;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getDebtId(): int
    {
        return $this->debtId;
    }

    public function getDebtAmount(): float
    {
        return $this->debtAmount;
    }

    public function getDebtDueDate(): DateTime
    {
        return $this->debtDueDate;
    }

    public function getBarCode(): string
    {
        return $this->barcode;
    }

    public function setBarCode(string $barcode)
    {
        $this->barcode = $barcode;
    }

    public function __toString(): string
    {
        $props = [
            'name' => $this->name,
            'barCode' => $this->barcode,
            'governmentId' => $this->governmentId,
            'email' => $this->email,
            'debtId' => $this->debtId,
            'debtAmount' => $this->debtAmount,
            'debtDueDate' => $this->debtDueDate->format('Y-m-d H:i:s'),
        ];

        return json_encode($props, JSON_PRETTY_PRINT);
    }
}

