<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Guardião DF</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ asset('js/guardiao-scripts.js') }}"></script>
</head>

<body class="bg-gray-50 min-h-screen flex flex-col">
    @extends('layouts.app')

    @section('title', 'Login')

    @section('content')
    <nav class="bg-[#044c9c] p-4 text-white shadow-md" role="navigation" aria-label="Menu Principal">
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
        </div>
    </nav>

    <main id="conteudo-principal" class="container mx-auto mt-16 p-4 flex justify-center">

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 w-full max-w-md ">
            <div class="text-center mb-8">
                <h2 class="text-xl font-semibold text-gray-800">Identificação de Usuário</h2>
            </div>

            <div class="space-y-3 mb-6">
                <a href="{{ url('/auth/gov/redirect') }}"
                    onclick="mostrarCarregando(event, 'Gov.br')"
                    class="w-full flex items-center justify-center gap-2 bg-[#1351B4] text-white font-bold py-2.5 px-4 rounded-lg hover:bg-[#0c3d8a] transition"
                    title="Entrar com o portal do governo federal">
                    Entrar com gov.br
                </a>

                <a href="{{ route('auth.google.redirect') }}"
                    id="btn-google"
                    onclick="mostrarCarregando(event, 'Google')"
                    class="w-full flex items-center justify-center gap-2 bg-white border border-gray-300 text-gray-700 font-bold py-2.5 px-4 rounded-lg hover:bg-gray-50 transition"
                    title="Entrar com sua conta Google">
                    <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" class="w-4 h-4" alt="Logo do Google">
                    Entrar com Google
                </a>

                <div id="status-login" class="hidden text-center mt-6" aria-live="polite">
                    <div class="inline-block animate-spin rounded-full h-5 w-5 border-t-2 border-b-2 border-[#1351B4] mb-2"></div>
                    <p id="mensagem-dinamica" class="text-[#1351B4] font-bold text-sm italic"></p>
                </div>
            </div>

            <div class="relative flex py-5 items-center">
                <div class="flex-grow border-t border-gray-200"></div>
                <span class="flex-shrink mx-4 text-gray-400 text-xs uppercase">ou entre com seu e-mail</span>
                <div class="flex-grow border-t border-gray-200"></div>
            </div>

            <form action="{{ route('login.post') }}" method="POST" onsubmit="return typeof validarSenha === 'function' ? validarSenha(event) : true">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">E-mail</label>
                        <input id="email" type="email" name="email" required
                            class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition"
                            placeholder="nome@exemplo.com">
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Senha</label>
                        <input id="password" type="password" name="password" required
                            class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition">
                    </div>
                </div>

                <button type="submit" class="w-full mt-6 bg-[#1351B4] hover:bg-blue-800 text-white font-bold py-3 px-8 rounded-lg shadow transition" aria-label="Entrar no sistema">
                    Entrar no Painel
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-gray-600">
                Não tem conta? <a href="{{ route('cadastro') }}" class="text-[#044c9c] font-bold hover:underline">Criar nova conta</a>
            </p>

            @if(session('erro'))
            <p class="mt-4 text-red-600 text-sm text-center">{{ session('erro') }}</p>
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