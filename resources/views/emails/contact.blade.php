<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Demande de Contact</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            padding: 20px;
        }
        .email-content {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
        }
        h2 {
            color: #2C3E50;
        }
        p {
            font-size: 14px;
            color: #34495E;
            line-height: 1.5;
            margin: 0 0 8px;
        }
        .info {
            background-color: #ECF0F1;
            padding: 10px;
            margin-top: 20px;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="email-content">
        <h2>Nouvelle demande de contact</h2>

        <p><strong>Prénom :</strong> {{ $firstname }}</p>
        <p><strong>Nom :</strong> {{ $lastname }}</p>
        <p><strong>Email :</strong> {{ $email }}</p>

        @if(!empty($phone))
            <p><strong>Téléphone :</strong> {{ $phone }}</p>
        @endif

        <p><strong>Sujet :</strong> {{ $subject }}</p>

        <div class="info">
            <p><strong>Message :</strong></p>
            <p>{!! nl2br(e($messageContent)) !!}</p>
        </div>
    </div>
</body>
</html>
