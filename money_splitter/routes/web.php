<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SplitterController;

Route::delete('/delete_personal_income/{pk}', [SplitterController::class, 'deletePersonalIncome'])->name('delete_personal_income');
Route::delete('/delete_personal_expense/{pk}', [SplitterController::class, 'deletePersonalExpense'])->name('delete_personal_expense');
