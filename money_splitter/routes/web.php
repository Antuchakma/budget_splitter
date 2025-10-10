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
Route::get('/rooms_list', [SplitterController::class, 'roomList'])->name('room_list');
Route::get('/rooms_detail/{pk}', [SplitterController::class, 'roomDetails'])->name('room_detail');