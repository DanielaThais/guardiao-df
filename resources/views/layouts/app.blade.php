<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guardião DF - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ asset('js/guardiao-scripts.js') }}"></script>
    <style>
        /* Estilos de Acessibilidade */
        .alto-contraste {
            background-color: #000 !important;
            color: #fff !important;
        }

        .alto-contraste .bg-white,
        .alto-contraste .bg-gray-50,
        .alto-contraste nav {
            background-color: #000 !important;
            border: 1px solid #fff !important;
        }

        .alto-contraste a,
        .alto-contraste button {
            color: #ffff00 !important;
        }

        .alto-contraste input {
            background-color: #000 !important;
            color: #fff !important;
            border: 1px solid #fff !important;
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen flex flex-col">
    <a href="#conteudo-principal" class="sr-only focus:not-sr-only focus:absolute focus:z-50 focus:p-4 focus:bg-yellow-400 focus:text-black font-bold">Pular para conteúdo principal</a>

    <nav class="bg-gray-200 border-b border-gray-300 py-1" role="complementary">
        <div class="container mx-auto flex justify-between px-4 items-center">
            <ul class="flex space-x-4 text-[10px] font-bold text-gray-600 uppercase">
                <li><a href="#conteudo-principal" accesskey="1">Ir para o conteúdo [1]</a></li>
            </ul>
            <div class="flex gap-4 items-center">
                <button onclick="document.body.classList.toggle('alto-contraste')" class="text-[10px] font-bold border border-gray-400 px-2 py-0.5 hover:bg-gray-300">ALTO CONTRASTE</button>
                <div class="flex gap-1">
                    <button onclick="document.documentElement.style.fontSize = '120%'" class="text-xs font-bold px-1 border border-gray-400">A+</button>
                    <button onclick="document.documentElement.style.fontSize = '100%'" class="text-xs font-bold px-1 border border-gray-400">A-</button>
                </div>
            </div>
        </div>
    </nav>

    <main id="conteudo-principal" class="flex-1 flex flex-col">
        @yield('content')
    </main>

    <div vw class="enabled">
        <div vw-access-button class="active"></div>
        <div vw-plugin-wrapper>
            <div class="vw-plugin-top-wrapper"></div>
        </div>
    </div>
    <script src="https://vlibras.gov.br/app/vlibras-plugin.js"></script>
    <script>
        new window.VLibras.Widget('https://vlibras.gov.br/app');
    </script>
    @yield('footer-area')
</body>

</html>