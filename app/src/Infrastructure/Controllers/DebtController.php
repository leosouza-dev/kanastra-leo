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
        if ($request) {
            $request->validate([
                'file' => 'required|mimes:csv,txt'
            ]);
        }

        try {
            $file = $request->file('file');
            $importDebtListUseCase->execute($file);
            return response()->json(['message' => 'Debt list imported successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error importing debt list'], 500);
        }
    }

    public function sendEmail(SendEmailToDebtorsUseCase $sendEmailToDebtorsUseCase)
    {
        try {
            $sendEmailToDebtorsUseCase->execute();
            return response()->json(['message' => 'Email sent to Debtors successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to send email to Debtors'], 500);
        }
    }

    public function debtPaid(Request $request, PayDebtUseCase $payDebtUseCase)
    {
        if ($request) {
            $request->validate([
                'debtId' => 'required',
                'paidAt' => 'required',
                'paidAmount' => 'required',
                'paidBy' => 'required'
            ]);
        }

        try {
            $body = $request->all();

            $paymentDTO = new PaymentDTO(
                $body['debtId'],
                $body['paidAt'],
                $body['paidAmount'],
                $body['paidBy']
            );

            $payDebtUseCase->execute($paymentDTO);
            return response()->json(['message' => 'Payment processed successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to process payment'], 500);
        }
    }
}