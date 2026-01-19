<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guardião DF - Scanner de Privacidade</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 min-h-screen">

    <nav class="bg-blue-900 p-4 text-white shadow-md">
        <div class="container mx-auto">
            <h1 class="text-xl font-bold tracking-tight">🛡️ GUARDIÃO DF <span class="font-light text-blue-300">| Scanner de Privacidade</span></h1>
        </div>
    </nav>

    <main class="container mx-auto mt-8 p-4">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Análise de Conteúdo e-SIC</h2>

            <form action="{{ route('scan') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2 italic">
                        Cole abaixo o texto do protocolo ou denúncia para identificar dados sensíveis:
                    </label>
                    <textarea
                        name="texto"
                        rows="8"
                        class="w-full p-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                        placeholder="Ex: O cidadão Julio Cesar, CPF 123.456.789-00, solicitou..."
                        required></textarea>
                </div>

                <button type="submit" class="w-full md:w-auto bg-blue-700 hover:bg-blue-800 text-white font-bold py-3 px-8 rounded-lg shadow transition duration-200">
                    🔍 Iniciar Varredura de Dados
                </button>
            </form>

            @if(session('sucesso'))
            <div class="mt-8 border-t pt-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-gray-800">Resultado da Classificação</h3>
                    <div class="px-4 py-2 bg-red-100 text-red-800 rounded-full font-bold">
                        Score de Risco (P1): {{ session('sucesso')['score'] }}%
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <span class="text-sm font-bold text-gray-500 uppercase">Texto com Máscara de Proteção:</span>
                        <div class="p-4 bg-gray-100 rounded-lg border border-gray-200 text-gray-700 leading-relaxed">
                            {!! nl2br(e(session('sucesso')['mascarado'])) !!}
                        </div>
                    </div>

                    <div class="space-y-2">
                        <span class="text-sm font-bold text-gray-500 uppercase">Dados Sensíveis Identificados:</span>
                        <div class="bg-white border border-gray-200 rounded-lg p-4">
                            @foreach(session('sucesso')['achados'] as $tipo => $itens)
                            <div class="mb-2">
                                <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs font-bold rounded uppercase">{{ $tipo }}</span>
                                <ul class="list-disc ml-5 mt-1 text-sm text-gray-600">
                                    @foreach($itens as $item)
                                    <li>{{ $item }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </main>

    <footer class="text-center mt-12 text-gray-400 text-xs uppercase tracking-widest italic">
        Projeto Guardião DF - Tecnologia a serviço da transparência e privacidade.
    </footer>

</body>

</html>