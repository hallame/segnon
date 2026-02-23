
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de votre message</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .email-container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; }
        h2 { color: #333; }
        p { font-size: 16px; line-height: 1.5; }
    </style>
</head>
<body>
    <div class="email-container">
        <h2>Bonjour {{ $client->lastname }} {{ $client->firstname }},</h2>
        <p>Nous avons bien reçu votre message via notre formulaire de contact. Notre équipe le traitera dans les plus brefs délais et vous répondra sous peu.</p>
        <p>Voici un résumé de votre message :</p>

        <p><strong>Sujet :</strong> {{ $subject ?? 'Non spécifié' }}</p>
        <p><strong>Message :</strong> {{ $message ?? 'Aucun message reçu' }}</p>
        <p>Merci pour votre patience et votre confiance.</p>
        <p>Bien cordialement,</p>
        <p>L'équipe Zaly Merveille</p>
    </div>
</body>
</html>

