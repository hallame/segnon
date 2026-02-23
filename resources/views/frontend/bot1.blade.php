<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- SEO minimal — INSERE dans <head> -->
    <meta name="description" content="MBot 3.0 — assistant IA pour trouver des sites, réserver des chambres, explorer la culture et contacter l'équipe. Recherche rapide et recommandations.">
    <link rel="canonical" href="{{ url()->current() }}">
    <!-- Robots -->
    <meta name="robots" content="index, follow">
    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="MBot 3.0 – Votre Assistant IA">
    <meta property="og:description" content="MBot 3.0 — assistant IA pour trouver des sites, réserver des chambres, explorer la culture et contacter l'équipe.">
    {{-- <meta property="og:image" content="{{ url('assets/images/mbot.png') }}"> --}}
    <meta property="og:image" content="https://mylmark.com/assets/images/mbot.png">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="MBot 3.0 – Votre Assistant IA">
    <meta name="twitter:description" content="Recherche rapide, recommandations et assistance pour vos voyages et réservations.">
    {{-- <meta name="twitter:image" content="{{ url('assets/images/mbot.png') }}"> --}}
    <meta name="twitter:image" content="https://mylmark.com/assets/images/mbot.png">

    <title>MBot 3.0 – Votre Assistant</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <!-- Favicon et icônes -->
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="icon" type="image/png" href="{{ asset('assets/images/mbot.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/images/mbot.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>

        * { box-sizing: border-box; margin:0; padding:0; }
        body {
            font-family: 'Lexend', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(to right, #e3f3e8, #ffffff);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            height: auto;
            min-height: 100vh;
        }
        .chat-wrapper {
            width: 100%;
            max-width: 600px;
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            animation: fadeIn 0.5s ease-in-out;
        }

        .chat-header {
            background: #579459;
            color: #fff;
            padding: 15px 20px;
            font-size: 20px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: start;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            }

            .header-content {
            display: flex;
            align-items: center;
            gap: 12px;
            }

            #zalybot-button {
            background: #000;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            object-fit: cover;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
            animation: wowPulse 2s infinite;
            }

            #zalybot-button:hover {
            transform: scale(1.1) rotate(2deg) translateY(-2px);
            box-shadow:
                0 8px 16px rgba(0, 0, 0, 0.4),
                0 0 12px rgba(34, 197, 94, 0.6),
                inset 0 2px 4px rgba(255, 255, 255, 0.15),
                inset 0 -2px 4px rgba(0, 0, 0, 0.25);
            }


        .chat-body {
            padding: 20px;
            background: #f9f9f9;
            height: 400px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .chat-footer {
            display: flex;
            align-items: center;
            padding: 10px;
            gap: 5px;
            border-top: 1px solid #e2e2e2;
            background: #fff;
            position: sticky;
            bottom: 0;
            z-index: 10;
            }


        input[type="text"] {
            flex: 1;
            padding: 12px;
            margin-right: 4px;
            border-radius: 10px;
            border: 1px solid #ccc;
            font-size: 16px;
            outline: none;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        input[type="text"]:focus {
            border-color: #579459;
            box-shadow: 0 0 0 3px rgba(87, 148, 89, 0.2);
        }

        button {
            background: #579459;
            color: #fff;
            border: none;
            font-size: 16px;
            cursor: pointer;
            border-radius: 10px;
            padding: 12px 15px;
            /* min-width: 100px; */
            transition: background 0.3s, transform 0.1s;
        }

        button:hover {
            background: #417341;
        }

        button:active {
            transform: scale(0.97);
        }


        button:hover {
        background: #417341;
        }

        .message {
        background: #ffffff;
        border-radius: 12px;
        padding: 12px 16px;
        font-size: 15px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        animation: fadeInUp 0.4s ease-in-out;
        }

        .message.user {
        align-self: flex-end;
        background: #d2f4dc;
        color: #1c452b;
        border-left: 4px solid #579459;
        }

        .message a {
        color: #579459;
        font-weight: 600;
        text-decoration: none;
        }

        .loader, .no-result {
        font-style: italic;
        color: #888;
        text-align: center;
        }

        .message-user {
        background: #d1e7dd;
        align-self: flex-end;
        text-align: right;
        }

        .message-bot {
        background: #e6ecf3;
        align-self: flex-start;
        }

        .dots span {
        animation: blink 1.5s infinite;
        opacity: 0.2;
        }

        .dots span:nth-child(1) {
        animation-delay: 0s;
        }
        .dots span:nth-child(2) {
        animation-delay: 0.3s;
        }
        .dots span:nth-child(3) {
        animation-delay: 0.6s;
        }

        .menu-btn {
            background:#ecf8f2;
            color:#1f2937;
            padding:8px 12px;
            border-radius:8px; /* arrondi type rounded-lg */
            border:1px solid #98ecae;
            cursor:pointer;
        }
        .menu-btn:hover {
            background:#e2e8f0;
        }
        .chip{
            display:inline-block;
            background:#eef6ee;
            color:#1c452b;
            border:1px solid #cfe7cf;
            border-radius:8px;
            padding:6px 10px;
            margin:6px 6px 0 0;
            cursor:pointer;
            font-size:14px
        }



        @keyframes blink {
        0%, 100% { opacity: 0.2; }
        50% { opacity: 1; }
        }

        @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 600px) {
            input[type="text"] {
                /* font-size: 15px; */
                padding: 5px;
            }

            button {
                padding: 10px 16px;
                font-size: 15px;
            }

            .chat-footer {
                padding: 10px;
            }
            .chat-wrapper {
                height: 100vh;
                /* border-radius: 0; */
                border-radius: 20px;
                box-shadow: none;
                max-width: 100%;
            }
            .chat-body {
                height: calc(100vh - 160px);
            }
        }
    </style>
</head>
<body>
  <div class="chat-wrapper">
    <div class="chat-header">
        <div class="header-content">
            <a href="{{ route('home') }}" aria-label="Aller à la page d'accueil">
                <img id="zalybot-button" src="{{ asset('assets/images/mbot.png') }}" alt="Mbot">
            </a>
            <h1 style="font-size:20px; font-weight:900; color:#fff; margin:0;">
                MBot 3.0 – Votre Assistant
            </h1>
        </div>
    </div>

    <div id="quickMenus" style="display:flex;gap:8px;flex-wrap:wrap;padding:10px;border-top:1px solid #eee;border-bottom:1px solid #eee;background:#fff;">
        <button class="menu-btn" data-intent="buy">🛍️ Acheter</button>
        <button class="menu-btn" data-intent="contact_us">💬 Nous contacter</button>
    </div>
    <div id="chatBody" class="chat-body"></div>
    <div class="chat-footer">
        <input type="text" id="queryInput" required placeholder="Entrer un mot clé...">
        <button id="sendBtn">Envoyer</button>
    </div>
  </div>

  <script>
    const contactUrl = "{{ route('contact') }}";
    const input = document.getElementById('queryInput');
    const sendBtn = document.getElementById('sendBtn');
    const chatBody = document.getElementById('chatBody');


    const API_URL = "{{ route('api.bot.search') ?? '/api/bot/search' }}";
    const CSRF = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

    function httpJson(body) {
        return fetch(API_URL, {
            method: 'POST',
            headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': CSRF
            },
            body: JSON.stringify(body)
        }).then(async (res) => {
            const retryAfter = res.headers.get('Retry-After');
            let data = null, text = null;
            try { data = await res.json(); } catch { try { text = await res.text(); } catch {} }

            if (res.status === 429) {
            throw { rateLimited: true, retryAfter: retryAfter ? parseInt(retryAfter, 10) : null, raw: data ?? text };
            }
            if (!res.ok) throw { httpError: res.status, raw: data ?? text };
            if (!data || typeof data !== 'object') throw { parseError: true, raw: text };
            return data;
        });
    }

    try {
        const savedMessages = localStorage.getItem('botHistory');
        if (savedMessages && savedMessages.startsWith('<div')) {
            chatBody.innerHTML += savedMessages;
        } else {
            localStorage.removeItem('botHistory'); // on nettoie les messages invalides
            appendMessage('👋 Salut ! Comment puis-je vous aider aujourd\'hui ?');
        }
    } catch (e) {
        localStorage.removeItem('botHistory');
        appendMessage('👋 Salut ! Comment puis-je vous aider aujourd\'hui ?');
    }


    function appendMessage(content, sender = 'bot') {
      const div = document.createElement('div');
      div.className = 'message ' + (sender === 'user' ? 'message-user' : 'message-bot');
      div.innerHTML = content;
      chatBody.appendChild(div);
      setTimeout(() => chatBody.scrollTop = chatBody.scrollHeight, 10);
    }

    function saveConversation() {
      localStorage.setItem('botHistory', chatBody.innerHTML);
    }

    sendBtn.addEventListener('click', () => {
      const query = input.value.trim();
      if (query.length < 2) return;
      appendMessage(`<strong>Vous :</strong> ${query}`, 'user');
      input.value = '';
      appendMessage('<div class="loader">MBot réfléchit<span class="dots"><span>.</span><span>.</span><span>.</span></span></div>');
      saveConversation();

      fetch('/api/bot/search', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ query })
      })
      .then(res => res.json())
      .then(data => {
        chatBody.removeChild(chatBody.lastChild);
        if (!data.results.length) {
          appendMessage(`<div class="no-result">Aucun résultat trouvé. <a href="${contactUrl}" target="_blank" class="underline text-green-700 hover:text-green-900">Contactez-nous</a> si vous avez besoin d'aide.</div>`);
          return;
        }
        const html = data.results.map(item => `
          <div class="message">
            <div>🔎 <strong>${item.type} :</strong> <a href="${item.url}" target="_blank">${item.title}</a></div>
            <small>${item.excerpt}</small>
          </div>
        `).join('');
        chatBody.insertAdjacentHTML('beforeend', html);
        saveConversation();
      })
      .catch(() => {
        chatBody.removeChild(chatBody.lastChild);
        appendMessage('<div class="no-result">❌ Erreur lors de la recherche.</div>');
      });
    });

    // Boutons menus -> question + options
    document.querySelectorAll('.menu-btn').forEach(b=>{
    b.addEventListener('click', ()=>{
        const intent = b.dataset.intent;
        appendMessage(`<strong>Vous :</strong> ${b.textContent}`, 'user');
        askMenu(intent);
    });
    });

    // function askMenu(intent){
    //     appendMessage('<div class="loader">MBot prépare des options<span class="dots"><span>.</span><span>.</span><span>.</span></span></div>');
    //     fetch('/api/bot/search', {
    //         method:'POST',
    //         headers:{'Content-Type':'application/json','Accept':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content},
    //         body: JSON.stringify({ query: `menu:${intent}` })
    //     })
    //     .then(r=>r.json())
    //     .then(data=>{
    //         chatBody.removeChild(chatBody.lastChild);
    //         if (!data.results || !data.results.length) {
    //             appendMessage('<div class="no-result"> ⚠ Aucune option disponible...</div>');
    //         return;
    //         }
    //         const item = data.results[0]; // {type:'Question', title:question, excerpt:'{...}'}
    //         let payload = {};
    //         try { payload = JSON.parse(item.excerpt || '{}'); } catch(e){ payload = {}; }

    //         appendMessage(`<div><strong>${item.title}</strong></div>`);
    //         if (payload.options && payload.options.length) {
    //         const wrap = document.createElement('div');

    //         payload.options.forEach(opt=>{
    //             const chip = document.createElement('span');
    //             chip.className = 'chip';
    //             chip.textContent = opt.replace('-', ' ');
    //             chip.addEventListener('click', ()=> chooseOption(payload.slot, opt, payload.intent));

    //             wrap.appendChild(chip);
    //         });
    //         chatBody.appendChild(wrap);
    //         setTimeout(()=> chatBody.scrollTop = chatBody.scrollHeight, 10);
    //         }
    //         saveConversation();
    //     })
    //     .catch(()=>{
    //         chatBody.removeChild(chatBody.lastChild);
    //         appendMessage('<div class="no-result">❌ Erreur (menu).</div>');
    //     });
    // }


    function askMenu(intent){
        appendMessage('<div class="loader">MBot prépare des options<span class="dots"><span>.</span><span>.</span><span>.</span></span></div>');
        fetch('/api/bot/search', {
            method:'POST',
            headers:{'Content-Type':'application/json','Accept':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content},
            body: JSON.stringify({ query: `menu:${intent}` })
        })
        .then(r=>r.json())
        .then(data=>{
            chatBody.removeChild(chatBody.lastChild);
            if (!data.results || !data.results.length) {
                appendMessage('<div class="no-result"> ⚠ Aucune catégorie disponible pour le moment.</div>');
                return;
            }
            const item = data.results[0];
            let payload = {};
            try {
                payload = JSON.parse(item.excerpt || '{}');
            } catch(e){
                console.error("Erreur parsing JSON:", e);
                payload = {};
            }

            appendMessage(`<div><strong>${item.title}</strong></div>`);
            if (payload.options && payload.options.length) {
                const wrap = document.createElement('div');
                wrap.style.marginTop = '10px';

                payload.options.forEach(opt=>{
                    const chip = document.createElement('span');
                    chip.className = 'chip';
                    chip.textContent = opt;
                    chip.style.cursor = 'pointer';
                    chip.style.margin = '4px';
                    chip.style.padding = '8px 12px';
                    chip.style.backgroundColor = '#e8f5e9';
                    chip.style.borderRadius = '20px';
                    chip.style.border = '1px solid #c8e6c9';

                    chip.addEventListener('click', ()=> {
                        // Convertir l'option en slug pour l'envoi
                        const slug = opt.toLowerCase().replace(/\s+/g, '-');
                        chooseOption(payload.slot, slug, payload.intent);
                    });

                    wrap.appendChild(chip);
                });
                chatBody.appendChild(wrap);
                setTimeout(()=> chatBody.scrollTop = chatBody.scrollHeight, 10);
            } else {
                appendMessage('<div class="no-result">Aucune option disponible.</div>');
            }
            saveConversation();
        })
        .catch((error)=>{
            console.error("Erreur:", error);
            chatBody.removeChild(chatBody.lastChild);
            appendMessage('<div class="no-result">❌ Erreur lors du chargement des options.</div>');
        });
    }


    function chooseOption(slot, value, intent){
        appendMessage(`<strong>Vous :</strong> ${value.replace('-', ' ')}`, 'user');
        appendMessage('<div class="loader">Recherche en cours<span class="dots"><span>.</span><span>.</span><span>.</span></span></div>');
        const q = `slot:${slot}=${value}&intent=${intent}`;
        fetch('/api/bot/search', {
            method:'POST',
            headers:{'Content-Type':'application/json','Accept':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content},
            body: JSON.stringify({ query: q })
        })
        .then(r=>r.json())
        .then(data=>{
            chatBody.removeChild(chatBody.lastChild);
            if (!data.results || !data.results.length) {
            appendMessage('<div class="no-result">Aucun résultat trouvé.</div>');
            return;
            }
            const html = data.results.map(item => `
            <div class="message">
                <div>🔎 <strong>${item.type} :</strong> ${item.url ? `<a href="${item.url}" target="_blank">${item.title}</a>` : item.title}</div>
                <small>${item.excerpt || ''}</small>
            </div>
            `).join('');
            chatBody.insertAdjacentHTML('beforeend', html);
            saveConversation();
        })
        .catch(()=>{
            chatBody.removeChild(chatBody.lastChild);
            appendMessage('<div class="no-result">❌ Erreur (option).</div>');
        });
    }

    input.addEventListener('keydown', e => {
      if (e.key === 'Enter') sendBtn.click();
    });
  </script>
</body>
</html>
