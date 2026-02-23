@php
    $event = $order->event;
@endphp

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Paiement non validé</title>
</head>
<body style="margin:0;padding:0;background-color:#fef2f2;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;">
<div style="max-width:600px;margin:0 auto;padding:24px;">
    {{-- Header --}}
    <div style="text-align:center;margin-bottom:24px;">
        <h1 style="margin:0;font-size:22px;color:#991b1b;">Votre paiement n’a pas pu être validé</h1>
        @if($event)
            <p style="margin:8px 0 0;font-size:14px;color:#4b5563;">
                Événement : <strong>{{ $event->name }}</strong>
            </p>
        @endif
    </div>

    {{-- Carte principale --}}
    <div style="background-color:#ffffff;border-radius:16px;border:1px solid #fecaca;padding:20px 20px 16px;">
        <p style="margin:0 0 12px;font-size:14px;color:#374151;">
            Bonjour {{ trim($order->customer_firstname.' '.$order->customer_lastname) ?: 'Cher(e) participant(e)' }},
        </p>

        <p style="margin:0 0 12px;font-size:14px;color:#374151;">
            Après vérification, votre paiement pour l’événement
            <strong>{{ $event->name ?? '' }}</strong> n’a pas pu être validé.
        </p>

        {{-- Référence + statut --}}
        <table style="width:100%;border-collapse:collapse;margin:12px 0 16px;">
            <tr>
                <td style="font-size:13px;color:#6b7280;padding:4px 0;">Référence de commande</td>
                <td style="font-size:13px;color:#111827;padding:4px 0;text-align:right;font-weight:600;">
                    {{ $order->reference }}
                </td>
            </tr>
            <tr>
                <td style="font-size:13px;color:#6b7280;padding:4px 0;">Montant</td>
                <td style="font-size:13px;color:#111827;padding:4px 0;text-align:right;font-weight:600;">
                    {{ number_format($order->total, 0, ',', ' ') }} {{ $order->currency }}
                </td>
            </tr>
            <tr>
                <td style="font-size:13px;color:#6b7280;padding:4px 0;">Statut du paiement</td>
                <td style="font-size:13px;color:#b91c1c;padding:4px 0;text-align:right;font-weight:600;">
                    Rejeté
                </td>
            </tr>
        </table>

        {{-- Motif éventuel (note admin) --}}
        @if($payment->note)
            <div style="margin:12px 0 16px;">
                <p style="margin:0 0 6px;font-size:13px;color:#6b7280;font-weight:600;">
                    Détails / commentaire
                </p>
                <div style="font-size:13px;color:#374151;border-radius:12px;border:1px solid #fee2e2;background-color:#fef2f2;padding:10px 12px;">
                    {!! nl2br(e($payment->note)) !!}
                </div>
            </div>
        @endif

        <p style="margin:0 0 10px;font-size:13px;color:#4b5563;">
            Aucun billet n’a été généré pour cette commande.
        </p>

        <p style="margin:0 0 12px;font-size:13px;color:#4b5563;">
            Vous pouvez réessayer avec un autre moyen de paiement ou contacter l’équipe
            d’organisation si vous pensez qu’il s’agit d’une erreur.
        </p>

        @if($event)
            <div style="text-align:center;margin-top:16px;margin-bottom:4px;">
                <a href="{{ route('events.checkout', [$event, $order]) }}"
                   style="display:inline-block;padding:10px 18px;border-radius:999px;
                          background-color:#4b5563;color:#ffffff;font-size:13px;
                          text-decoration:none;font-weight:600;">
                    Revoir ma commande 
                </a>
            </div>
        @endif
    </div>

    <p style="margin:16px 0 0;font-size:12px;color:#9ca3af;text-align:center;">
        Si vous avez déjà réglé par un autre canal, merci d’ignorer cet e-mail ou de contacter le support.
    </p>
</div>
</body>
</html>
