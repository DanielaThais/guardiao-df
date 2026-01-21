<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Análise de Dados - Guardião DF</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 min-h-screen">

    <nav class="bg-blue-900 p-4 text-white shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold tracking-tight">
                <a href="{{ route('index') }}">🛡️ GUARDIÃO DF <span class="font-light text-blue-300">| Scanner</span></a>
            </h1>
            <a href="{{ route('index') }}" class="text-sm bg-blue-800 hover:bg-blue-700 px-3 py-1 rounded transition">
                Voltar ao Início
            </a>
        </div>
    </nav>

    <main class="container mx-auto mt-8 p-4">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center space-x-2 mb-4 text-blue-800">
                <span>🔍</span>
                <h2 class="text-lg font-semibold text-gray-800">Nova Varredura de Conteúdo</h2>
            </div>

            <form action="{{ route('scan') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2 italic">
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
                        file:bg-blue-700 file:text-white
                        hover:file:bg-blue-800 transition cursor-pointer">

                    <p class="mt-2 text-xs text-blue-600 italic">
                        * O sistema processará o texto contido no arquivo automaticamente.
                    </p>
                </div>

                <button type="submit" class="w-full md:w-auto bg-blue-700 hover:bg-blue-800 text-white font-bold py-3 px-8 mt-3 rounded-lg shadow transition duration-200">
                    Iniciar Varredura
                </button>
            </form>

            @if(session('sucesso'))
            @endif
        </div>
    </main>

    <footer class="text-center mt-12 text-gray-400 text-xs uppercase tracking-widest italic pb-8">
        Guardião DF - Protegendo a privacidade do cidadão.
    </footer>

</body>

</html>