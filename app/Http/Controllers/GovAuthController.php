<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GovAuthController extends Controller
{
    public function redirect()
    {
        return redirect()->route('auth.gov.callback');
    }

    public function callback()
    {
        $user = User::firstOrCreate(
            ['email' => 'cidadao@gov.br'],
            [
                'name' => 'Cidadão Exemplo (Gov.br)',
                'password' => bcrypt(Str::random(16)),
            ]
        );

        Auth::login($user);

        session(['gov_nivel' => 'prata']);

        return view('processing'); 
    }
}