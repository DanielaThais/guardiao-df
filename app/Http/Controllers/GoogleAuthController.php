<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            $user = User::updateOrCreate([
                'email' => $googleUser->email,
            ], [
                'name' => $googleUser->name,
                'google_id' => $googleUser->id,
                'password' => bcrypt(str()->random(16)), 
            ]);

            Auth::login($user);
            
            request()->session()->regenerate();

            return redirect()->route('index');

        } catch (Exception $e) {
            return redirect()->route('login')->with('erro', 'Erro ao logar com Google: ' . $e->getMessage());
        }
    }
}