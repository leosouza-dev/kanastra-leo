<?php

use PHPUnit\Framework\TestCase;
use App\src\Domain\Entities\Invoice;
use Nette\Utils\DateTime;

class InvoiceTest extends TestCase
{
    public function testGetters()
    {
        $name = 'John Doe';
        $governmentId = '123456789';
        $email = 'john.doe@example.com';
        $debtId = 1;
        $debtAmount = 100.50;
        $debtDueDate = new DateTime('2023-05-15');

        $invoice = new Invoice($name, $governmentId, $email, $debtId, $debtAmount, $debtDueDate);

        $this->assertEquals($name, $invoice->getName());
        $this->assertEquals($governmentId, $invoice->getGovernmentId());
        $this->assertEquals($email, $invoice->getEmail());
        $this->assertEquals($debtId, $invoice->getDebtId());
        $this->assertEquals($debtAmount, $invoice->getDebtAmount());
        $this->assertEquals($debtDueDate, $invoice->getDebtDueDate());
    }

    public function testSetBarCode()
    {
        $invoice = new Invoice('John Doe', '123456789', 'john.doe@example.com', 1, 100.50, new DateTime('2023-05-15'));
        $barcode = '1234567890';

        $invoice->setBarCode($barcode);

        $this->assertEquals($barcode, $invoice->getBarCode());
    }

    public function testToString()
    {
        $name = 'John Doe';
        $barcode = '1234567890';
        $governmentId = '123456789';
        $email = 'john.doe@example.com';
        $debtId = 1;
        $debtAmount = 100.50;
        $debtDueDate = new DateTime('2023-05-15');

        $invoice = new Invoice($name, $governmentId, $email, $debtId, $debtAmount, $debtDueDate);
        $invoice->setBarCode($barcode);

        $expectedJson = json_encode([
            'name' => $name,
            'barCode' => $barcode,
            'governmentId' => $governmentId,
            'email' => $email,
            'debtId' => $debtId,
            'debtAmount' => $debtAmount,
            'debtDueDate' => $debtDueDate->format('Y-m-d H:i:s'),
        ], JSON_PRETTY_PRINT);

        $this->assertEquals($expectedJson, $invoice->__toString());
    }
}
