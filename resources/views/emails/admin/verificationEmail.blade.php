<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vérifier votre adresse mail</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
    <p>Bonjour {{ $admin->firstname }},</p>
    <p> Votre code de vérification est : <span style="font-weight: bold; color: #c05600;">{{ $code }}</span></p>
    <p>⏱️Ce code est valable pendant 30 minutes. Si vous ne l’avez pas demandé,
        veuillez ignorer cet email.
    </p>
    <p>Cordialement,</p>
    <p>L'équipe Omizix</p>
</body>
</html>
