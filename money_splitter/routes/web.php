<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SplitterController;
<<<<<<< HEAD

Route::delete('/delete_personal_income/{pk}', [SplitterController::class, 'deletePersonalIncome'])->name('delete_personal_income');
Route::delete('/delete_personal_expense/{pk}', [SplitterController::class, 'deletePersonalExpense'])->name('delete_personal_expense');
=======

// ----------------- Home Page -----------------
Route::get('/', [SplitterController::class, 'index'])->name('index');

// ----------------- Authentication -----------------
Route::get('/signup', [SplitterController::class, 'signup'])->name('signup');
Route::post('/signup', [SplitterController::class, 'register']); // POST for form submission

Route::get('/login', [SplitterController::class, 'login'])->name('login');
Route::post('/login', [SplitterController::class, 'authenticate'])->name('login.authenticate');

Route::post('/logout', [SplitterController::class, 'logout'])->name('logout');

// ----------------- Room Management -----------------
Route::get('/create_room', [SplitterController::class, 'addRoom'])->name('add_room');
Route::post('/create_room', [SplitterController::class, 'storeRoom']);
// ----------------- Members -----------------
Route::get('/members_list/{pk}', [SplitterController::class, 'listMembers'])->name('list_members');
Route::post('/add_members/{pk}/add/{id}', [SplitterController::class, 'addMember'])->name('add_member');

// ----------------- Transactions -----------------
Route::get('/{pk}/update_transaction/{id}', [SplitterController::class, 'updateTransactionForm'])->name('update_transaction');
Route::put('/{pk}/update_transaction/{id}', [SplitterController::class, 'updateTransaction']);

Route::get('/transaction_details/{pk}', [SplitterController::class, 'transactionDetails'])->name('transaction_details');
Route::get('/personal_budget', [SplitterController::class, 'personalBudget'])->name('personal_budget');

Route::get('/my_debts', [SplitterController::class, 'myDebts'])->name('my_debts');
Route::delete('/settle_debt/{pk}', [SplitterController::class, 'deleteDebt'])->name('delete_debt');
Route::get('/final_settlements', [SplitterController::class, 'finalSettlements'])->name('final_settlements');
Route::get('/transaction_history', [SplitterController::class, 'transactionHistory'])->name('transaction_history');

Route::get('/transaction_details/{pk}', [SplitterController::class, 'transactionDetails'])->name('transaction_details');

>>>>>>> 48687ee3cb2fc713c1daf47d621d07886a456caf
