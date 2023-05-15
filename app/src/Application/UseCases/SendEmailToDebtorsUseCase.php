<?php

namespace App\src\Application\UseCases;
use App\src\Application\Repositories\DebtRepositoryInterface;
use App\src\Application\Services\EmailServiceInterface;
use App\src\Application\Services\InvoiceGeneratorInterface;
use Illuminate\Support\Facades\Log;

class SendEmailToDebtorsUseCase
{
  private $emailService;
  private $debtRepository;
  private $invoiceGenerator;

  public function __construct(
      EmailServiceInterface $emailService,
      DebtRepositoryInterface $debtRepository,
      InvoiceGeneratorInterface $invoiceGenerator
  ) {
      $this->emailService = $emailService;
      $this->debtRepository = $debtRepository;
      $this->invoiceGenerator = $invoiceGenerator;
  }

  public function execute() 
  {
    try {
      $debts = $this->debtRepository->findDebtsWithUnpaidStatus();
      foreach ($debts as $debt) {
        $invoice = $this->invoiceGenerator->generate($debt);
        $this->emailService->send($invoice);
      }
    } catch (\Exception $e) {
      Log::error('Email sending failed: ' . $e->getMessage());
      throw $e;
    }
  }
}