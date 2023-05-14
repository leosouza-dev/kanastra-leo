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

    public function generateBarCode(): string
    {
        $barCodeData = $this->name .
            $this->governmentId .
            $this->email .
            $this->debtId .
            $this->debtAmount .
            $this->debtDueDate->format('Ymd');
  
        $checksum = $this->calculateChecksum($barCodeData);
        $this->barcode = $barCodeData . $checksum;
  
        return $this->barcode;
    }
  
    private function calculateChecksum(string $data): string
    {
        $checksum = 0;
        foreach (str_split($data) as $char) {
            $checksum += ord($char);
        }
        return str_pad($checksum % 10, 1, '0', STR_PAD_LEFT);
    }
}

