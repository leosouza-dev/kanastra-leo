<?php

namespace App\Presentation\Controllers;

use App\Domain\Debt\UseCases\ImportDebtListUseCase;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;


class DebtController extends Controller
{
    public function importCsv(Request $request, ImportDebtListUseCase $importDebtListUseCase)
    {
        Log::info('Debt import succeeded: ');

        if($request){
            $request->validate([
                'file' => 'required|mimes:csv,txt'
            ]);
        }

        Log::info('LEO: ');
        
        $file = $request->file('file');
        $debts = $importDebtListUseCase->execute($file);

        return response()->json(['message' => 'Debt list imported successfully']);
    }
}


