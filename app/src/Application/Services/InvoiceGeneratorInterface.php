<?php
namespace App\src\Application\Services;
use App\src\Domain\Entities\Invoice;
use App\src\Domain\Entities\Debt;

interface InvoiceGeneratorInterface
{
    public function generate(Debt $debt) : Invoice;
}