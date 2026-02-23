

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Confirmation de réservation</title>
</head>
<body style="font-family: Arial, sans-serif; color:#333;">
  @php
    $prenom = $client->firstname ?? $booking->client_name ?? null;
  @endphp

  <h2>✅ Confirmation de votre réservation</h2>
  <p>Bonjour {{ $prenom ?: 'cher(e) client(e)' }},</p>

  <p>Merci pour votre réservation. Voici un récapitulatif :</p>

  <ul>
    <li><strong>Référence :</strong> {{ $booking->reference }}</li>

    {{-- HOTEL / CHAMBRE si Room --}}
    @if(isset($room))
      <li><strong>Hôtel :</strong> {{ $hotel?->name ?? '—' }} @if($hotel?->city) — {{ $hotel->city }} @endif</li>
      <li><strong>Chambre :</strong> {{ $room->name }}</li>
    @else
      <li><strong>Ressource :</strong> {{ $booking->bookable_type_label }} — {{ $booking->bookable_name }}</li>
    @endif

    <li><strong>Check-in :</strong> {{ $booking->check_in?->format('d/m/Y') ?: '—' }}</li>
    <li><strong>Check-out :</strong> {{ $booking->check_out?->format('d/m/Y') ?: '—' }}</li>
    <li><strong>Nombre d’invités :</strong> {{ (int) $booking->guests }}</li>
    <li><strong>Montant total :</strong> {{ number_format((float)($booking->amount ?? 0), 0, ',', ' ') }} GNF</li>
    <li><strong>Méthode de paiement :</strong> {{ $booking->payment_method ? strtoupper($booking->payment_method) : '—' }}</li>
  </ul>

  <p>Nous vous tiendrons informé(e) de toute mise à jour concernant votre réservation.</p>

  <p>Merci de votre confiance,<br>
     <strong>L’équipe {{ config('app.name') }}</strong></p>
</body>
</html>

