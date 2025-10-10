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
// ----------------- Members -----------------
Route::get('/members_list/{pk}', [SplitterController::class, 'listMembers'])->name('list_members');
Route::post('/add_members/{pk}/add/{id}', [SplitterController::class, 'addMember'])->name('add_member');