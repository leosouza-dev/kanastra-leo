<?php

namespace App\Domain\Debt\Services;

use App\Domain\Debt\Entities\Debt;
use App\Domain\Debt\Services\DebtImporterInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Nette\Utils\DateTime;
class CsvDebtImporter implements DebtImporterInterface
{
    public function import(UploadedFile $file): array
    {
        $csvData = array_map('str_getcsv', file($file));

        $header = array_shift($csvData);
        $data = [];

        foreach ($csvData as $row) {
            $data[] = array_combine($header, $row);
        }

        try {
            foreach ($data as $row) {
                $dataTeste = DateTime::createFromFormat('Y-m-d', $row['debtDueDate']);
                Log::info("Data teste: ", [$dataTeste]);
                $debt = new Debt(
                    $row['name'],
                    $row['governmentId'],
                    $row['email'],
                    intval($row['debtId']),
                    floatval($row['debtAmount']),
                    DateTime::createFromFormat('Y-m-d', $row['debtDueDate'])
                );
                Log::info("Classe criada: ", [$debt]);
                $debts[] = $debt;
            }
        } catch (\Exception $e) {
            Log::error('Debt import failed: ' . $e->getMessage());
        }

        return $debts;
    }
}