<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Relatórios - Guardião DF</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ asset('js/guardiao-scripts.js') }}"></script>
</head>

<body class="bg-gray-50 min-h-screen flex flex-col">
    @extends('layouts.app')

    @section('title', 'Meus Relatórios')

    @section('content')
    <nav class="bg-[#1351B4] p-4 text-white shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold tracking-tight">GUARDIÃO DF - Painel</h1>
            <a href="{{ route('index') }}"
                class="inline-flex items-center justify-center text-sm bg-[#2670E8] hover:bg-[#1351B4] px-4 h-9 rounded transition font-medium text-white">
                Nova Análise
            </a>
        </div>
    </nav>

    <main id="conteudo-principal" class="container mx-auto mt-16 p-4 flex-grow justify-center">
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-2xl font-bold text-gray-800">Histórico de Análises LGPD</h2>
                <p class="text-sm text-gray-500">Abaixo estão os documentos processados com dados sensíveis protegidos.</p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse" role="table" aria-label="Tabela de relatórios processados">
                    <thead class="bg-gray-50 uppercase text-xs font-bold text-gray-600">
                        <tr>
                            <th class="p-4 border-b">Arquivo</th>
                            <th class="p-4 border-b text-center">Risco</th>
                            <th class="p-4 border-b">Dados Protegidos</th>
                            <th class="p-4 border-b">Data</th>
                            <th class="p-4 border-b text-right">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @forelse($relatorios as $relatorio)
                        <tr>
                            <td class="p-4">{{ $relatorio->nome_arquivo }}</td>
                            <td class="p-4">
                                @foreach(json_decode($relatorio->dados_identificados) as $tipo)
                                <span class="bg-blue-100 text-blue-800 text-[10px] px-2 py-0.5 rounded">{{ $tipo }}</span>
                                @endforeach
                            </td>
                            <td class="p-4">{{ $relatorio->created_at->format('d/m/Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center p-8 text-gray-400 italic">
                                Nenhuma análise encontrada no seu histórico.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <footer class="bg-[#50bc7c] text-[#E6F4EA] mt-20 border-t-4 border-[#1351B4]">
        <div class="container mx-auto px-4 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <div>
                    <h4 class="font-bold text-[#E6F4EA] mb-4 border-b border-green-400 pb-2">Participa DF</h4>

                    <ul class="space-y-2 text-sm text-[#E6F4EA]">
                        <li><a href="https://cg.df.gov.br/a-controladoria-geral-do-distrito-federal" class="hover:underline transition">A CGDF</a></li>
                        <li><a href="https://cg.df.gov.br/relatorios-de-auditorias" class="hover:underline transition">Auditorias e Inspeções</a></li>
                        <li><a href="https://cg.df.gov.br/transparencia-e-combate-a-corrupcao" class="hover:underline transition">Transparência e Controle Social</a></li>
                        <li><a href="https://cg.df.gov.br/category/carta-de-servicos" class="hover:underline transition">Serviços</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold text-[#E6F4EA] mb-4 border-b border-green-400 pb-2">Canais de Ajuda</h4>

                    <ul class="space-y-2 text-sm text-blue-100">
                        <li><a href="https://cg.df.gov.br/fale-com-a-secretaria/" class="hover:underline transition">Fale com a Secretaria</a></li>
                        <li><a href="https://cg.df.gov.br/category/acesso-a-informacao/" class="hover:underline transition">Acesso à Informação</a></li>
                        <li><a href="https://www.participa.df.gov.br/" class="hover:underline transition">Ouvidoria</a></li>
                        <li><a href="https://cg.df.gov.br/category/imprensa" class="hover:underline transition">Comunicação</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold text-[#E6F4EA] mb-4 border-b border-green-400 pb-2">Localização</h4>
                    <p class="text-sm text-[#E6F4EA] leading-relaxed">
                        Anexo do Palácio do Buriti, 13º andar<br>
                        CEP: 70075-900 | Brasília - DF
                    </p>
                    <a href="https://cg.df.gov.br/category/acesso-a-informacao/">
                        <div class="mt-6 flex items-center gap-4">
                            <div class="bg-white p-2 rounded-full w-12 h-12 flex items-center justify-center">
                                <span class="text-black font-black text-xl italic">i</span>
                            </div>
                            <span class="text-xs font-bold uppercase tracking-wider">Acesso à<br>Informação</span>
                        </div>
                    </a>
                </div>
            </div>

            <div class="mt-12 pt-8 border-t border-green-800 text-center text-xs text-green-300 uppercase tracking-widest">
                Governo do Distrito Federal - Segurança e Privacidade de Dados
            </div>
        </div>
    </footer>
    @endsection
</body>

</html>