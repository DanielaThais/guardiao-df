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
        $caminho = null;
        $conteudo = '';

        if ($request->hasFile('documento')) {
            $caminho = $request->file('documento')->store('documentos', 'public');
            $conteudo = $this->extrairTextoDoArquivo($request->file('documento'));
        } else {
            $conteudo = $request->texto;
        }

        $conteudo = preg_replace('/\s+/', ' ', $conteudo);
        $conteudo = $this->extrairTextoDoArquivo($request->file('documento'));
        $conteudo = str_replace(["\r", "\n", "\t"], ' ', $conteudo);
        $conteudo = preg_replace('/\s+/', ' ', $conteudo);

        $resultado = $scanner->analisarTexto($conteudo);

        $analise = Analise::create([
            'user_id' => Auth::id(),
            'nome_arquivo' => $request->hasFile('documento') ? $request->file('documento')->getClientOriginalName() : 'Texto Manual',
            'caminho_arquivo' => $caminho,
            'conteudo_original' => $conteudo,
            'conteudo_mascarado' => $resultado['mascarado'],
            'score_risco' => $resultado['score'],
            'dados_identificados' => json_encode($resultado['achados']),
        ]);

        return redirect()->route('relatorios')->with('download_id', $analise->id);
    }

    // private function extrairTextoDoArquivo($arquivo)
    // {
    //     $extensao = $arquivo->getClientOriginalExtension();
    //     $caminho = $arquivo->getRealPath();


    //     try {
    //         // 1. PDF
    //         if ($extensao === 'pdf') {
    //             try {
    //                 $parser = new PdfParser();
    //                 $pdf = $parser->parseFile($caminho);

    //                 $texto = $pdf->getText();

    //                 $texto = str_replace("\x00", "", $texto);

    //                 return mb_convert_encoding($texto, 'UTF-8', 'UTF-8');
    //             } catch (\Exception $e) {
    //                 Log::error("Erro PDF: " . $e->getMessage());
    //                 return "";
    //             }
    //         }

    //         // 2. Word (DOCX) 
    //         if ($extensao === 'docx') {
    //             $phpWord = WordIOFactory::load($caminho);
    //             $textoCompleto = '';

    //             foreach ($phpWord->getSections() as $section) {
    //                 $elements = $section->getElements();
    //                 foreach ($elements as $element) {
    //                     $textoCompleto .= $this->processarElementoWord($element);
    //                 }
    //             }
    //             return $textoCompleto;
    //         }

    //         // 3. Excel/CSV
    //         if (in_array($extensao, ['xlsx', 'csv'])) {
    //             return (new FastExcel)->import($caminho)->map(function ($linha) {
    //                 return implode(' ', $linha);
    //             })->implode(PHP_EOL);
    //         }

    //         // 4. TXT
    //         if ($extensao === 'txt') {
    //             return file_get_contents($caminho);
    //         }

    //         return null;
    //     } catch (\Exception $e) {
    //         Log::error("Erro no Guardião-DF ao ler arquivo: " . $e->getMessage());
    //         return null;
    //     }
    // }


    private function extrairTextoDoArquivo($arquivo)
    {
        $extensao = $arquivo->getClientOriginalExtension();
        $caminho = $arquivo->getRealPath();

        try {
            // 1. PDF 
            if ($extensao === 'pdf') {
                $parser = new \Smalot\PdfParser\Parser();
                $pdf = $parser->parseFile($caminho);
                $texto = $pdf->getText();

                return mb_convert_encoding($texto, 'UTF-8', 'UTF-8');
            }

            // 2. Word (DOCX) 
            if ($extensao === 'docx') {
                $phpWord = \PhpOffice\PhpWord\IOFactory::load($caminho);
                $textoCompleto = '';

                foreach ($phpWord->getSections() as $section) {
                    foreach ($section->getElements() as $element) {
                        $textoCompleto .= $this->obterTextoRecursivo($element) . " ";
                    }
                }
                return $textoCompleto;
            }

            // 3. Excel/CSV 
            if (in_array($extensao, ['xlsx', 'csv'])) {
                return (new \Rap2hpoutre\FastExcel\FastExcel)->import($caminho)->map(function ($linha) {
                    return implode(' ', $linha);
                })->implode(PHP_EOL);
            }

            return file_get_contents($caminho);
        } catch (\Exception $e) {
            \Log::error("Erro no Guardião-DF: " . $e->getMessage());
            return "";
        }
    }

    public function gerarPdf($id)
    {
        $analise = Analise::findOrFail($id);

        $pdf = Pdf::loadView('relatorio_pdf', compact('analise'));

        return $pdf->download("Relatorio_LGPD_{$analise->id}.pdf");
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

    private function obterTextoRecursivo($element)
{
    $texto = '';

    if (method_exists($element, 'getText')) {
        $texto .= $element->getText() . " ";
    } 
    elseif (method_exists($element, 'getElements')) {
        foreach ($element->getElements() as $childElement) {
            $texto .= $this->obterTextoRecursivo($childElement);
        }
    }
    elseif ($element instanceof \PhpOffice\PhpWord\Element\Table) {
        foreach ($element->getRows() as $row) {
            foreach ($row->getCells() as $cell) {
                foreach ($cell->getElements() as $cellElement) {
                    $texto .= $this->obterTextoRecursivo($cellElement);
                }
            }
        }
    }

    return $texto;
}
}


