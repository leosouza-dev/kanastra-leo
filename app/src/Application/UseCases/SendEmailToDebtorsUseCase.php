<?php

namespace App\src\Application\UseCases;
use App\src\Application\Repositories\DebtRepositoryInterface;
use App\src\Application\Services\EmailServiceInterface;
use App\src\Domain\Entities\Invoice;
use Illuminate\Support\Facades\Log;

class SendEmailToDebtorsUseCase
{
  private $emailService;
  private $debtRepository;

  public function __construct(
      EmailServiceInterface $emailService,
      DebtRepositoryInterface $debtRepository
  ) {
      $this->emailService = $emailService;
      $this->debtRepository = $debtRepository;
  }

  public function execute() 
  {
    try {
      $debtors = $this->debtRepository->findDebtsWithUnpaidStatus();
      foreach ($debtors as $debtor) {
        // TODO: pensar em ter um service de geração de boleto - pode ser uma lib externa e a entidade não precisa saber a implementação 
        $invoice = new Invoice(
          $debtor->getName(),
          $debtor->getGovernmentId(),
          $debtor->getEmail(),
          $debtor->getDebtId(),
          $debtor->getDebtAmount(),
          $debtor->getDebtDueDate()
        );

        $invoice->generateBarCode();
        $this->emailService->send($invoice);
      }
    } catch (\Exception $e) {
      Log::error('Email sending failed: ' . $e->getMessage());
    }
  }
}