
<?php

use App\src\Domain\Entities\Debt;
use App\src\Domain\Entities\Invoice;
use App\src\Infrastructure\Services\InvoiceGenerator;
use Illuminate\Support\Facades\Log;
use PHPUnit\Framework\TestCase;
use Nette\Utils\DateTime;

class InvoiceGeneratorTest extends TestCase
{
    public function testGenerate()
    {
        $logMessages = [];
        Log::shouldReceive('error')->andReturnUsing(function ($message, $context) use (&$logMessages) {
            $logMessages[] = [$message, $context];
        });

        $generator = new InvoiceGenerator();
        $debt = new Debt(
            'John Doe',
            '123456789',
            'john@example.com',
            1,
            100.0,
            new DateTime('2023-05-15')
        );

        $invoice = $generator->generate($debt);

        $this->assertInstanceOf(Invoice::class, $invoice);
        $this->assertEquals('John Doe', $invoice->getName());
        $this->assertEquals('123456789', $invoice->getGovernmentId());
        $this->assertEquals('john@example.com', $invoice->getEmail());
        $this->assertEquals(1, $invoice->getDebtId());
        $this->assertEquals(100.0, $invoice->getDebtAmount());
        $this->assertEquals('2023-05-15', $invoice->getDebtDueDate()->format('Y-m-d'));  
        $this->assertEquals('110020230515', $invoice->getBarCode());
        $this->assertEmpty($logMessages);
    }
}
