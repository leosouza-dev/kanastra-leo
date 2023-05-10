<?php

namespace App\Domain\Debt\UseCases;

// use App\Domain\Debt\Repositories\DebtRepositoryInterface;
use App\Domain\Debt\Services\DebtImporterInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

class ImportDebtListUseCase
{
    private $debtImporter;
    // private $debtRepository;

    public function __construct(
        DebtImporterInterface $debtImporter,
        // DebtRepositoryInterface $debtRepository
    ) {
        $this->debtImporter = $debtImporter;
        // $this->debtRepository = $debtRepository;
    }

    public function execute(UploadedFile $filePath): array
    {
        $debts = [];
        try {
            $debts = $this->debtImporter->import($filePath);
            // foreach ($debts as $debt) {
            //     $this->debtRepository->save($debt);
            // }
            
            Log::info('Debt import succeeded aqui: ', [$debts]);
            return $debts;
        } catch (\Exception $e) {
            Log::error('Debt import failed: ' . $e->getMessage());
        }
        return $debts;
    }
}
