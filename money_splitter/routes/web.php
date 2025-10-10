<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SplitterController;

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
<<<<<<< HEAD
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

=======
Route::get('/rooms_list', [SplitterController::class, 'roomList'])->name('room_list');
Route::get('/rooms_detail/{pk}', [SplitterController::class, 'roomDetails'])->name('room_detail');
>>>>>>> backend/create_room
