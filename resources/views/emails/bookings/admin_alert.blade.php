{{-- <!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Nouvelle réservation</title>
</head>
<body style="font-family: Arial, sans-serif; color:#333;">

    <h2>📩 Nouvelle réservation enregistrée</h2>

    <p>Une nouvelle réservation vient d’être effectuée :</p>

    <ul>
        <li><strong>Référence :</strong> {{ $booking->reference }}</li>
        <li><strong>Client :</strong> {{ $booking->user->firstname }} {{ $booking->user->lastname }}</li>
        <li><strong>Email :</strong> {{ $booking->user->email }}</li>
        <li><strong>Téléphone :</strong> {{ $booking->user->phone }}</li>
        <li><strong>Check-in :</strong> {{ $booking->check_in->format('d/m/Y') }}</li>
        <li><strong>Check-out :</strong> {{ $booking->check_out->format('d/m/Y') }}</li>
        <li><strong>Invités :</strong> {{ $booking->guests }}</li>
        <li><strong>Montant total :</strong> {{ number_format($booking->amount, 2, ',', ' ') }} GNF</li>
        <li><strong>Méthode de paiement :</strong> {{ strtoupper($booking->payment_method) }}</li>
    </ul>

    <p>Merci de consulter le tableau de bord pour plus de détails.</p>

</body>
</html> --}}

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Nouvelle réservation</title>
</head>
<body style="font-family: Arial, sans-serif; color:#333;">
  <h2>📩 Nouvelle réservation enregistrée</h2>

  <p>Une nouvelle réservation vient d’être effectuée :</p>

  @php
    // garde-fous client
    $clientName  = $booking->client_name ?? ($booking->user?->name);
    $clientEmail = $booking->client_email ?? $booking->user?->email;
    $clientPhone = $booking->client_phone ?? $booking->user?->phone;
  @endphp

  <ul>
    <li><strong>Référence :</strong> {{ $booking->reference }}</li>

    {{-- HOTEL / CHAMBRE si Room --}}
    @if(isset($room))
      <li><strong>Hôtel :</strong> {{ $hotel?->name ?? '—' }} @if($hotel?->city) — {{ $hotel->city }} @endif</li>
      <li><strong>Chambre :</strong> {{ $room->name }}</li>
    @else
      {{-- fallback générique --}}
      <li><strong>Ressource :</strong> {{ $booking->bookable_type_label }} — {{ $booking->bookable_name }}</li>
    @endif

    <li><strong>Réservé par :</strong> {{ $clientName ?: '—' }}</li>
    <li><strong>Email :</strong> {{ $clientEmail ?: '—' }}</li>
    <li><strong>Téléphone :</strong> {{ $clientPhone ?: '—' }}</li>
    <li><strong>Check-in :</strong> {{ $booking->check_in?->format('d/m/Y') ?: '—' }}</li>
    <li><strong>Check-out :</strong> {{ $booking->check_out?->format('d/m/Y') ?: '—' }}</li>
    <li><strong>Invités :</strong> {{ (int) $booking->guests }}</li>
    <li><strong>Montant total :</strong> {{ number_format((float)($booking->amount ?? 0), 0, ',', ' ') }} GNF</li>
    <li><strong>Méthode de paiement :</strong> {{ $booking->payment_method ? strtoupper($booking->payment_method) : '—' }}</li>
  </ul>

  <p>Merci de consulter le tableau de bord pour plus de détails.</p>
</body>
</html>

