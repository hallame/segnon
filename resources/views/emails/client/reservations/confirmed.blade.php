<!DOCTYPE html>
<html lang="fr">
<head>
    
    <meta charset="UTF-8">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <title>Confirmation de votre réservation</title>
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
            background-color: #2d9404;
            color: #fff;
            padding: 20px 30px;
            text-align: center;
        }
        .content {
            padding: 30px;
        }
        .content h4 {
            margin-bottom: 15px;
            color: #2f9108;
        }
        ul {
            padding-left: 20px;
            line-height: 1.6;
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
            <h2>Réservation confirmée</h2>
        </div>
        <div class="content">
            <p>Bonjour <strong>{{ $client_name }}</strong>,</p>
            <p>Nous avons le plaisir de vous confirmer votre réservation de <strong>{{ $reservation }}</strong>.</p>

            <h4>Détails de la réservation :</h4>
            <ul>
                <li><strong>Dates :</strong> du {{ \Carbon\Carbon::parse($start_date)->format('d/m/Y') }} au {{ \Carbon\Carbon::parse($end_date)->format('d/m/Y') }}</li>
                <li><strong>Nombre de personnes :</strong> {{ $number_of_people }}</li>
                {{-- <li><strong>Statut du paiement :</strong> {{ $payment_status }}</li> --}}
            </ul>
            <p>Nous sommes impatients de vous accueillir. Merci de conserver ce message.</p>

            <p>Cordialement,<br><strong>L'équipe Zaly Merveille</strong></p>
        </div>

        <div class="footer">
            © {{ date('Y') }} Zaly Merveille. Tous droits réservés.
        </div>
    </div>
</body>
</html>
