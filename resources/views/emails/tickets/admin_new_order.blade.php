@php
    $event = $order->event;
@endphp

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Nouvelle commande de billets</title>
</head>
<body style="font-family: -apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif; background:#f5f5f5; padding:24px;">
<table width="100%" cellpadding="0" cellspacing="0" style="max-width:620px; margin:0 auto; background:#ffffff; border-radius:12px; overflow:hidden;">
    <tr>
        <td style="padding:20px 24px; border-bottom:1px solid #eee;">
            <h1 style="margin:0 0 4px; font-size:18px; color:#111827;">
                Nouvelle commande de billets
            </h1>
            <p style="margin:0; font-size:13px; color:#6b7280;">
                Référence : <strong>{{ $order->reference }}</strong>
            </p>
            @if($event)
                <p style="margin:4px 0 0; font-size:13px; color:#6b7280;">
                    Événement : <strong>{{ $event->name }}</strong>
                </p>
            @endif
        </td>
    </tr>

    <tr>
        <td style="padding:16px 24px;">
            <h2 style="margin:0 0 8px; font-size:15px; color:#111827;">Client</h2>
            <p style="margin:0 0 4px; font-size:13px; color:#374151;">
                {{ $order->customer_firstname }} {{ $order->customer_lastname }}
            </p>
            @if($order->customer_email)
                <p style="margin:0 0 2px; font-size:13px; color:#6b7280;">
                    Email : <a href="mailto:{{ $order->customer_email }}" style="color:#2563eb;">
                        {{ $order->customer_email }}
                    </a>
                </p>
            @endif
            @if($order->customer_phone)
                <p style="margin:0 0 2px; font-size:13px; color:#6b7280;">
                    Téléphone : {{ $order->customer_phone }}
                </p>
            @endif
        </td>
    </tr>

    <tr>
        <td style="padding:0 24px 16px;">
            <h2 style="margin:0 0 8px; font-size:15px; color:#111827;">Détail de la commande</h2>

            <table width="100%" cellpadding="0" cellspacing="0" style="font-size:13px; border-collapse:collapse;">
                <thead>
                <tr>
                    <th align="left" style="padding:6px 0; border-bottom:1px solid #e5e7eb; color:#6b7280;">Billet</th>
                    <th align="right" style="padding:6px 0; border-bottom:1px solid #e5e7eb; color:#6b7280;">Qté</th>
                    <th align="right" style="padding:6px 0; border-bottom:1px solid #e5e7eb; color:#6b7280;">Total</th>
                </tr>
                </thead>
                <tbody>
                @foreach($order->items as $item)
                    <tr>
                        <td style="padding:6px 0; border-bottom:1px solid #f3f4f6; color:#111827;">
                            {{ $item->ticket_type_name }}
                            <div style="font-size:11px; color:#6b7280;">
                                {{ $item->qty }} × {{ number_format($item->unit_price, 0, ',', ' ') }} {{ $order->currency }}
                            </div>
                        </td>
                        <td align="right" style="padding:6px 0; border-bottom:1px solid #f3f4f6; color:#111827;">
                            {{ $item->qty }}
                        </td>
                        <td align="right" style="padding:6px 0; border-bottom:1px solid #f3f4f6; color:#111827;">
                            {{ number_format($item->total_price, 0, ',', ' ') }} {{ $order->currency }}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <table width="100%" cellpadding="0" cellspacing="0" style="font-size:13px; margin-top:10px;">
                <tr>
                    <td align="left" style="padding:2px 0; color:#6b7280;">Sous-total</td>
                    <td align="right" style="padding:2px 0; color:#111827;">
                        {{ number_format($order->subtotal, 0, ',', ' ') }} {{ $order->currency }}
                    </td>
                </tr>
                @if($order->discount > 0)
                    <tr>
                        <td align="left" style="padding:2px 0; color:#6b7280;">Remise</td>
                        <td align="right" style="padding:2px 0; color:#16a34a;">
                            -{{ number_format($order->discount, 0, ',', ' ') }} {{ $order->currency }}
                        </td>
                    </tr>
                @endif
                @if($order->tax > 0)
                    <tr>
                        <td align="left" style="padding:2px 0; color:#6b7280;">Taxes</td>
                        <td align="right" style="padding:2px 0; color:#111827;">
                            {{ number_format($order->tax, 0, ',', ' ') }} {{ $order->currency }}
                        </td>
                    </tr>
                @endif
                <tr>
                    <td align="left" style="padding-top:6px; border-top:1px solid #e5e7eb; font-weight:600; color:#111827;">
                        Total
                    </td>
                    <td align="right" style="padding-top:6px; border-top:1px solid #e5e7eb; font-weight:700; color:#111827;">
                        {{ number_format($order->total, 0, ',', ' ') }} {{ $order->currency }}
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <tr>
        <td style="padding:0 24px 16px;">
            <h2 style="margin:0 0 8px; font-size:15px; color:#111827;">Infos paiement</h2>

            <p style="margin:0 0 4px; font-size:13px; color:#374151;">
                Montant soumis : <strong>{{ number_format($payment->amount, 0, ',', ' ') }} {{ $payment->currency }}</strong>
            </p>
            @if($payment->transaction_number)
                <p style="margin:0 0 2px; font-size:13px; color:#6b7280;">
                    Référence transaction : <strong>{{ $payment->transaction_number }}</strong>
                </p>
            @endif
            <p style="margin:0 0 2px; font-size:12px; color:#9ca3af;">
                Soumis le : {{ $payment->created_at?->format('d/m/Y H:i') }}
            </p>
        </td>
    </tr>

</table>

<p style="max-width:620px; margin:12px auto 0; font-size:11px; color:#9ca3af; text-align:center;">
    Cet email est destiné à l’équipe organisatrice. Ne pas transférer au client sans vérification préalable.
</p>
</body>
</html>
