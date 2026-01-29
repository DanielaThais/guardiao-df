<?php

use App\Http\Controllers\GuardiaoDFController;
use Illuminate\Support\Facades\Route;

Route::get('/', [GuardiaoDFController::class, 'index'])->name('index');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/cadastro', function () {
    return view('cadastro');
})->name('cadastro');

Route::post('/cadastro', [GuardiaoDFController::class, 'store'])->name('cadastro.store');

Route::get('/analise', function () {
    return view('analise');
})->name('analise');

//temporário
Route::get('/debug-banco', function () {
    return [
        'usuarios' => \App\Models\User::all(),
        // 'analises' => \App\Models\GuardiaoDF::all(),
    ];
});

Route::post('/scan', [GuardiaoDFController::class, 'scan'])->name('scan');
