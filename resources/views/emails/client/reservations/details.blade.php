<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">

    <title>Détails de votre réservation</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 30px auto;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            border-top: 5px solid #278104;
        }

        .header {
            background-color: #298405;
            color: white;
            padding: 20px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 20px;
        }

        .content {
            padding: 20px;
        }

        .content p {
            margin: 10px 0;
        }

        .highlight {
            font-weight: bold;
            color: #154702;
        }


        .btn {
            display: inline-block;
            background-color: #278104;
            color: white;
            padding: 12px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.3s;
            margin-top: 20px;
        }

        .btn:hover {
            background-color: #133f02;
        }

        .footer {
            padding: 15px;
            text-align: center;
            font-size: 13px;
            background-color: #f1f1f1;
            color: #777;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="header">
            <h1>Détails de votre réservation</h1>
        </div>
        <div class="content">
            <p><strong>Nom Complet :</strong> {{ $client_name }}</p>
            <p><strong>Type de réservation :</strong> {{ $type }}</p>
            <p><strong>{{ $type }} réservé :</strong> {{ $reservation_name }}</p>

            <p><strong>Date de début :</strong> {{ \Carbon\Carbon::parse($start_date)->format('d/m/Y à H:i') }}</p>
            <p><strong>Date de fin :</strong> {{ \Carbon\Carbon::parse($end_date)->format('d/m/Y à H:i') }}</p>
            <p><strong>Nombre de personnes :</strong> {{ $number_of_people }}</p>
            <p><strong>Numéro de suivi:</strong> {{ $reference }}</p>

            {{-- <p><strong>Status de paiement :</strong> {{ $payment_status }}</p> --}}
            <p><strong>Note :</strong> {{ $note ?? 'Aucune note spécifiée' }}</p>

            <hr style="margin: 20px 0;">

            @isset($for_client)
                @if($for_client)
                    <p><strong>Code de confirmation :</strong> <span class="highlight">{{ $confirmation_code }}</span></p>

                    <p>Pour confirmer votre réservation, veuillez cliquer sur le bouton ci-dessous :</p>
                    <a href="{{ route('reservations.confirm', ['confirmation_code' => $confirmation_code]) }}" class="btn">Confirmer la réservation</a>
                @endif
            @endisset

        </div>

        <div class="footer">
            &copy; {{ date('Y') }} Zaly Merveille. Tous droits réservés.
        </div>
    </div>
</body>
</html>
