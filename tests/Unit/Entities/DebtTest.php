<?php

use PHPUnit\Framework\TestCase;
use App\src\Domain\Entities\Debt;
use App\src\Domain\Enums\DebtStatus;
use Nette\Utils\DateTime;

class DebtTest extends TestCase
{
    public function testGettersAndSetters()
    {
        $debt = new Debt('John Doe', '123456789', 'john@example.com', 1, 100.0, new DateTime('2023-01-01'));

        $this->assertEquals('John Doe', $debt->getName());
        $this->assertEquals('123456789', $debt->getGovernmentId());
        $this->assertEquals('john@example.com', $debt->getEmail());
        $this->assertEquals(1, $debt->getDebtId());
        $this->assertEquals(100.0, $debt->getDebtAmount());
        $this->assertEquals(new DateTime('2023-01-01'), $debt->getDebtDueDate());

        $debt->setPaidAt(new DateTime('2023-01-02'));
        $debt->setPaidAmount(50.0);
        $debt->setPaidBy('John Smith');
        $debt->setStatus(DebtStatus::PAID);

        $this->assertEquals(new DateTime('2023-01-02'), $debt->getPaidAt());
        $this->assertEquals(50.0, $debt->getPaidAmount());
        $this->assertEquals('John Smith', $debt->getPaidBy());
        $this->assertEquals(DebtStatus::PAID, $debt->getStatus());
    }
}
