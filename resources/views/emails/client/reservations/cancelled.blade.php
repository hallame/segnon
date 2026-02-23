<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Annulation de votre réservation</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        body {
            /* font-family: 'Poppins', sans-serif; */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;

            
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 30px auto;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
            border: 1px solid #e0e0e0;
        }
        .header {
            background-color: #33a805;
            color: #fff;
            padding: 20px 30px;
            text-align: center;
        }
        .content {
            padding: 30px;
        }
        .content h4 {
            margin-bottom: 15px;
            color: #36b205;
        }
        .footer {
            padding: 20px 30px;
            background-color: #f1f1f1;
            text-align: center;
            font-size: 14px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h2>Réservation annulée</h2>
        </div>
        <div class="content">
            <p>Bonjour <strong>{{ $client_name }}</strong>,</p>

            <p>Nous vous informons que votre réservation de <strong>{{ $reservation }}</strong> a été annulée.</p>

            <h4>Raison de l'annulation:</h4>
            <p style="font-style: italic; color: #a00;">{{ $cancellation_reason }}</p>

            <p>Nous restons à votre disposition pour tout complément d'information ou pour une nouvelle réservation.</p>

            <p>Cordialement,<br><strong>L'équipe Zaly Merveille</strong></p>
        </div>
        <div class="footer">
            © {{ date('Y') }} Zaly Merveille. Tous droits réservés.
        </div>
    </div>
</body>
</html>
