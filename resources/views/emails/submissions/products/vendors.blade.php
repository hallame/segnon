<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $data['status'] == 'approved' ? '✅ Publié !' : '⚠️ Action requise' }} - {{ config('app.name') }}</title>
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
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
        }


        .logo {
            color: white;
            font-size: 28px;
            font-weight: 700;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 16px;
        }


        /* Main Content */
        .content {
            padding: 40px 32px;
        }

        .greeting {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 24px;
            color: #111827;
            padding: 5px;
        }

        .greeting-name {
            color: #166534;
        }

        /* Status Card */
        .status-card {
            background: {{ $data['status'] == 'approved' ? '#f0fdf4' : '#fef2f2' }};
            border: 1px solid {{ $data['status'] == 'approved' ? '#bbf7d0' : '#fecaca' }};
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 32px;
            text-align: center;
        }

        .status-icon {
            font-size: 48px;
            margin-bottom: 8px;
            display: block;
        }

        .status-title {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 8px;
            color: {{ $data['status'] == 'approved' ? '#166534' : '#dc2626' }};
        }

        .status-message {
            color: #4b5563;
            font-size: 16px;
            line-height: 1.5;
        }

        /* Product Details */
        .details-card {
            background: #f8fafc;
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 32px;
            border: 1px solid #e2e8f0;
        }

        .details-title {
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #166534;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .details-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
        }

        .detail-item {
            padding: 12px;
            background: white;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
        }

        .detail-label {
            font-size: 12px;
            color: #6b7280;
            font-weight: 500;
            margin-bottom: 4px;
            display: block;
        }

        .detail-value {
            font-size: 14px;
            font-weight: 600;
            color: #111827;
        }

        /* Comment Section */
        .comment-section {
            margin-bottom: 32px;
            padding: 5px;
        }

        .comment-title {
            font-size: 16px;
            font-weight: 600;
            color: #111827;
            margin-bottom: 12px;
        }

        .comment-box {
            background: #fff7ed;
            border-left: 4px solid #f97316;
            padding: 16px;
            border-radius: 8px;
            font-size: 14px;
            line-height: 1.5;
            color: #7c2d12;
        }

        /* CTA Button */
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #166534 0%, #0f4d2a 100%);
            color: #fff;
            text-decoration: none;
            padding: 16px 32px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 16px;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(22, 101, 52, 0.2);
            margin: 24px 0;
        }

        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(22, 101, 52, 0.3);
        }

        /* Steps */
        .steps-section {
            margin: 32px 0;
        }

        .steps-title {
            font-size: 16px;
            font-weight: 600;
            color: #111827;
            margin-bottom: 16px;
            padding: 5px;
        }

        .steps-list {
            list-style: none;
            padding-left: 0;
        }

        .step-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 16px;
            padding: 16px;
            background: #f8fafc;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
        }
        .step-text {
            font-size: 14px;
            color: #4b5563;
            line-height: 1.5;
        }

        /* Footer */
        .footer {
            padding: 12px;
            background: #111827;
            color: #9ca3af;
            text-align: center;
            border-radius: 24px 24px 0 0;
        }

        .footer-links {
            display: flex;
            justify-content: center;
            gap: 24px;
            margin-bottom: 20px;
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
        }

        /* Responsive */
        @media (max-width: 640px) {
            .content {
                padding: 24px 16px;
            }


            .status-card {
                padding: 20px;
            }

            .details-grid {
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

        <!-- Main Content -->
        <div class="content">
            <!-- Greeting -->
            <div class="greeting">
                Cher(e) <span class="greeting-name">{{ $data['owner_name'] ?? 'Partenaire' }}</span>,
            </div>

            <!-- Status Card -->
            <div class="status-card">
                @if($data['status'] == 'approved')
                <div class="status-icon">🎉</div>
                <h2 class="status-title">Produit approuvé !</h2>
                <p class="status-message">
                    Votre produit a été validé par notre équipe et est désormais visible au public.
                </p>
                @else
                <div class="status-icon">⚠️</div>
                <h2 class="status-title">Modifications requises</h2>
                <p class="status-message">
                    Votre produit nécessite des modifications avant publication.
                </p>
                @endif
            </div>

            <!-- Product Details -->
            <div class="details-card">
                <div class="details-title">
                    📋 Détails du produit
                </div>
                <div class="details-grid">
                    <div class="detail-item">
                        <span class="detail-label">Nom du produit</span>
                        <span class="detail-value">{{ $data['product_name'] }}</span>
                    </div>

                    @if($data['sku'])
                    <div class="detail-item">
                        <span class="detail-label">Référence</span>
                        <span class="detail-value">{{ $data['sku'] }}</span>
                    </div>
                    @endif

                    <div class="detail-item">
                        <span class="detail-label">Date de soumission</span>
                        <span class="detail-value">{{ $data['submitted_at']->format('d/m/Y à H:i') }}</span>
                    </div>

                    @if($data['reviewed_at'])
                    <div class="detail-item">
                        <span class="detail-label">Date de modération</span>
                        <span class="detail-value">{{ $data['reviewed_at']->format('d/m/Y à H:i') }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Comment Section (only for rejected) -->
            @if($data['status'] == 'rejected' && $data['comment'])
            <div class="comment-section">
                <div class="comment-title">Commentaire du modérateur</div>
                <div class="comment-box">
                    {{ $data['comment'] }}
                </div>
            </div>
            @endif

            <!-- Next Steps -->
            <div class="steps-section">
                <div class="steps-title">
                    @if($data['status'] == 'approved')
                    ✅ Prochaines étapes
                    @else
                    🔧 Étapes à suivre
                    @endif
                </div>

                <ul class="steps-list">
                    @if($data['status'] == 'approved')
                        <li class="step-item">
                            <div class="step-text">
                                <strong>🌐 Votre produit est maintenant public</strong> – visible par tous les visiteurs et acheteurs
                            </div>
                        </li>
                        <li class="step-item">
                            <div class="step-text">
                                <strong>🔗 Partagez votre produit</strong> – utilisez le lien unique de votre catalogue pour promouvoir vos articles
                            </div>
                        </li>

                        <li class="step-item">
                            <div class="step-text">
                                <strong>📊 Gévez votre stock</strong> – mettez à jour les quantités régulièrement pour éviter les ruptures
                            </div>
                        </li>
                    @else
                        <li class="step-item">
                            <div class="step-text">Connectez-vous à votre espace vendeur</div>
                        </li>
                        <li class="step-item">
                            <div class="step-text">Consultez le commentaire du modérateur</div>
                        </li>
                        <li class="step-item">
                            <div class="step-text">Apportez les corrections nécessaires à votre produit</div>
                        </li>
                        <li class="step-item">
                            <div class="step-text">Soumettez à nouveau votre produit pour validation</div>
                        </li>
                    @endif
                </ul>
            </div>

            <!-- CTA Button -->
            <div style="text-align: center;">
                <a href="{{ route('partners.shop.products.index') }}" class="cta-button">
                    📦 Accéder à mes produits
                </a>
            </div>

            <!-- Help Section -->
            <div style="margin-top: 40px; padding: 20px; background: #f0f9ff; border-radius: 12px; border: 1px solid #bae6fd;">
                <div style="font-size: 16px; font-weight: 600; color: #0369a1; margin-bottom: 12px;">
                    📞 Besoin d'aide ?
                </div>
                <div style="font-size: 14px; color: #4b5563; line-height: 1.5;">
                    Notre équipe support est disponible pour vous accompagner.
                    <br>
                    <strong>Email :</strong> {{ config('mail.support_email', 'support@mylmark.com') }}
                    <br>
                    <strong>Centre d'aide :</strong> <a href="{{ route('contact') }}" style="color: #166534;">NOUS CONTACTER</a>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="copyright">
                © {{ date('Y') }} {{ config('app.name') }}. Tous droits réservés.
            </div>
        </div>
    </div>
</body>
</html>
