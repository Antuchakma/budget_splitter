<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SplitterController;


Route::post('/add_personal_budget', [SplitterController::class, 'addPersonalBudget'])->name('add_personal_budget');


