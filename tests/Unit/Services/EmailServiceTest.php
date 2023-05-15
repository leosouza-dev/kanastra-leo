<?php

use App\src\Domain\Entities\Invoice;
use App\src\Infrastructure\Services\EmailService;
use Illuminate\Support\Facades\Log;
use PHPUnit\Framework\TestCase;
use Nette\Utils\DateTime;

class EmailServiceTest extends TestCase
{
    public function testSend()
    {
        $logMessages = [];
        Log::shouldReceive('info')->andReturnUsing(function ($message, $context) use (&$logMessages) {
            $logMessages[] = [$message, $context];
        });

        $service = new EmailService();
        $invoice = new Invoice(
            'John Doe',
            '123456789',
            'john@example.com',
            1,
            100.0,
            new DateTime('2023-05-15')
        );
        $invoice->setBarCode('111');


        $service->send($invoice);

        $this->assertCount(1, $logMessages);
        $this->assertEquals('Sending email:', $logMessages[0][0]);
    }
}
