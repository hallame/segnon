

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Omizix</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
    <p>Bonjour {{ $expert->firstname }} {{ $expert->lastname }},</p>
    <p>🎉 Félicitations ! Votre compte a été créé avec succès.</p>
    <p>Vous pouvez désormais accéder à votre espace et profiter pleinement de nos services.</p>
    <p>👉 <a href="{{ route('expert.login') }}" style="color: #c05600; font-weight: bold;">Connectez-vous ici</a></p>
    <p>Si vous n'êtes pas au courant de cette action, veuillez nous contacter immédiatement.</p>
    <p>Cordialement,</p>
    <p>L'équipe Omizix</p>
</body>
</html>

