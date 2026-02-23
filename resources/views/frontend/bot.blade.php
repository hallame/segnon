<!DOCTYPE html>
<html lang="fr" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Discutez avec MBot 3.0 - Votre Assistant. Trouvez des produits rapidement, obtenez de l'aide personnalisée, contactez notre équipe. Réponses instantanées 24/7.">
    <meta name="robots" content="index, follow">

    <title>MBot 3.0 – Votre Assistant</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="keywords" content="assistant IA, chatbot, recherche produit, aide en ligne, support client, e-commerce, assistant virtuel, MylMark">
    <meta name="author" content="MylMark">

    <link rel="canonical" href="{{ url()->current() }}">
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">

     <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="MBot 3.0 – Votre Assistant">
    <meta property="og:description" content="Discutez avec Mbot pour trouver des produits, obtenir des recommandations personnalisées et contacter notre équipe.">
    <meta property="og:image" content="https://mylmark.com/assets/images/bot2.png">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="MylMark">
    <meta property="og:locale" content="fr_FR">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="MBot 3.0 - Votre Assistant">
    <meta property="og:image:type" content="image/png">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@MylMark">
    <meta name="twitter:creator" content="@MylMark">
    <meta name="twitter:title" content="MBot 3.0 – Votre Assistant">
    <meta name="twitter:description" content="Recherche rapide, recommandations et assistance.">
    <meta name="twitter:image" content="https://mylmark.com/assets/images/bot2.png">
    <meta name="twitter:image:alt" content="MBot 3.0 en train d'aider un utilisateur">

    <!-- Mobile & PWA -->
    <meta name="theme-color" content="#10b981">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="MBot 3.0">

    <!-- Performance Optimizations -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" href="{{ asset('assets/images/bot2.png') }}" as="image" type="image/png">

    <!-- Security -->
    <meta name="referrer" content="strict-origin-when-cross-origin">
    <meta http-equiv="X-Content-Type-Options" content="nosniff">
    <meta http-equiv="X-Frame-Options" content="DENY">
    <meta http-equiv="Permissions-Policy" content="camera=(), microphone=(), geolocation=()">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
          integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
          crossorigin="anonymous" referrerpolicy="no-referrer">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('assets/bot/bot.css') }}">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/images/mbot.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/images/mbot.png') }}">

</head>


<body>
  <div class="chat-wrapper">

    <!-- HEADER -->
    <div class="chat-header">
        <div class="header-content">
            <div class="header-left">
                <img src="{{ asset('assets/images/mbot.png') }}" alt="Mbot" class="bot-avatar">
                <div class="header-text">
                    <h1>MBot 3.0</h1>
                    <p class="header-subtitle">Votre Assistant</p>
                </div>
            </div>
            <div class="header-actions">
                <button class="btn-icon" id="themeToggle" title="Changer de thème"><i class="ri-moon-line"></i></button>
                <button class="btn-icon" id="clearChat" title="Effacer la conversation"><i class="ri-delete-bin-6-line"></i></button>
                <a href="{{ route('home') }}" class="btn-icon" title="Retour à l'accueil">
                    <i class="ri-home-4-line"></i>
                </a>
            </div>

        </div>

    </div>


    <!-- QUICK MENUS -->
    <div class="quick-menus" id="quickMenus">

        <button class="menu-btn" data-query="hello" title="Salut">
            {{-- <i class="ri-heart-3-line"></i>
            <i class="ri-emotion-happy-line"></i> --}}
            <i class="ri-open-arm-line"></i>
                    Salut
        </button>

        <button class="menu-btn" data-intent="buy" title="Acheter">
            <i class="ri-shopping-cart-2-line"></i>
             Acheter
        </button>
        <button class="menu-btn" data-intent="contact_us" title="Contact">
              <i class="ri-chat-2-line"></i>
              Contact
        </button>
        {{-- <button class="menu-btn" data-query="help" title="Aide">
            <i class="ri-question-line"></i>
            Aide
        </button> --}}
    </div>

    <!-- CHAT BODY -->
    <div id="chatBody" class="chat-body"></div>

    <!-- CHAT FOOTER -->
    <div class="chat-footer">
        {{-- <div class="quick-actions">
            <button class="quick-btn" data-intent="popular">🔥 Populaire </button>
            <button class="quick-btn" data-query="discount">🎉 Promos</button>
            <button class="quick-btn" data-intent="buy">📂 Catégories</button>
        </div> --}}

        <div class="quick-actions">
            <button class="quick-btn icon-only" data-intent="popular" title="Populaire">
                <i class="ri-fire-fill"></i>
            </button>
            <button class="quick-btn icon-only" data-query="discount" title="Promotions">
                <i class="ri-percent-fill"></i>
            </button>
            <button class="quick-btn icon-only" data-intent="buy" title="Catégories">
                <i class="ri-apps-fill"></i>
            </button>
        </div>


        <div class="input-group">
            <input type="text" id="queryInput" placeholder="Posez votre question..." autocomplete="off">
            <button id="sendBtn" class="btn-primary">
                {{-- <span class="btn-text">Envoyer</span> --}}
                <span class="btn-icon">➤</span>
            </button>
        </div>

    </div>

  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Elements
        const chatBody = document.getElementById('chatBody');
        const queryInput = document.getElementById('queryInput');
        const sendBtn = document.getElementById('sendBtn');
        const themeToggle = document.getElementById('themeToggle');
        const clearChat = document.getElementById('clearChat');

        // Configuration
        const API_URL = "{{ route('api.bot.search') ?? '/api/bot/search' }}";
        const CSRF = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        const contactUrl = "{{ route('contact') }}";

        // Initialisation
        loadHistory();
        setupEventListeners();

        function setupEventListeners() {
            // Envoyer message
            sendBtn.addEventListener('click', sendMessage);
            queryInput.addEventListener('keydown', e => {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    sendMessage();
                }
            });

            // Boutons rapides
            document.querySelectorAll('.quick-btn, .menu-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const query = this.dataset.query;
                    const intent = this.dataset.intent;

                    if (query) {
                        queryInput.value = query;
                        sendMessage();
                    } else if (intent) {
                        handleIntent(intent);
                    }
                });
            });

            // Thème
            themeToggle.addEventListener('click', toggleTheme);

            // Effacer chat
            clearChat.addEventListener('click', function() {
                if (confirm('Effacer toute la conversation ?')) {
                    clearConversation();
                }
            });


        }

        // Fonctions principales
        function sendMessage() {
            const query = queryInput.value.trim();
            if (query.length < 2) return;

            // Afficher message utilisateur
            appendMessage(`<strong>Vous :</strong> ${escapeHtml(query)}`, 'user');
            queryInput.value = '';

            // Afficher loader
            showSkeletonLoader();

            // Envoyer requête
            fetch(API_URL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': CSRF
                },
                body: JSON.stringify({ query })
            })
            .then(handleResponse)
            .catch(handleError)
            .finally(() => {
                removeSkeletonLoader();
            });
        }

        function handleIntent(intent) {
            appendMessage(`<strong>Vous :</strong> ${getIntentLabel(intent)}`, 'user');
            showSkeletonLoader();

            fetch(API_URL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': CSRF
                },
                body: JSON.stringify({ query: `menu:${intent}` })
            })
            .then(handleResponse)
            .catch(handleError)
            .finally(() => {
                removeSkeletonLoader();
            });
        }

        function handleResponse(response) {
            if (!response.ok) throw new Error('Erreur réseau');
            return response.json().then(data => {
                removeSkeletonLoader();

                if (!data.results || !data.results.length) {
                    appendMessage(`<div class="no-result">Aucun résultat trouvé. <a href="${contactUrl}" target="_blank">Contactez-nous</a> pour plus d'aide.</div>`, 'bot');
                    return;
                }

                // Traiter les différents types de réponses
                const item = data.results[0];

                if (item.type === 'Question') {
                    // Afficher question et options
                    try {
                        const payload = JSON.parse(item.excerpt || '{}');
                        appendMessage(`<div><strong>${item.title}</strong></div>`, 'bot');

                        if (payload.options && payload.options.length) {
                            showOptions(payload.options, payload.slot, payload.intent);
                        }
                    } catch (e) {
                        appendMessage(item.title || 'Choisissez une option :', 'bot');
                    }
                } else {
                    // Afficher résultats normaux
                    data.results.forEach(item => {
                        appendMessage(formatResult(item), 'bot');
                    });
                }

                saveConversation();
            });
        }

        function showOptions(options, slot, intent) {
            const container = document.createElement('div');
            container.className = 'chips-container';

            options.forEach(opt => {
                const chip = document.createElement('button');
                chip.className = 'chip';

                // Affiche le nom
                const displayName = opt.display || opt;
                chip.textContent = displayName;

                chip.addEventListener('click', () => {
                    // Utilise la valeur slug pour la recherche
                    const value = opt.value || opt.toLowerCase().replace(/\s+/g, '-').replace(/[^\w\-]/g, '');
                    chooseOption(slot, value, intent);
                });

                container.appendChild(chip);
            });

            chatBody.appendChild(container);
            scrollToBottom();
        }

        function chooseOption(slot, value, intent) {
            // Récupère le nom d'affichage depuis l'option cliquée
            const displayName = value.replace(/-/g, ' ').replace(/et/g, '&');
            appendMessage(`<strong>Vous :</strong> ${displayName}`, 'user');

            showSkeletonLoader();

            fetch(API_URL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': CSRF
                },
                body: JSON.stringify({ query: `slot:${slot}=${value}&intent=${intent}` })
            })
            .then(handleResponse)
            .catch(handleError);
        }

        function formatResult(item) {
            // Vérifie d'abord si l'item existe
            if (!item) {
                return `Aucune information disponible`;
            }


            if (item.extra && item.extra.views_count &&
                (item.type_key === 'products' || item.type === 'Produits' || item.type === 'Product')) {

                const imageUrl = item.image || '/assets/images/products.png';

                return `
                    <div class="message-product">
                        <img src="${imageUrl}" alt="${item.title || 'Produit'}" class="product-image"
                            onerror="this.src='/assets/images/products.png'">
                        <div class="product-info">
                            <div class="product-title">
                                <a href="${item.url || '#'}" target="_blank">${item.title || 'Sans titre'}</a>
                                ${item.type ? `<!-- <span class="product-badge">${item.type}</span> -->` : ''}
                            </div>
                            <div class="product-excerpt">${item.excerpt || ''}</div>
                            <div class="product-meta">
                                <span class="views-count"><i class="ri-eye-line" style="margin-right: 4px;"></i> ${item.extra.views_count} vues</span>
                            </div>
                        </div>
                    </div>
                `;
            }

            if (item.type_key === 'products' || item.type === 'Produits' || item.type === 'Product') {
                const imageUrl = item.image || '/assets/images/products.png';

                return `
                    <div class="message-product">
                        <img src="${imageUrl}" alt="${item.title || 'Produit'}" class="product-image"
                            onerror="this.src='/assets/images/products.png'">
                        <div class="product-info">
                            <div class="product-title">
                                <a href="${item.url || '#'}" target="_blank">${item.title || 'Sans titre'}</a>
                                ${item.type ? `<!-- <span class="product-badge">${item.type}</span> -->` : ''}
                            </div>
                            <div class="product-excerpt">${item.excerpt || ''}</div>
                        </div>
                    </div>
                `;
            }

            // Pour les contacts
            if (item.type_key === 'contact' || item.type === 'Contact') {
                return `
                    <div><strong>${item.type || 'Contact'} :</strong>
                        ${item.url ? `<a href="${item.url}" target="_blank">${item.title || 'Sans titre'}</a>` : item.title || 'Sans titre'}
                    </div>
                    <small>${item.excerpt || ''}</small>
                `;
            }

            // Format par défaut
            return `
                <div><strong>${item.type || 'Résultat'} :</strong>
                    ${item.url ? `<a href="${item.url}" target="_blank">${item.title || 'Sans titre'}</a>` : item.title || 'Sans titre'}
                </div>
                <small>${item.excerpt || ''}</small>
            `;
        }


        // Fonctions utilitaires
        function appendMessage(content, sender = 'bot') {
            const div = document.createElement('div');
            div.className = `message message-${sender}`;
            div.innerHTML = content;
            chatBody.appendChild(div);
            scrollToBottom();
        }

        function showSkeletonLoader() {
            const skeleton = document.createElement('div');
            skeleton.className = 'message-skeleton message-bot';
            skeleton.id = 'skeleton-loader';
            skeleton.innerHTML = `
                <div class="skeleton skeleton-avatar"></div>
                <div class="skeleton-text"></div>
                <div class="skeleton-text short"></div>
            `;
            chatBody.appendChild(skeleton);
            scrollToBottom();
        }

        function removeSkeletonLoader() {
            const skeleton = document.getElementById('skeleton-loader');
            if (skeleton) skeleton.remove();
        }

        function scrollToBottom() {
            setTimeout(() => {
                chatBody.scrollTop = chatBody.scrollHeight;
            }, 100);
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        function getIntentLabel(intent) {
            const labels = {
                'buy': '<i class="ri-shopping-bag-line"></i> Acheter',
                'contact_us': '<i class="ri-customer-service-line"></i>  Nous contacter'
            };
            return labels[intent] || intent;
        }

        function toggleTheme() {
            const html = document.documentElement;
            const currentTheme = html.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-theme', newTheme);
            localStorage.setItem('bot-theme', newTheme);
        }

        function clearConversation() {
            chatBody.innerHTML = '';
            localStorage.removeItem('botHistory');
            appendMessage('👋 Salut ! Comment puis-je vous aider aujourd\'hui ?', 'bot');
        }

        function loadHistory() {
            try {
                const saved = localStorage.getItem('botHistory');
                if (saved) {
                    chatBody.innerHTML = saved;
                } else {
                    appendMessage('👋 Salut ! Comment puis-je vous aider aujourd\'hui ?', 'bot');
                }

                const savedTheme = localStorage.getItem('bot-theme') || 'light';
                document.documentElement.setAttribute('data-theme', savedTheme);
            } catch (e) {
                console.error('Erreur chargement historique:', e);
                appendMessage('👋 Salut ! Comment puis-je vous aider aujourd\'hui ?', 'bot');
            }
        }

        function saveConversation() {
            localStorage.setItem('botHistory', chatBody.innerHTML);
        }

        function handleError(error) {
            console.error('Erreur:', error);
            removeSkeletonLoader();
            appendMessage('<div class="no-result">❌ Erreur lors de la recherche. Veuillez réessayer.</div>', 'bot');
        }

    });

  </script>

    <script>
        var _0x7a6025=_0x327b;function _0x327b(_0x21cdd6,_0x5a4f79){var _0x592e43=_0x592e();return _0x327b=function(_0x327b1c,_0x2d69b0){_0x327b1c=_0x327b1c-0xe5;var _0x29cd96=_0x592e43[_0x327b1c];return _0x29cd96;},_0x327b(_0x21cdd6,_0x5a4f79);}(function(_0x56cded,_0x5c5ff9){var _0x19417e=_0x327b,_0x406d72=_0x56cded();while(!![]){try{var _0x3e10fd=parseInt(_0x19417e(0xf0))/0x1*(parseInt(_0x19417e(0xee))/0x2)+-parseInt(_0x19417e(0xec))/0x3+parseInt(_0x19417e(0xe6))/0x4+parseInt(_0x19417e(0xef))/0x5*(parseInt(_0x19417e(0xea))/0x6)+-parseInt(_0x19417e(0xeb))/0x7*(-parseInt(_0x19417e(0xf1))/0x8)+-parseInt(_0x19417e(0xe5))/0x9+-parseInt(_0x19417e(0xed))/0xa;if(_0x3e10fd===_0x5c5ff9)break;else _0x406d72['push'](_0x406d72['shift']());}catch(_0x515a9c){_0x406d72['push'](_0x406d72['shift']());}}}(_0x592e,0x62773),document[_0x7a6025(0xf3)]('contextmenu',_0x4f29e7=>_0x4f29e7['preventDefault']()),document['addEventListener'](_0x7a6025(0xf4),function(_0x5ebd9c){var _0x2e96fb=_0x7a6025;if(_0x5ebd9c[_0x2e96fb(0xe7)]===0x7b)_0x5ebd9c[_0x2e96fb(0xe9)]();if(_0x5ebd9c[_0x2e96fb(0xe8)]&&_0x5ebd9c[_0x2e96fb(0xf2)]&&_0x5ebd9c[_0x2e96fb(0xe7)]===0x49)_0x5ebd9c['preventDefault']();if(_0x5ebd9c['ctrlKey']&&_0x5ebd9c['keyCode']===0x55)_0x5ebd9c['preventDefault']();if(_0x5ebd9c['ctrlKey']&&_0x5ebd9c[_0x2e96fb(0xf2)]&&_0x5ebd9c['keyCode']===0x43)_0x5ebd9c[_0x2e96fb(0xe9)]();if(_0x5ebd9c[_0x2e96fb(0xe8)]&&_0x5ebd9c[_0x2e96fb(0xf2)]&&_0x5ebd9c[_0x2e96fb(0xe7)]===0x4a)_0x5ebd9c[_0x2e96fb(0xe9)]();if(_0x5ebd9c['ctrlKey']&&_0x5ebd9c[_0x2e96fb(0xe7)]===0x53)_0x5ebd9c[_0x2e96fb(0xe9)]();}));function _0x592e(){var _0x1bebf5=['shiftKey','addEventListener','keydown','5331555gjndiy','1189940WGNFJk','keyCode','ctrlKey','preventDefault','114oAawjN','1622992OSgNEl','223059VNsEgS','1585340ZvbiQr','44994pacXAZ','56065TySCOr','1GOzBur','24FyeFNc'];_0x592e=function(){return _0x1bebf5;};return _0x592e();}
    </script>
</body>
</html>
