<?php

namespace App\src\Infrastructure\Services;
use App\src\Application\Services\EmailServiceInterface;
use App\src\Domain\Entities\Invoice;

class EmailService implements EmailServiceInterface
{
  public function send(string $email, Invoice $invoice)
  {
    // enviar email...
  }
}