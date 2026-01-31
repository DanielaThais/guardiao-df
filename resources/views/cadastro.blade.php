<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Guardião DF</title>
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
        </div>
    </nav>

    <main id="conteudo-principal" class="container mx-auto mt-16 p-4 flex justify-center">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 w-full max-w-md">
            <h2 class="text-xl font-semibold text-gray-800 mb-6 text-center">Cadastro</h2>

            <form id="form-cadastro" action="{{ route('cadastro.store') }}" method="POST" onsubmit="validarCadastro(event)">
                @csrf
                <p class="text-xs text-gray-500 mb-4 items-center flex">
                    <span class="text-red-500 mr-1">*</span> Campos obrigatórios
                </p>

                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                            Nome Completo <span class="text-red-500">*</span>
                        </label>
                        <input id="name" type="text" name="name" required class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                            E-mail <span class="text-red-500">*</span>
                        </label>
                        <input id="email" type="email" name="email" required class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition">
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                            Senha <span class="text-red-500">*</span>
                        </label>
                        <input id="password" type="password" name="password" required
                            class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition">
                        <p id="erro-senha-8" class="hidden text-red-500 text-xs mt-1 font-semibold">Mínimo de 8 caracteres.</p>
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                            Confirme sua senha <span class="text-red-500">*</span>
                        </label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required
                            class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition">
                        <p id="erro-confirmacao" class="hidden text-red-500 text-xs mt-1 font-semibold">As senhas não conferem.</p>
                    </div>
                </div>

                <button type="submit" class="w-full mt-6 bg-[#044c9c] hover:bg-blue-800 text-white font-bold py-3 px-8 rounded-lg shadow transition duration-200">
                    Registrar no Sistema
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-gray-600">
                Já possui acesso? <a href="{{ route('login') }}" class="text-[#044c9c] font-bold hover:underline">Faça login</a>
            </p>
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

    <script>
        function validarCadastro(event) {
            const password = document.getElementById('password');
            const confirmation = document.getElementById('password_confirmation');

            console.log("Validando...");

            if (!email.value.includes('@')) {
                event.preventDefault();
                alert("⚠️ O e-mail deve conter o caractere @.");
                email.focus();
                return false;
            }

            if (password.value.length < 8) {
                event.preventDefault();
                alert("⚠️ A senha deve ter pelo menos 8 caracteres.");
                password.focus();
                return false;
            }

            if (password.value !== confirmation.value) {
                event.preventDefault();
                alert("⚠️ As senhas digitadas não são iguais.");
                confirmation.focus();
                return false;
            }

            return true;
        }
    </script>
    @endsection
</body>

</html>