@php
    $event = $order->event;
@endphp

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Demande de billets reçue</title>
</head>
<body style="margin:0;padding:0;background-color:#f3f4f6;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;">
<div style="max-width:600px;margin:0 auto;padding:24px;">
    {{-- Header --}}
    <div style="text-align:center;margin-bottom:24px;">
        <h1 style="margin:0;font-size:22px;color:#111827;">Votre demande de billets a bien été reçue</h1>
        @if($event)
            <p style="margin:8px 0 0;font-size:14px;color:#4b5563;">
                Événement : <strong>{{ $event->name }}</strong>
            </p>
        @endif
    </div>

    {{-- Carte principale --}}
    <div style="background-color:#ffffff;border-radius:16px;border:1px solid #e5e7eb;padding:20px 20px 16px;">
        <p style="margin:0 0 12px;font-size:14px;color:#374151;">
            Bonjour {{ trim($order->customer_firstname.' '.$order->customer_lastname) ?: 'Cher(e) participant(e)' }},
        </p>

        <p style="margin:0 0 12px;font-size:14px;color:#374151;">
            Nous avons bien reçu votre demande de billets et les informations de paiement
            pour l’événement <strong>{{ $event->name ?? '' }}</strong>.
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
                <td style="font-size:13px;color:#6b7280;padding:4px 0;">Montant total</td>
                <td style="font-size:13px;color:#111827;padding:4px 0;text-align:right;font-weight:600;">
                    {{ number_format($order->total, 0, ',', ' ') }} {{ $order->currency }}
                </td>
            </tr>
            <tr>
                <td style="font-size:13px;color:#6b7280;padding:4px 0;">Statut</td>
                <td style="font-size:13px;color:#b45309;padding:4px 0;text-align:right;font-weight:600;">
                    En attente de vérification
                </td>
            </tr>
        </table>

        {{-- Détail des billets --}}
        @if($order->items && $order->items->count())
            <div style="margin:12px 0 16px;">
                <p style="margin:0 0 8px;font-size:13px;color:#6b7280;font-weight:600;">
                    Récapitulatif des billets
                </p>
                <table style="width:100%;border-collapse:collapse;">
                    @foreach($order->items as $item)
                        <tr>
                            <td style="font-size:13px;color:#111827;padding:4px 0;">
                                {{ $item->ticket_type_name }}
                                <span style="color:#6b7280;">&nbsp;× {{ $item->qty }}</span>
                            </td>
                            <td style="font-size:13px;color:#111827;padding:4px 0;text-align:right;">
                                {{ number_format($item->total_price, 0, ',', ' ') }} {{ $order->currency }}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        @endif

        <p style="margin:0 0 12px;font-size:13px;color:#4b5563;">
            Un administrateur va vérifier votre paiement. Une fois validé, vos billets
            vous seront envoyés par e-mail et seront disponibles en ligne.
        </p>

        {{-- Bouton vers suivi / confirmation (page commande) --}}
        @if($event)
            <div style="text-align:center;margin-top:16px;margin-bottom:4px;">
                <a href="{{ route('events.confirmation', [$event, $order]) }}"
                   style="display:inline-block;padding:10px 18px;border-radius:999px;
                          background-color:#059669;color:#ffffff;font-size:13px;
                          text-decoration:none;font-weight:600;">
                    Consulter ma commande
                </a>
            </div>
        @endif
    </div>

    {{-- Footer --}}
    <p style="margin:16px 0 0;font-size:12px;color:#9ca3af;text-align:center;">
        Si vous n’êtes pas à l’origine de cette demande, vous pouvez ignorer cet e-mail.
    </p>
</div>
</body>
</html>
