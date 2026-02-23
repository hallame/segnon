<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">

    <title>Merci pour votre visite !</title>
</head>
<body style="font-family: Segoe UI, sans-serif; background-color: #f6f6f6; padding: 30px;">
    <div style="max-width: 600px; margin: auto; background-color: white; border-radius: 8px; overflow: hidden; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        <div style="background-color: #309c06; color: white; padding: 20px; text-align: center;">
            <h2>Merci pour votre visite !</h2>
        </div>
        
        <div style="padding: 30px;">
            <p>Bonjour {{ $client_name }},</p>
            <p>Nous espérons que votre expérience au <strong>{{ $reservation }}</strong> a été à la hauteur de vos attentes.</p>
            <p>Nous aimerions beaucoup avoir votre avis ! Cela nous aide à améliorer la qualité de nos services.</p>
            {{-- <div style="text-align: center; margin-top: 30px;">
                <a href="{{ url('/avis') }}" style="background-color: #154702; color: white; padding: 12px 25px; border-radius: 5px; text-decoration: none;">Donner mon avis</a>
            </div> --}}
            <p style="margin-top: 40px;">Merci encore pour votre confiance,<br>L'équipe Zaly Merveille</p>
        </div>
    </div>
</body>
</html>
