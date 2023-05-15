<?php

use App\src\Application\UseCases\SendEmailToDebtorsUseCase;
use App\src\Application\Repositories\DebtRepositoryInterface;
use App\src\Application\Services\EmailServiceInterface;
use App\src\Application\Services\InvoiceGeneratorInterface;
use App\src\Domain\Entities\Debt;
use App\src\Domain\Entities\Invoice;
use App\src\Domain\Enums\DebtStatus;
use PHPUnit\Framework\TestCase;
use Nette\Utils\DateTime;

class SendEmailToDebtorsUseCaseTest extends TestCase
{
  public function testExecute()
  {
    $emailServiceMock = $this->createMock(EmailServiceInterface::class);
    $debtRepositoryMock = $this->createMock(DebtRepositoryInterface::class);
    $invoiceGeneratorMock = $this->createMock(InvoiceGeneratorInterface::class);

    $debts = [
      new Debt(
        'João',
        '123456789',
        'joao@example.com',
        1,
        100.0,
        DateTime::from('2023-05-15'),
        null,
        null,
        null,
        DebtStatus::OPEN
      ),
    ];
    $debtRepositoryMock->expects($this->once())
      ->method('findDebtsWithUnpaidStatus')
      ->willReturn(collect($debts));

    $invoice = new Invoice(
      'John Doe',
      '123456789',
      'john@example.com',
      1,
      100.0,
      DateTime::from('2023-05-15')
    );
    $invoiceGeneratorMock->expects($this->exactly(count($debts)))
      ->method('generate')
      ->willReturn($invoice);

    $useCase = new SendEmailToDebtorsUseCase($emailServiceMock, $debtRepositoryMock, $invoiceGeneratorMock);

    $emailServiceMock->expects($this->exactly(count($debts)))
      ->method('send')
      ->with($invoice);

    $useCase->execute();
  }
}