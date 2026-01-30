<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PrivacyScanner;
use App\Models\GuardiaoDF;
use App\Models\User;
use App\Models\Analise;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Rap2hpoutre\FastExcel\FastExcel;
use Smalot\PdfParser\Parser as PdfParser;
use PhpOffice\PhpWord\IOFactory as WordIOFactory;
use Barryvdh\DomPDF\Facade\Pdf;

class GuardiaoDFController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function analise()
    {
        return view('analise');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'password.min' => 'A senha precisa de no mínimo 8 caracteres.',
            'password.confirmed' => 'As senhas não coincidem.',
            'email.unique' => 'Este e-mail já está cadastrado.'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('login')->with('sucesso', 'Conta criada com sucesso!');
    }

    public function scan(Request $request, PrivacyScanner $scanner)
    {
        $request->validate([
            'texto' => 'nullable|string|min:5',
            'documento' => 'nullable|file|mimes:pdf,docx,xlsx,csv,txt|max:10240',
        ]);

        $conteudoParaAnalise = $request->hasFile('documento')
            ? $this->extrairTextoDoArquivo($request->file('documento'))
            : $request->texto;

        if (empty($conteudoParaAnalise)) {
            return back()->withErrors(['erro' => 'O conteúdo não pôde ser lido.']);
        }

        $resultado = $scanner->analisarTexto($conteudoParaAnalise);

        GuardiaoDF::create([
            'user_id' => Auth::id(),
            'nome_arquivo' => $request->file('documento') ? $request->file('documento')->getClientOriginalName() : "Texto Manual",
            'texto_original' => $conteudoParaAnalise,
            'texto_mascarado' => $resultado['mascarado'], // Salva apenas o conteúdo seguro
            'score_risco' => $resultado['score'],
            'dados_identificados' => json_encode($resultado['achados']),
        ]);

        return redirect()->route('relatorios')->with('sucesso', 'Análise concluída com sucesso!');
    }

    private function extrairTextoDoArquivo($arquivo)
    {
        $extensao = $arquivo->getClientOriginalExtension();
        $caminho = $arquivo->getRealPath();

        try {
            // 1. PDF
            if ($extensao === 'pdf') {
                $parser = new PdfParser();
                return $parser->parseFile($caminho)->getText();
            }

            // 2. Word (DOCX) 
            if ($extensao === 'docx') {
                $phpWord = WordIOFactory::load($caminho);
                $textoCompleto = '';

                foreach ($phpWord->getSections() as $section) {
                    $elements = $section->getElements();
                    foreach ($elements as $element) {
                        $textoCompleto .= $this->processarElementoWord($element);
                    }
                }
                return $textoCompleto;
            }

            // 3. Excel/CSV
            if (in_array($extensao, ['xlsx', 'csv'])) {
                return (new FastExcel)->import($caminho)->map(function ($linha) {
                    return implode(' ', $linha);
                })->implode(PHP_EOL);
            }

            // 4. TXT
            if ($extensao === 'txt') {
                return file_get_contents($caminho);
            }

            return null;
        } catch (\Exception $e) {
            Log::error("Erro no Guardião-DF ao ler arquivo: " . $e->getMessage());
            return null;
        }
    }

    private function processarElementoWord($element)
    {
        $texto = '';

        if (method_exists($element, 'getText')) {
            $texto .= $element->getText() . " ";
        } elseif (method_exists($element, 'getRows')) {
            foreach ($element->getRows() as $row) {
                foreach ($row->getCells() as $cell) {
                    foreach ($cell->getElements() as $cellElement) {
                        $texto .= $this->processarElementoWord($cellElement);
                    }
                }
            }
        }
        return $texto;
    }

    public function historico()
    {
        $relatorios = Analise::where('user_id', Auth::id())->latest()->get();
        return view('relatorios', compact('relatorios'));
    }
}
