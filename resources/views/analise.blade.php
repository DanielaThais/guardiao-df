<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Análise de Dados - Guardião DF</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 min-h-screen flex flex-col">
    @extends('layouts.app')

    @section('title', 'Login')

    @section('content')
    <nav class="bg-[#044c9c] p-4 text-white shadow-md">
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
                    Voltar ao Início
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
    </nav>

    <main id="conteudo-principal" class="container mx-auto mt-16 p-4 flex-grow justify-center">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center space-x-2 mb-4 text-blue-800">
                <span>🔍</span>
                <h2 class="text-lg font-semibold text-gray-800">Nova Varredura de Conteúdo</h2>
            </div>

            <form action="{{ route('scan') }}" method="POST" enctype="multipart/form-data" id="formScan">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Insira o texto ou conteúdo do e-SIC para identificar dados sensíveis <span class="text-red-500">*</span>:
                    </label>
                    <textarea
                        name="texto"
                        rows="8"
                        class="w-full p-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition"
                        placeholder="Cole aqui o texto do protocolo..."
                        required></textarea>
                </div>

                <div class="bg-blue-50 p-6 rounded-xl border-2 border-dashed border-blue-200">
                    <label class="block text-sm font-bold text-blue-900 mb-2 cursor-pointer">
                        <span class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="25" height="25" viewBox="0 0 48 48">
                                <path fill="#ffa000" d="M40,12H22l-4-4H8c-2.2,0-4,1.8-4,4v24c0,2.2,1.8,4,4,4h29.7L44,29V16C44,13.8,42.2,12,40,12z"></path>
                                <path fill="#ffca28" d="M40,12H8c-2.2,0-4,1.8-4,4v20c0,2.2,1.8,4,4,4h32c2.2,0,4-1.8,4-4V16C44,13.8,42.2,12,40,12z"></path>
                            </svg>
                            Importar Documento (PDF, DOCX, TXT, XLSX ou CSV)
                        </span>
                    </label>

                    <input
                        type="file"
                        name="documento"
                        accept=".pdf,.docx,.xlsx,.csv,.txt"
                        class="block w-full text-sm text-gray-500
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-full file:border-0
                        file:text-sm file:font-semibold
                        file:bg-[#0464ac] file:text-white
                        hover:file:bg-[#0C326F] transition cursor-pointer">

                    <p class="mt-2 text-xs text-bg[#0464ac] italic">
                        * O sistema processará o texto contido no arquivo automaticamente.
                    </p>
                </div>

                <button type="submit" class="bg-[#0464ac] hover:bg-[#0C326F] text-white font-bold py-3 px-8 py-3 mt-3 rounded-lg shadow transition">
                    Iniciar Varredura
                </button>
            </form>

            @if(session('sucesso'))
            @endif
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
</body>

</html>