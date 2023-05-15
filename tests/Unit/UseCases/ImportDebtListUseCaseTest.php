<?php

use App\src\Domain\Entities\Debt;
use PHPUnit\Framework\TestCase;
use App\src\Application\UseCases\ImportDebtListUseCase;
use App\src\Application\Repositories\DebtRepositoryInterface;
use App\src\Application\Services\DebtImporterInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Nette\Utils\DateTime;

class ImportDebtListUseCaseTest extends TestCase
{
  public function testExecute()
  {
    $debtImporterMock = $this->createMock(DebtImporterInterface::class);
    $debtRepositoryMock = $this->createMock(DebtRepositoryInterface::class);
    $debtDueDate = DateTime::from('2023-05-15');
    $filePath = UploadedFile::fake()->create('debts.csv');
    $debts = [
      new Debt(
        'João',
        '123456789',
        'joao@example.com',
        1,
        100.0,
        $debtDueDate
      ),
      new Debt(
        'Maria',
        '987654321',
        'maria@example.com',
        2,
        200.0,
        $debtDueDate
      ),
    ];

    $debtImporterMock->expects($this->once())
      ->method('import')
      ->with($filePath)
      ->willReturn($debts);

    Log::shouldReceive('info')
      ->once()
      ->with('Debt import succeeded aqui: ', [$debts]);

    $useCase = new ImportDebtListUseCase($debtImporterMock, $debtRepositoryMock);
    $useCase->execute($filePath);
  }
}