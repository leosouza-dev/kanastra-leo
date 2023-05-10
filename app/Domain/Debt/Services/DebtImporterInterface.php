<?php
namespace App\Domain\Debt\Services;

use Illuminate\Http\UploadedFile;

interface DebtImporterInterface
{
    public function import(UploadedFile $file) : array;
}