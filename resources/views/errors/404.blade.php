

@php($status = 404)
@include('errors._base', compact('status'))
{{-- <!DOCTYPE html>


<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>404 - Page non trouvée</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #013f19, #203a43, #2c5364);
            color: #fff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            text-align: center;
            padding: 30px;
            background-color: rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.4);
            max-width: 500px;
        }

        .container h1 {
            font-size: 120px;
            margin: 0;
            color: #ff6b6b;
            animation: bounce 1s infinite alternate;
        }

        .container h2 {
            font-size: 28px;
            margin-top: -20px;
            margin-bottom: 20px;
        }

        .container p {
            font-size: 16px;
            color: #ccc;
            margin-bottom: 30px;
        }

        .container a {
            text-decoration: none;
            color: #fff;
            background-color: #ff6b6b;
            padding: 12px 30px;
            border-radius: 30px;
            transition: background-color 0.3s ease;
        }

        .container a:hover {
            background-color: #ff4c4c;
        }

        @keyframes bounce {
            to {
                transform: translateY(-10px);
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>404</h1>
        <h2>Page introuvable</h2>
        <a href="{{ route('home') }}">Retour à l'accueil</a>
    </div>

</body>
</html>
 --}}
