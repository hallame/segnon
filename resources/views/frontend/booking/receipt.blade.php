<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Reçu de Réservation</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #333;
            font-size: 13px;
            background: #f4f4f4;
            padding: 40px;
            margin: 0;
        }

        .receipt-container {
            background: #fff;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 0 10px rgba(0,0,0,0.06);
        }

        .header {
            margin-bottom: 30px;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        .header-table td {
            vertical-align: top;
            padding: 0;
        }
        .header-left {
            text-align: left;
        }
        .header-right {
            text-align: right;
            white-space: nowrap;
            border: #0f766e;
        }
        .qr-caption {
            font-size: 11px;
            margin-top: 4px;
            color: #666;
        }
        .header .title {
            font-size: 22px;
            font-weight: bold;
            color: #0f766e;
            margin: 6px 0 4px;
        }
        .header .reference {
            color: #666;
            font-size: 14px;
        }
        .logo {
            width: 90px;
            margin-bottom: 4px;
        }
        .header-sep {
            border-bottom: 1px solid #e0e0e0;
            margin-top: 8px;
        }

        .logo {
            width: 90px;
            margin-bottom: 10px;
        }

        .title {
            font-size: 22px;
            font-weight: bold;
            color: #0f766e;
            margin-bottom: 5px;
        }

        .reference {
            color: #666;
            font-size: 14px;
        }

        h3 {
            color: #0f766e;
            font-size: 16px;
            margin-bottom: 10px;
            border-bottom: 1px solid #e0e0e0;
            padding-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        th, td {
            padding: 8px 10px;
            text-align: left;
        }

        .label {
            background-color: #f9fafb;
            font-weight: bold;
            width: 40%;
            color: #444;
            border-bottom: 1px solid #e6e6e6;
        }

        .value {
            border-bottom: 1px solid #e6e6e6;
        }

        .amount-box {
            text-align: right;
            font-size: 16px;
            font-weight: bold;
            color: #0f766e;
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px dashed #ccc;
        }

        .note {
            background: #f1f5f9;
            border-left: 4px solid #0f766e;
            padding: 10px 15px;
            margin-top: 15px;
            color: #555;
            font-style: italic;
            border-radius: 5px;
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 12px;
            color: #999;
        }
    </style>
</head>
<body>

    <div class="receipt-container">
        {{-- En-tête --}}
        <div class="header">
            <table class="header-table">
                <tr>
                <td class="header-left">
                    <img src="{{ asset('assets/front/images/logo.jpg') }}" class="logo" alt="ZALY MERVEILLE">
                    <div class="title">Reçu de Réservation</div>
                    <div class="reference">Référence : #{{ $booking->reference }}</div>
                </td>
                <td class="header-right">

                    <img src="data:image/png;base64,{{ $qrPng }}" alt="QR Code"
                        style="width:80px; height:80px; display:inline-block; background:#fff;
                            border:2px solid #0f766e; border-radius:12px; padding:2px;
                            box-shadow:0 2px 6px rgba(0,0,0,0.15);"
                    >
                    <div class="qr-caption">Scannez pour plus de détail</div>
                </td>
                </tr>
            </table>
            <div class="header-sep"></div>
        </div>


        {{-- Informations Client --}}
        <h3>Coordonnées</h3>
        <table>
            <tr>
                <td class="label">Nom</td>
                <td class="value">{{ $client->firstname }} {{ $client->lastname }}</td>
            </tr>
            <tr>
                <td class="label">Email</td>
                <td class="value">{{ $client->email }}</td>
            </tr>
            <tr>
                <td class="label">Téléphone</td>
                <td class="value">{{ $client->phone }}</td>
            </tr>
        </table>

        {{-- Informations Réservation --}}
        <h3>Détails</h3>
        <table>
            <tr>
                <td class="label">Type</td>
                <td class="value">
                    @switch($booking->bookable_type)
                        @case(\App\Models\Room::class) Chambre @break
                        @case(\App\Models\Event::class) Événement @break
                        @case(\App\Models\Site::class) Site touristique @break
                        @case(\App\Models\Circuit::class) Circuit @break
                        @case(\App\Models\Museum::class) Musée @break
                        @default Autre
                    @endswitch
                </td>
            </tr>
            <tr>
                <td class="label">Dates</td>
                <td class="value">Du {{ $booking->check_in->format('d/m/Y') }} au {{ $booking->check_out->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td class="label">Nombre de personnes</td>
                <td class="value">{{ $booking->guests }}</td>
            </tr>
            <tr>
                <td class="label">Moyen de paiement</td>
                <td class="value">{{ ucfirst($booking->payment_method) }}</td>
            </tr>
            <tr>
                <td class="label">Statut du paiement</td>
                <td class="value">
                    @switch($booking->payment_status)
                        @case(0) Non payé @break
                        @case(1) En attente de vérification @break
                        @case(2) Payé @break
                        @case(3) Rejeté @break
                        @default —
                    @endswitch
                </td>
            </tr>
        </table>

        {{-- Montant total --}}
        <div class="amount-box">
            Montant total : {{ number_format($booking->amount, 0, '', ' ') }} {{ $currency ?? 'XOF' }}
        </div>

        {{-- Note --}}
        @if ($booking->note)
            <div class="note">
                {{ $booking->note }}
            </div>
        @endif


        {{-- Pied de page --}}
        <div class="footer">
            Merci pour votre confiance.<br>
            Zaly Merveille &copy; {{ now()->year }}
        </div>
    </div>
</body>
</html>
