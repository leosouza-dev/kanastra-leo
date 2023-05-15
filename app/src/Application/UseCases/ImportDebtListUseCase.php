<?php

namespace App\src\Application\UseCases;

use App\src\Application\Repositories\DebtRepositoryInterface;
use App\src\Application\Services\DebtImporterInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

class ImportDebtListUseCase
{
    private $debtImporter;
    private $debtRepository;

    public function __construct(
        DebtImporterInterface $debtImporter,
        DebtRepositoryInterface $debtRepository
    ) {
        $this->debtImporter = $debtImporter;
        $this->debtRepository = $debtRepository;
    }

    public function execute(UploadedFile $filePath): array
    {
        try {
            $debts = $this->debtImporter->import($filePath);
            foreach ($debts as $debt) {
                $this->debtRepository->createDebt($debt);
            }
            Log::info('Debt import succeeded aqui: ', [$debts]);
        } catch (\Exception $e) {
            Log::error('Debt import failed: ' . $e->getMessage());
            throw $e;
        }
        return $debts;
    }
}
