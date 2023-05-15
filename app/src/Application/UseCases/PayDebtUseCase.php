<?php

namespace App\src\Application\UseCases;

use App\src\Application\dtos\PaymentDTO;
use App\src\Application\Repositories\DebtRepositoryInterface;
use App\src\Domain\Enums\DebtStatus;
use Illuminate\Support\Facades\Log;
use Nette\Utils\DateTime;

class PayDebtUseCase
{
    private $debtRepository;

    public function __construct(
        DebtRepositoryInterface $debtRepository
    ) {
        $this->debtRepository = $debtRepository;
    }

    public function execute(PaymentDTO $paymentDTO) 
    {
      try {
        $debt = $this->debtRepository->getById($paymentDTO->getDebtId());

        // TODO: se não achar retornar falando que não existe

        $debt->setPaidAt(new DateTime($paymentDTO->getPaidAt()));
        $debt->setPaidAmount($paymentDTO->getPaidAmount());
        $debt->setPaidBy($paymentDTO->getPaidBy());
        $debt->setStatus(DebtStatus::PAID);

        $this->debtRepository->update($debt);
      } catch (\Exception $e) {
        Log::error('Payment failed: ' . $e->getMessage());
      }
    }
}