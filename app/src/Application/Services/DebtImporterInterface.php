<?php
namespace App\src\Application\Services;

use Illuminate\Http\UploadedFile;

interface DebtImporterInterface
{
    public function import(UploadedFile $file) : array;
}