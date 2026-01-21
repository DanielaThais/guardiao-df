<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PrivacyScanner;
use App\Models\GuardiaoDF;
use App\Models\User; 
use Illuminate\Support\Facades\Log; 
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Hash; 
use Illuminate\Support\Facades\Storage; 
use Illuminate\Support\Facades\Validator; 
use Rap2hpoutre\FastExcel\FastExcel;
use Smalot\PdfParser\Parser as PdfParser;
use PhpOffice\PhpWord\IOFactory as WordIOFactory;

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
        $validator = \Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Hash::make($request->password),
        ]);

        \Auth::login($user);

        return response()->json([
            'success' => true,
            'message' => 'Cadastro realizado com sucesso!',
            'redirect' => route('index')
        ]);
    }

    public function scan(Request $request, PrivacyScanner $scanner)
    {
        $request->validate([
            'texto' => 'nullable|string|min:5',
            'documento' => 'nullable|file|mimes:pdf,docx,xlsx,csv,txt|max:10240', // 10MB
        ]);

        $conteudoParaAnalise = "";
        $nomeArquivoOriginal = "Texto Manual";
        $caminhoNoStorage = null;

        if ($request->hasFile('documento')) {
            $arquivo = $request->file('documento');
            $nomeArquivoOriginal = $arquivo->getClientOriginalName();
            $caminhoNoStorage = $arquivo->store('analises');

            // Extração de texto aprimorada
            $conteudoParaAnalise = $this->extrairTextoDoArquivo($arquivo);
        } else {
            $conteudoParaAnalise = $request->texto;
        }

        if (empty($conteudoParaAnalise)) {
            return back()->withErrors(['erro' => 'O conteúdo enviado está vazio ou não pôde ser lido.']);
        }

        $resultado = $scanner->analisarTexto($conteudoParaAnalise);

        // Foco em Auditoria e LGPD
        GuardiaoDF::create([
            'user_id'             => Auth::id() ?? null,
            'nome_arquivo'        => $nomeArquivoOriginal,
            'caminho_storage'     => $caminhoNoStorage,
            'texto_original'      => $conteudoParaAnalise,
            'texto_mascarado'     => $resultado['mascarado'],
            'score_risco'         => $resultado['score'],
            'dados_identificados' => json_encode($resultado['achados']),
            'data_analise'        => now(),
        ]);

        return back()->with('sucesso', [
            'original'  => $conteudoParaAnalise,
            'mascarado' => $resultado['mascarado'],
            'score'     => $resultado['score'],
            'achados'   => $resultado['achados'],
            'arquivo'   => $nomeArquivoOriginal
        ]);
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
}
