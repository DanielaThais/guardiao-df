<?php

use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\GovAuthController;
use App\Http\Controllers\GuardiaoDFController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

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

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');


Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended(route('index'));
    }

    return back()->withErrors([
        'email' => 'E-mail ou senha incorretos.',
    ]);
})->name('login.post');

Route::get('/auth/google/redirect', function () {
    return Socialite::driver('google')->redirect();
})->name('auth.google.redirect');

Route::get('/auth/google/callback', function () {
    try {
        $googleUser = Socialite::driver('google')->user();

        $user = User::updateOrCreate(
            ['email' => $googleUser->email],
            [
                'name' => $googleUser->name,
                'google_id' => $googleUser->id,
                'password' => bcrypt(Str::random(16)),
            ]
        );

        Auth::login($user);
        return redirect()->route('index');
    } catch (\Exception $e) {
        return redirect('/login')->with('erro', 'Falha no login: ' . $e->getMessage());
    }
});

Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])->name('auth.google.redirect');

Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback']);


Route::get('/auth/gov/redirect', [GovAuthController::class, 'redirect'])->name('auth.gov.redirect');
Route::get('/auth/gov/callback', [GovAuthController::class, 'callback'])->name('auth.gov.callback');

Route::post('/scan', [GuardiaoDFController::class, 'scan'])->name('scan');

Route::get('/relatorios', [GuardiaoDFController::class, 'historico'])
    ->name('relatorios')
    ->middleware('auth');