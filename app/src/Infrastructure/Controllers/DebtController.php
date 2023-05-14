<?php

namespace App\src\Infrastructure\Controllers;

use App\src\Application\UseCases\ImportDebtListUseCase;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class DebtController extends Controller
{
    public function importCsv(Request $request, ImportDebtListUseCase $importDebtListUseCase)
    {
        if($request){
            $request->validate([
                'file' => 'required|mimes:csv,txt'
            ]);
        }
        
        $file = $request->file('file');
        $debts = $importDebtListUseCase->execute($file);

        return response()->json(['message' => 'Debt list imported successfully']);
    }

    public function sendEmail()
    {

        return response()->json(['message' => 'Email sent to Debtors successfully']);
    }
}


