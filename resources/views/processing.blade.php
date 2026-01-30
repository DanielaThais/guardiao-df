<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Autenticando...</title>
    <meta http-equiv="refresh" content="2;url={{ route('index') }}">
    <style>
        body {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8fafc;
            font-family: Arial, sans-serif;
        }

        .box {
            text-align: center;
        }

        .spinner {
            width: 48px;
            height: 48px;
            border: 5px solid #ddd;
            border-top: 5px solid #1351B4;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 20px auto;
        }

        @keyframes spin {
            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body>
    <div class="box">
        <h2>Autenticando com o gov.br</h2>
        <div class="spinner"></div>
        <p>Por favor, aguarde…</p>
    </div>

    <script>
        setTimeout(function() {
            window.location.href = "{{ route('index') }}";
        }, 3000);
    </script>
</body>

</html>