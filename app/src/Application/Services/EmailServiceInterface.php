<?php
namespace App\src\Application\Services;

use App\src\Domain\Entities\Invoice;

interface EmailServiceInterface
{
    public function send(string $email, Invoice $invoice);
}