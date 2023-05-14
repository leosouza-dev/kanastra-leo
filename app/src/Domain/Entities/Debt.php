<?php

namespace App\src\Domain\Entities;

use App\src\Domain\Enums\DebtStatus;
use Nette\Utils\DateTime;

class Debt
{
    private string $id;
    private string $name;
    private string $governmentId;
    private string $email;
    private int $debtId;
    private float $debtAmount;
    private DateTime $debtDueDate;
    private ?DateTime $paidAt;
    private ?float $paidAmount;
    private ?string $paidBy;
    private DebtStatus $status;

    public function __construct(
        string $name,
        string $governmentId,
        string $email,
        int $debtId,
        float $debtAmount,
        DateTime $debtDueDate,
        ?DateTime $paidAt = null,
        ?float $paidAmount = null,
        ?string $paidBy = null,
        ?DebtStatus $status = null
    ) {
        $this->name = $name;
        $this->governmentId = $governmentId;
        $this->email = $email;
        $this->debtId = $debtId;
        $this->debtAmount = $debtAmount;
        $this->debtDueDate = $debtDueDate;
        $this->paidAt = $paidAt;
        $this->paidAmount = $paidAmount;
        $this->paidBy = $paidBy;
        $this->status = $status ?? DebtStatus::OPEN;
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

    public function getPaidAt(): ?DateTime
    {
        return $this->paidAt;
    }

    public function getPaidAmount(): ?float
    {
        return $this->paidAmount;
    }

    public function getPaidBy(): ?string
    {
        return $this->paidBy;
    }

    public function getStatus(): DebtStatus
    {
        return $this->status;
    }

    
    public function __toString(): string
    {
        $props = [
            'name' => $this->name,
            'governmentId' => $this->governmentId,
            'email' => $this->email,
            'debtId' => $this->debtId,
            'debtAmount' => $this->debtAmount,
            'debtDueDate' => $this->debtDueDate->format('Y-m-d H:i:s'),
            'paidAt' => $this->paidAt ? $this->paidAt->format('Y-m-d H:i:s') : null,
            'paidAmount' => $this->paidAmount,
            'paidBy' => $this->paidBy,
            'status' => $this->status,
        ];

        return json_encode($props, JSON_PRETTY_PRINT);
    }
}
