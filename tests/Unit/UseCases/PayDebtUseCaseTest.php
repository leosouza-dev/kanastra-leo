<?PHP

use App\src\Application\Dtos\PaymentDTO;
use App\src\Application\UseCases\PayDebtUseCase;
use App\src\Application\Repositories\DebtRepositoryInterface;
use App\src\Domain\Entities\Debt;
use App\src\Domain\Enums\DebtStatus;
use PHPUnit\Framework\TestCase;
use Nette\Utils\DateTime;

class PayDebtUseCaseTest extends TestCase
{
  public function testExecute()
  {
    $debtRepositoryMock = $this->createMock(DebtRepositoryInterface::class);

    $debt = new Debt(
      'João',
      '123456789',
      'joao@example.com',
      1,
      100.0,
      DateTime::from('2023-05-15'),
      DateTime::from('2023-05-10'),
      50.0,
      'John Doe',
      DebtStatus::OPEN
    );

    $debtRepositoryMock->expects($this->once())
      ->method('getById')
      ->willReturn($debt);

    $paymentDTO = new PaymentDTO(
      '1', 
      DateTime::from('2023-05-10'),
      50.0,
      'John Doe',
    );

    $useCase = new PayDebtUseCase($debtRepositoryMock);

    $useCase->execute($paymentDTO);

    $this->assertEquals($paymentDTO->getPaidAt(), $debt->getPaidAt());
    $this->assertEquals($paymentDTO->getPaidAmount(), $debt->getPaidAmount());
    $this->assertEquals($paymentDTO->getPaidBy(), $debt->getPaidBy());
    $this->assertEquals(DebtStatus::PAID, $debt->getStatus());
  }
}