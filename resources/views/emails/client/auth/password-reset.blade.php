<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation de votre mot de passe</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
    <p>Bonjour {{ $client->lastname }} {{ $client->firstname }},</p>
    <p>Pour réinitialiser votre mot de passe, cliquez sur le lien ci-dessous :</p>
    <p>👉 <a href="{{ url('/client/reset-password/' . $token) }}" style="color: #c05600; font-weight: bold;">Réinitialiser mon mot de passe</a></p>
    <p>Ce lien expirera dans 60 minutes. Si vous n'avez pas demandé cette réinitialisation, veuillez ignorer cet email.</p>
    <p>Cordialement,</p>
    <p>L'équipe Zaly Merveille</p>
</body>
</html>

