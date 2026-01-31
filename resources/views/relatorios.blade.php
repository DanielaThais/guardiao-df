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
    <nav class="bg-[#044c9c] p-4 text-white shadow-md">
        <div class="container mx-auto flex justify-between items-center">

            <div class="container mx-auto flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <img src="https://www.df.gov.br/wp-conteudo/themes/templategdf/img/logogdf_1.svg"
                        alt="Logo GDF"
                        class="h-10 w-auto">

                    <div class="h-8 w-px bg-white/30"></div>
                    <h1 class="text-xl font-bold tracking-tight">
                        <a href="{{ route('index') }}">GUARDIÃO DF</a>
                    </h1>
                </div>


                <div class="flex items-center space-x-4">
                    <div class="flex items-center space-x-4">
                        <button onclick="toggleContraste()" class="text-[10px] font-bold flex items-center gap-1 hover:text-blue-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707" />
                            </svg>
                            ALTO CONTRASTE
                        </button>

                        <div class="flex gap-2">
                            <button onclick="mudarFonte('aumentar')" class="text-xs font-bold px-1 border border-gray-400 hover:bg-gray-200" title="Aumentar fonte">A+</button>
                            <button onclick="mudarFonte('diminuir')" class="text-xs font-bold px-1 border border-gray-400 hover:bg-gray-200" title="Diminuir fonte">A-</button>
                        </div>
                    </div>
                    @auth
                    <span class="text-sm">Olá, {{ Auth::user()->name }}</span>
                    <a href="{{ route('index') }}"
                        class="inline-flex items-center justify-center text-sm bg-[#0464ac] hover:bg-[#1351B4] px-4 h-9 rounded transition font-medium text-white">
                        Nova Análise
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button aria-label type="submit"
                            class="inline-flex items-center justify-center text-sm bg-[#0464ac] hover:bg-[#1351B4] px-4 h-9 rounded transition font-medium text-white">
                            Sair
                        </button>
                    </form>
                    @else
                    <a href="{{ route('login') }}" class="hover:text-blue-200">Entrar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main id="conteudo-principal" class="container mx-auto mt-16 p-4 flex-grow justify-center">
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-2xl font-bold text-gray-800">Histórico de Análises LGPD</h2>
                <p class="text-sm text-gray-500">Abaixo estão os documentos processados com dados sensíveis protegidos.</p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
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
                        <tr class="hover:bg-gray-50 transition border-b border-gray-100">
                            <td class="p-4">{{ $relatorio->nome_arquivo }}</td>
                            <td class="p-4 text-center">
                                <span class="font-bold {{ $relatorio->score_risco > 50 ? 'text-red-600' : 'text-green-600' }}">
                                    {{ $relatorio->score_risco }}%
                                </span>
                            </td>

                            <td class="p-4">
                                <div class="flex flex-wrap gap-1">
                                    @php
                                    $rawDados = $relatorio->dados_identificados;
                                    $dados = is_array($rawDados) ? $rawDados : json_decode($rawDados, true);
                                    @endphp

                                    @if(!empty($dados) && is_array($dados))
                                    @foreach($dados as $item)
                                    <span class="bg-blue-100 text-blue-800 text-[10px] px-2 py-0.5 rounded shadow-sm">
                                        {{ is_array($item) ? implode(', ', $item) : $item }}
                                    </span>
                                    @endforeach
                                    @else
                                    <span class="text-gray-400 text-[10px] italic">Nenhum dado sensível</span>
                                    @endif
                                </div>
                            </td>

                            <td class="p-4 text-sm">{{ $relatorio->created_at->format('d/m/Y') }}</td>
                            <td class="p-4 text-right space-x-2">
                                <a href="{{ route('analise.pdf', $relatorio->id) }}"
                                    class="inline-flex items-center text-blue-600 hover:text-blue-800 font-bold text-xs bg-blue-50 px-2 py-1 rounded">
                                    PDF 📄
                                </a>

                                @if($relatorio->caminho_arquivo)
                                <a href="{{ Storage::url($relatorio->caminho_arquivo) }}" target="_blank"
                                    class="inline-flex items-center text-green-600 hover:text-green-800 font-bold text-xs bg-green-50 px-2 py-1 rounded">
                                    ORIGINAL 📂
                                </a>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center p-8 text-gray-400 italic">
                                Nenhuma análise encontrada no seu histórico.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <footer class="bg-[#50bc7c] text-[#E6F4EA] mt-20 border-t-4 border-[#0464ac]">
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

    @if(session('download_id'))
    <script>
        window.onload = function() {
            window.location.href = "{{ route('analise.pdf', session('download_id')) }}";
        }
    </script>
    @endif
</body>

</html>