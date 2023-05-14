<?php
namespace App\src\Application\Services;

use App\src\Domain\Entities\Invoice;

interface EmailServiceInterface
{
    public function send(Invoice $invoice);
}