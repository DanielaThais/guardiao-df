<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PrivacyScanner;
use App\Models\GuardiaoDF;

class GuardiaoDFController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function scan(Request $request, PrivacyScanner $scanner)
    {
        $request->validate(['texto' => 'required|string|min:5',]);

        $resultado = $scanner->analisarTexto($request->texto);

        GuardiaoDF::create([
            'texto_original' => $request->texto,
            'texto_mascarado' => $resultado['mascarado'],
            'score_risco' => $resultado['store'],
            'dados_identificados' => json_encode($resultado['achados'])
        ]);

        return back()->with('sucesso', $resultado);
    }
}
