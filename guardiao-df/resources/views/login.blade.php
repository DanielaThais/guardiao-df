<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Guardião DF</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 min-h-screen">

    <nav class="bg-blue-900 p-4 text-white shadow-md">
        <div class="container mx-auto">
            <h1 class="text-xl font-bold tracking-tight">🛡️ GUARDIÃO DF <span class="font-light text-blue-300">| Acesso</span></h1>
        </div>
    </nav>

    <main class="container mx-auto mt-16 p-4 flex justify-center">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 w-full max-w-md">
            <div class="text-center mb-8">
                <div class="inline-block p-3 rounded-full bg-blue-50 mb-4">
                    <span class="text-3xl">🔑</span>
                </div>
                <h2 class="text-xl font-semibold text-gray-800">Identificação de Usuário</h2>
            </div>

            <form action="#" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">E-mail</label>
                        <input type="email" name="email" required class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition" placeholder="nome@exemplo.com">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Senha</label>
                        <input type="password" name="password" required class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition">
                    </div>
                </div>

                <button type="submit" class="w-full mt-6 bg-blue-700 hover:bg-blue-800 text-white font-bold py-3 px-8 rounded-lg shadow transition duration-200">
                    Entrar no Painel
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-gray-600">
                Não tem conta? <a href="{{ route('cadastro') }}" class="text-blue-700 font-bold hover:underline">Criar nova conta</a>
            </p>
        </div>
    </main>

    <footer class="text-center mt-12 text-gray-400 text-xs uppercase tracking-widest italic">
        Acesso restrito a servidores autorizados.
    </footer>

</body>

</html>