<?php

use Illuminate\Support\Facades\Route;
use App\src\Infrastructure\Controllers\DebtController;

Route::post('/debts/import', [DebtController::class, 'importCsv']);
Route::post('/debts/sendEmail', [DebtController::class, 'sendEmail']);
Route::post('/debts/debtPaid', [DebtController::class, 'debtPaid']);