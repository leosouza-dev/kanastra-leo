<?php

namespace App\src\Infrastructure\Controllers;

use App\src\Application\Dtos\PaymentDTO;
use App\src\Application\UseCases\ImportDebtListUseCase;
use App\src\Application\UseCases\PayDebtUseCase;
use App\src\Application\UseCases\SendEmailToDebtorsUseCase;
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

    public function sendEmail(SendEmailToDebtorsUseCase $sendEmailToDebtorsUseCase)
    {
        $sendEmailToDebtorsUseCase->execute();
        return response()->json(['message' => 'Email sent to Debtors successfully']);
    }

    public function debtPaid(Request $request, PayDebtUseCase $payDebtUseCase)
    {
        $validatedData = $request->validate([
            'debtId' => 'required',
            'paidAt' => 'required',
            'paidAmount' => 'required',
            'paidBy' => 'required'
        ]);

        $body = $request->all();

        $paymentDTO = new PaymentDTO(
            $body['debtId'],
            $body['paidAt'],
            $body['paidAmount'],
            $body['paidBy']
        );

        $payDebtUseCase->execute($paymentDTO);
        return response()->json(['message' => 'payment....... successfully']);
    }
}


