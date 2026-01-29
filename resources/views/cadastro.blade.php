<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Guardião DF</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 min-h-screen">

    <nav class="bg-blue-900 p-4 text-white shadow-md">
        <div class="container mx-auto">
            <h1 class="text-xl font-bold tracking-tight">🛡️ GUARDIÃO DF <span class="font-light text-blue-300">| Criar Conta</span></h1>
        </div>
    </nav>

    <main class="container mx-auto mt-8 p-4 flex justify-center">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 w-full max-w-md">
            <h2 class="text-xl font-semibold text-gray-800 mb-6 text-center">Cadastro</h2>

            <form action="#" method="POST">
                @csrf
                <p class="text-xs text-gray-500 mb-4 items-center flex">
                    <span class="text-red-500 mr-1">*</span> Campos obrigatórios
                </p>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Nome Completo <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" required class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            E-mail Institucional <span class="text-red-500">*</span>
                        </label>
                        <input type="email" name="email" required class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Senha <span class="text-red-500">*</span>
                        </label>
                        <input type="password" name="password" required class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Confirme sua senha <span class="text-red-500">*</span>
                        </label>
                        <input type="password" name="password_confirmation" required class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition">
                    </div>
                </div>

                <button type="submit" class="w-full mt-6 bg-blue-700 hover:bg-blue-800 text-white font-bold py-3 px-8 rounded-lg shadow transition duration-200">
                    Registrar no Sistema
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-gray-600">
                Já possui acesso? <a href="{{ route('login') }}" class="text-blue-700 font-bold hover:underline">Faça login</a>
            </p>
        </div>
    </main>

    <footer class="text-center mt-12 text-gray-400 text-xs uppercase tracking-widest italic pb-8">
        Projeto Guardião DF - Segurança e Privacidade.
    </footer>

</body>

</html>