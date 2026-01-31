<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Guardião DF</title>
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
                @auth
                <span class="text-sm">Olá, {{ Auth::user()->name }}</span>
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
        <div class="text-center mb-12">
            <h2 class="text-3xl font-extrabold text-gray-900 mb-4">Proteção de Dados e Transparência</h2>
            <p class="text-gray-600 max-w-2xl mx-auto italic mb-6">
                "Segurança para quem informa, privacidade para quem é citado."
            </p>
            <p class="text-gray-600 max-w-2xl mx-auto">
                O <strong>Guardião DF</strong> é uma plataforma inteligente projetada para apoiar os órgãos do Distrito Federal na gestão de documentos públicos. Através de modelos de Inteligência, o sistema identifica automaticamente dados sensíveis (como CPFs, endereços e contatos pessoais) em textos de processos e ouvidorias, sugerindo o mascaramento necessário para garantir a conformidade com a <strong>LGPD</strong>.
            </p>
        </div>

        @auth
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">

            <a href="{{ route('analise') }}" class="block bg-white p-8 rounded-2xl shadow-sm border border-gray-200 hover:shadow-md transition group">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mb-6 group-hover:bg-[#1351B4] transition">
                    <span class="text-2xl group-hover:scale-110 transition">🔍</span>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Scanner de Privacidade</h3>
                <p class="text-gray-500 mb-6">
                    Analise textos de processos e e-SIC em busca de CPFs, telefones e endereços expostos.
                </p>
                <div class="inline-flex items-center text-[#1351B4] font-bold">
                    Acessar Ferramenta <span class="ml-2">→</span>
                </div>
            </a>

            <a href="{{ route('relatorios') }}" class="block bg-white p-8 rounded-2xl shadow-sm border border-gray-200 hover:shadow-md transition group">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mb-6 group-hover:bg-[#168821] transition">
                    <span class="text-2xl group-hover:scale-110 transition">📋</span>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Relatórios e Auditoria</h3>
                <p class="text-gray-500 mb-6">
                    Acompanhe o histórico de análises e gere relatórios de conformidade para auditoria.
                </p>
                <div class="inline-flex items-center text-[#1351B4] font-bold">
                    Ver Relatórios <span class="ml-2">→</span>
                </div>
            </a>
        </div>
        @else
        <div class="max-w-2xl mx-auto bg-blue-50 border border-blue-100 p-6 rounded-xl text-center">
            <p class="text-[#1351B4] font-medium">
                Para acessar o Scanner de Privacidade e as ferramentas de auditoria, por favor realize o login com sua conta institucional ou Gov.br.
            </p>
            <div class="mt-4">
                <a href="{{ route('login') }}" class="inline-block bg-[#1351B4] text-white px-6 py-2 rounded-lg font-bold hover:bg-blue-800 transition">
                    Entrar Agora
                </a>
            </div>
        </div>
        @endauth

        <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-4 text-center">
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