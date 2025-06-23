<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Verifica tu correo electrónico</title>
    <style>
        body {
            margin: 0;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f3f4f6;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .card {
            background-color: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        h1 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: #111827;
        }

        p {
            margin-bottom: 1.5rem;
            color: #374151;
        }

        .message {
            color: green;
            margin-bottom: 1rem;
            font-weight: bold;
        }

        button {
            background-color: #3b82f6;
            color: white;
            border: none;
            padding: 0.6rem 1rem;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            margin: 0.5rem 0;
            width: 100%;
        }

        button:hover {
            background-color: #2563eb;
        }

        form {
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="card">
        <h1>Verificación de email</h1>

        @if (session('message'))
            <div class="message">{{ session('message') }}</div>
        @endif

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit">Reenviar enlace de verificacion</button>
        </form>

    </div>
</body>
</html>
