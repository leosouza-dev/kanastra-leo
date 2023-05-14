<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\src\Infrastructure\Controllers\DebtController;

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/debts/import', [DebtController::class, 'importCsv']);

Route::get('/debts/sendEmail', [DebtController::class, 'sendEmail']);

// Route::get('/debts/teste', [DebtController::class, 'teste']);