<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouveau message de contact</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .email-container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; }
        h2 { color: #333; }
        p { font-size: 16px; line-height: 1.5; }
    </style>
</head>

<body>
    <div class="email-container">
        <h2>Un nouveau message a été envoyé via le formulaire de contact</h2>
        <p><strong>Client :</strong> {{ $client->firstname }} {{ $client->lastname }} ({{ $client->email }})</p>
        <p><strong>Sujet :</strong> {{ $subject ?? 'Non spécifié' }}</p>
        <p><strong>Message :</strong></p>
        <p>{!! nl2br(e($message)) !!}</p>
        <p>Merci de traiter cette demande dans les plus brefs délais.</p>
        <p>Bien cordialement,</p>
        <p>L'équipe Zaly Merveille</p>
    </div>
</body>
</html>
