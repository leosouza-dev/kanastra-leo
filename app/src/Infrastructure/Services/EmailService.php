<?php

namespace App\src\Infrastructure\Services;
use App\src\Application\Services\EmailServiceInterface;
use App\src\Domain\Entities\Invoice;
use Illuminate\Support\Facades\Log;

class EmailService implements EmailServiceInterface
{
  public function send(Invoice $invoice)
  {
    Log::info('Sending email:', [$invoice->__toString()]);
  }
}