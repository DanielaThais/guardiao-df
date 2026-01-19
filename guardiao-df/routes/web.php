<?php

use App\Http\Controllers\GuardiaoDFController;
use Illuminate\Support\Facades\Route;

Route::get('/', [GuardiaoDFController::class, 'index']);
Route::post('/scan', [GuardiaoDFController::class, 'scan'])->name('scan');
