<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🚨 Nouvelle soumission à modérer - {{ config('app.name') }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Lexend', 'system-ui', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            line-height: 1.6;
            color: #111827;
            background-color: #f9fafb;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .email-container {
            max-width: 640px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(15, 23, 42, 0.12);
        }

        /* Header Urgent */
        .header {
            background: #01230e;
            padding: 32px 24px;
            text-align: center;
            position: relative;
        }

        .header::before {
            content: '🚨';
            font-size: 48px;
            position: absolute;
            top: 20px;
            right: 20px;
            opacity: 0.3;
        }

        .header-title {
            color: #f3eeee;
            font-size: 14px;
            font-weight: 500;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        /* Badge Priorité */
        .priority-badge {
            display: inline-block;
            background: #fef3c7;
            color: #92400e;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-top: 16px;
            border: 2px solid #fbbf24;
        }

        /* Main Content */
        .content {
            padding: 40px 32px;
        }

        /* Info Card */
        .info-card {
            background: #f8fafc;
            border-radius: 16px;
            padding: 28px;
            margin-bottom: 32px;
            border: 2px solid #e2e8f0;
        }

        .card-title {
            font-size: 16px;
            font-weight: 700;
            color: #166534;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
        }

        .info-item {
            padding: 16px;
            background: white;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            transition: all 0.2s ease;
        }

        .info-item:hover {
            border-color: #166534;
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(22, 101, 52, 0.08);
        }

        .info-label {
            font-size: 12px;
            color: #6b7280;
            font-weight: 500;
            margin-bottom: 6px;
            display: block;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .info-value {
            font-size: 15px;
            font-weight: 600;
            color: #111827;
        }

        .info-value.highlight {
            color: #166534;
            background: #f0fdf4;
            padding: 4px 10px;
            border-radius: 6px;
            display: inline-block;
        }

        /* CTA Button */
        .cta-button {
            display: inline-block;
            background: #166534;
            color: white;
            text-decoration: none;
            padding: 18px 36px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 16px;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 6px 20px rgba(220, 38, 38, 0.25);
            margin: 24px 0;
            border: none;
            cursor: pointer;
        }

        .cta-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(220, 38, 38, 0.35);
        }

        /* Quick Actions */
        .quick-actions {
            margin: 32px 0;
            padding: 24px;
            background: #fef3c7;
            border-radius: 16px;
            border: 2px solid #fbbf24;
        }

        .actions-title {
            font-size: 16px;
            font-weight: 700;
            color: #92400e;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 12px;
        }

        .action-button {
            display: block;
            padding: 12px 16px;
            background: white;
            border-radius: 10px;
            text-decoration: none;
            color: #111827;
            font-size: 14px;
            font-weight: 600;
            text-align: center;
            border: 1px solid #e5e7eb;
            transition: all 0.2s ease;
        }

        .action-button:hover {
            background: #166534;
            color: white;
            border-color: #166534;
        }

        /* Footer */
        .footer {
            padding: 32px;
            background: #111827;
            color: #9ca3af;
            text-align: center;
            border-radius: 20px 20px 0 0;
        }

        .footer-links {
            display: flex;
            justify-content: center;
            gap: 24px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .footer-link {
            color: #d1d5db;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.2s;
        }

        .footer-link:hover {
            color: white;
        }

        .copyright {
            font-size: 13px;
            color: #9ca3af;
            margin-top: 5px;
            line-height: 1.5;
        }

        /* Responsive */
        @media (max-width: 640px) {
            .content {
                padding: 24px 16px;
            }

            .header {
                padding: 24px 16px;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .actions-grid {
                grid-template-columns: 1fr;
            }

            .footer-links {
                flex-direction: column;
                gap: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header Urgent -->
        <div class="header">
            <div class="header-title">Notification Modération</div>
            <div class="priority-badge">Action requise • Nouvelle soumission</div>
        </div>

        <!-- Main Content -->
        <div class="content">

            <!-- Carte d'informations -->
            <div class="info-card">
                <div class="card-title">
                    📋 Informations de la soumission
                </div>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Type de contenu</span>
                        <span class="info-value highlight">{{ $modelName }}</span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">Opération</span>
                        <span class="info-value" style="color: #dc2626; font-weight: 700;">
                            {{ ucfirst($submission->operation) }}
                        </span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">Utilisateur</span>
                        <span class="info-value">{{ $userName }}</span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">Compte</span>
                        <span class="info-value">{{ $submission->account->name ?? 'N/A' }}</span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">Date</span>
                        <span class="info-value">{{ $submission->submitted_at->format('d/m/Y à H:i') }}</span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">ID Soumission</span>
                        <span class="info-value">#{{ $submission->id }}</span>
                    </div>
                </div>
            </div>

            <!-- Bouton d'action principal -->
            <div style="text-align: center;">
                <a href="{{ route('admin.submissions.show', $submission) }}" class="cta-button">
                    👁️ Examiner cette soumission
                </a>
            </div>

            <!-- Actions rapides -->
            <div class="quick-actions">
                <div class="actions-title">⚡ Actions rapides</div>
                <div class="actions-grid">
                    <a href="{{ route('admin.submissions.show', $submission) }}" class="action-button">
                        📝 Voir les détails
                    </a>
                    <a href="{{ route('admin.submissions.index', ['status' => 'pending']) }}" class="action-button">
                        📋 Toutes les soumissions
                    </a>

                </div>
            </div>

        </div>
        <!-- Footer -->
        <div class="footer">
            <div class="copyright">
                © {{ date('Y') }} {{ config('app.name') }} • Tous droits réservés.
            </div>
        </div>
    </div>
</body>
</html>
