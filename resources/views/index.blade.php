<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Guardião DF</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 min-h-screen">

    <nav class="bg-blue-900 p-4 text-white shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold tracking-tight">🛡️ GUARDIÃO DF <span class="font-light text-blue-300">| Painel</span></h1>
            <div class="space-x-6 text-sm font-medium">
                <a href="{{ route('login') }}" class="hover:text-blue-300 transition">Entrar</a>
                <a href="{{ route('cadastro') }}" class="bg-blue-700 px-4 py-2 rounded-lg hover:bg-blue-800 transition">Criar Conta</a>
            </div>
        </div>
    </nav>

    <main class="container mx-auto mt-12 p-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-extrabold text-gray-900 mb-4">Proteção de Dados e Transparência</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                O Guardião DF utiliza inteligência para identificar e mascarar dados sensíveis em protocolos e denúncias, garantindo a conformidade com a LGPD no âmbito do Distrito Federal.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">

            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-200 hover:shadow-md transition group">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mb-6 group-hover:bg-blue-700 transition">
                    <span class="text-2xl group-hover:scale-110 transition">🔍</span>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Scanner de Privacidade</h3>
                <p class="text-gray-500 mb-6">Analise textos de processos e e-SIC em busca de CPFs, telefones e endereços expostos.</p>
                <a href="{{ route('analise') }}" class="inline-flex items-center text-blue-700 font-bold hover:text-blue-900">
                    Acessar Ferramenta <span class="ml-2">→</span>
                </a>
                </p>
            </div>

            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-200 hover:shadow-md transition group">
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mb-6 group-hover:bg-green-600 transition">
                    <span class="text-2xl group-hover:scale-110 transition">📋</span>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Relatórios e Auditoria</h3>
                <p class="text-gray-500 mb-6">Em breve: visualize o histórico de varreduras e gere relatórios de conformidade para sua gerência.</p>
                <span class="text-gray-400 text-sm italic font-medium">Módulo em desenvolvimento</span>
            </div>

        </div>

        <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-4 text-center">
            <div class="p-6">
                <p class="text-4xl font-black text-blue-900">100%</p>
                <p class="text-sm text-gray-500 uppercase font-bold mt-2">Seguro</p>
            </div>
            <div class="p-6 border-x border-gray-200">
                <p class="text-4xl font-black text-blue-900">LGPD</p>
                <p class="text-sm text-gray-500 uppercase font-bold mt-2">Conformidade</p>
            </div>
            <div class="p-6">
                <p class="text-4xl font-black text-blue-900">DF</p>
                <p class="text-sm text-gray-500 uppercase font-bold mt-2">Foco Local</p>
            </div>
        </div>
    </main>

    <footer class="text-center mt-20 text-gray-400 text-xs uppercase tracking-widest italic pb-10">
        Governo do Distrito Federal - Tecnologia e Segurança da Informação.
    </footer>

</body>

</html>