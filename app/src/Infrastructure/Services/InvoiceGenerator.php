<?php

namespace App\src\Infrastructure\Services;

use App\src\Application\Services\InvoiceGeneratorInterface;
use App\src\Domain\Entities\Debt;
use App\src\Domain\Entities\Invoice;
use Illuminate\Support\Facades\Log;

class InvoiceGenerator implements InvoiceGeneratorInterface
{
  public function generate(Debt $debt): Invoice
  {
    try {
      $invoice = new Invoice(
        $debt->getName(),
        $debt->getGovernmentId(),
        $debt->getEmail(),
        $debt->getDebtId(),
        $debt->getDebtAmount(),
        $debt->getDebtDueDate()
      );

      $barcode = $this->generateBarCode($debt);
      $invoice->setBarCode($barcode);

      return $invoice;
    } catch (\Exception $e) {
      Log::error('Error generating invoice: ' . $e->getMessage());
      throw $e;
    }
  }

  private function generateBarCode(Debt $debt): string
  {
    try {
      $barCode = $debt->getDebtId() .
        $debt->getDebtAmount() .
        $debt->getDebtDueDate()->format('Ymd');

      return $barCode;
    } catch (\Exception $e) {
      Log::error('Error generating barcode: ' . $e->getMessage());
      throw $e;
    }
  }
}