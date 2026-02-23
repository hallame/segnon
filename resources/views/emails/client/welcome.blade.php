<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Bienvenue sur {{ config('app.name') }}</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f7fafc;
      color: #333;
      line-height: 1.6;
      padding: 20px;
    }
    .container {
      max-width: 600px;
      background-color: #ffffff;
      margin: 0 auto;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }
    h2 {
      color: #0f766e;
      font-size: 20px;
    }
    .btn {
      display: inline-block;
      margin-top: 20px;
      padding: 12px 24px;
      background-color: #10b981;
      color: #ffffff;
      text-decoration: none;
      border-radius: 5px;
      font-weight: bold;
    }
    .btn:hover {
      background-color: #059669;
    }
    .footer {
      margin-top: 40px;
      font-size: 12px;
      color: #999;
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Bienvenue {{ $client->firstname }} 👋</h2>

    <p>Votre compte a été créé avec succès sur <strong>{{ config('app.name') }}</strong>.</p>

    <p>Voici vos identifiants de connexion :</p>

    <ul>
      <li><strong>Email :</strong> {{ $client->email }}</li>
      <li><strong>Mot de passe initial :</strong> {{ $password }}</li>
    </ul>

    <p>Nous vous recommandons de modifier votre mot de passe dès votre première connexion pour renforcer la sécurité de votre compte.</p>

    <p>Vous pouvez accéder à votre espace personnel via le bouton ci-dessous :</p>

    <a href="{{ route('client.login') }}" class="btn">Accéder à mon compte</a>

    <p style="margin-top: 24px; font-size: 13px; color: #666;">
      Si vous n’êtes pas à l’origine de cette inscription, veuillez ignorer ce message.
    </p>

    <div class="footer">
      © {{ date('Y') }} {{ config('app.name') }}. Tous droits réservés.
    </div>
  </div>
</body>
</html>
