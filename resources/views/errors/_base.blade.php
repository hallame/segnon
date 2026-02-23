@php
  $status = (int) ($status ?? ($code ?? optional($exception ?? null)->getStatusCode() ?? 500));

  $defaults = [
    400 => ['title'=>'Requête invalide','message'=>"La requête n'a pas pu être comprise ou était mal formée."],
    401 => ['title'=>'Non authentifié','message'=>"Veuillez vous connecter pour accéder à cette page."],
    403 => ['title'=>'Accès refusé','message'=>"Vous n'avez pas l'autorisation d'accéder à cette ressource."],
    404 => ['title'=>'Page introuvable','message'=>"La page que vous cherchez n'existe pas ou a été déplacée."],
    405 => ['title'=>'Méthode non autorisée','message'=>"La méthode HTTP utilisée n’est pas autorisée ici."],
    419 => ['title'=>'Session expirée','message'=>"Votre session a expiré. Veuillez réessayer."],
    422 => ['title'=>'Données invalides','message'=>"Certaines données envoyées ne sont pas valides."],
    429 => ['title'=>'Trop de requêtes','message'=>"Veuillez patienter avant de réessayer."],
    500 => ['title'=>'Erreur interne','message'=>"Une erreur est survenue côté serveur. Nous travaillons à la résoudre."],
    502 => ['title'=>'Passerelle invalide','message'=>"Le serveur en amont a renvoyé une réponse invalide."],
    503 => ['title'=>'Service indisponible','message'=>"Le service est momentanément indisponible. Merci de réessayer plus tard."],
    504 => ['title'=>'Délai dépassé','message'=>"Le serveur a mis trop de temps à répondre."],
  ];
  if (!array_key_exists($status, $defaults)) $status = 500;
  $title   = $title   ?? $defaults[$status]['title'];
  $message = $message ?? $defaults[$status]['message'];
  $homeUrl = route('home');
@endphp


<!doctype html>
<html lang="fr" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="robots" content="noindex, nofollow">

    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>{{ $status }} – {{ $title }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font: Lexend -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">

    <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon.png') }}">
    <style>
        /* Sécurité au cas où Tailwind n'est pas chargé */
        .btn{padding:.6rem 1rem;border-radius:.75rem;display:inline-flex;gap:.5rem;align-items:center;font-weight:600}
        body { font-family: 'Lexend', ui-sans-serif, system-ui, -apple-system,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans"; }

    </style>
</head>

<body class="h-full bg-gradient-to-b from-neutral-50 to-neutral-100 text-neutral-900">
  <main class="min-h-full grid place-items-center px-4 py-16">
    <div class="max-w-2xl text-center">
      <div class="inline-flex items-center justify-center rounded-2xl bg-neutral-900 text-white px-4 py-2 mb-6">
        <span class="text-xl font-extrabold tracking-tight">{{ $status }}</span>
      </div>

      <h1 class="text-3xl md:text-4xl font-extrabold mb-3">{{ $title }}</h1>
      <p class="text-neutral-600 mb-8">{{ $message }}</p>

      <div class="flex flex-wrap justify-center gap-3">
        <a href="{{ $homeUrl }}" class="btn bg-emerald-600 text-white hover:bg-emerald-500">Retour à l’accueil</a>
        <button onclick="location.reload()" class="btn bg-white text-neutral-900 border border-neutral-300 hover:bg-neutral-50">Recharger la page</button>
        @isset($supportUrl)
          <a href="{{ $supportUrl }}" class="btn bg-white text-neutral-900 border border-neutral-300 hover:bg-neutral-50">Contacter le support</a>
        @endisset
      </div>
    </div>
  </main>
</body>
</html>
