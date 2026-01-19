<?php

namespace App\Console\Commands;

use App\Models\GuardiaoDF;
use App\Services\PrivacyScanner;
use Illuminate\Console\Command;
use Rap2hpoutre\FastExcel\FastExcel;

class ImportarAmostra extends Command
{
    protected $signature = 'app:importar-amostra {arquivo}';
    protected $description = 'Importa dados do Excel e executa o Scanner de Privacidade';

    public function handle(PrivacyScanner $scanner)
    {
        $caminho = $this->argument('arquivo');

        if (!file_exists($caminho)) {
            $this->error("Arquivo não encontrado no chaminho: $caminho");
            return;
        }

        $this->info("Iniciando processamento profissional...");

        (new FastExcel)->import($caminho, function ($linha) use ($scanner) {
            $textoBruto = $linha['decisao'] ?? $linha['pedido'] ?? $linha['descricao'] ?? '';
            //TODO: Verficar como está na amostra e se é possível deixar mais dinâmico, pois vai que os dados da amostra não são fixos...

            if (empty($textoBruto)) {
                $textoBruto = collect($linha)->first(fn($v) => strlen($v) > 30);
            }

            if (!empty($textoBruto)) {
                $analise = $scanner->analisarTexto($textoBruto);

                GuardiaoDF::create([
                    'texto_original' => $textoBruto,
                    'texto_mascarado' => $analise['mascarado'],
                    'score_risco' => $analise['score'],
                    'dados_identificados' => json_encode($analise['achados']),
                ]);
            }
        });
        $this->info("Importação concluída com sucesso!");
    }
}
