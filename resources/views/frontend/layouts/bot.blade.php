
 <div id="mbot-assistant">
        <a href="{{ route('bot') }}"
            class="mbot-fab" target="_blank"
            aria-label="Ouvrir MBot Assistant"
            title="Discutez avec MBot 3.0">
            <img src="{{ asset('assets/images/mbot.png') }}"
                alt="MBot Assistant"
                width="52"
                height="52">
            <span class="mbot-pulse"></span>
        </a>

        <style>
            /* Base */
            .mbot-fab {
                position: fixed;
                right: 20px;
                bottom: 20px;
                z-index: 9999;
                display: block;
                border-radius: 50%;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                animation: fabEntrance 0.8s ease-out;
            }

            @media (max-width: 767px) {
                .mbot-fab {
                    bottom: 80px;
                    right: 20px;
                }
            }

            .mbot-fab img {
                width: 48px;
                height: 48px;
                border-radius: 50%;
                cursor: pointer;
                display: block;
                background: #000;
                border: 2px solid #22c55e;
                position: relative;
                z-index: 2;
                transition: all 0.3s ease;
                box-shadow: 0 8px 25px rgba(34, 197, 94, 0.3);
            }

            /* Animation pulse externe */
            .mbot-pulse {
                position: absolute;
                top: -8px;
                left: -8px;
                right: -8px;
                bottom: -8px;
                border-radius: 50%;
                background: rgba(34, 197, 94, 0.2);
                z-index: 1;
                animation: pulseWave 2s infinite, colorShift 8s infinite;
            }

            /* Animations principales */
            @keyframes fabEntrance {
                0% {
                    opacity: 0;
                    transform: scale(0) rotate(-180deg);
                }
                70% {
                    opacity: 1;
                    transform: scale(1.1) rotate(10deg);
                }
                100% {
                    transform: scale(1) rotate(0);
                }
            }

            @keyframes pulseWave {
                0% {
                    opacity: 0.8;
                    transform: scale(1);
                }
                50% {
                    opacity: 0.4;
                    transform: scale(1.1);
                }
                100% {
                    opacity: 0;
                    transform: scale(1.3);
                }
            }

            @keyframes colorShift {
                0%, 100% { background: rgba(34, 197, 94, 0.2); }
                33% { background: rgba(59, 130, 246, 0.2); }
                66% { background: rgba(168, 85, 247, 0.2); }
            }

            /* Animation de rotation intermittente */
            @keyframes occasionalRotate {
                0%, 85% { transform: rotate(0); }
                90% { transform: rotate(15deg); }
                95% { transform: rotate(-10deg); }
                100% { transform: rotate(0); }
            }

            /* Animation ping-pong */
            @keyframes gentleBounce {
                0%, 100% { transform: translateY(0); }
                50% { transform: translateY(-12px); }
            }

            /* États interactifs */
            .mbot-fab:hover img {
                transform: scale(1.15);
                border-color: #86efac;
                box-shadow:
                    0 0 25px #22c55e,
                    0 12px 30px rgba(0, 0, 0, 0.3);
                animation: occasionalRotate 0.5s ease;
            }

            .mbot-fab:hover .mbot-pulse {
                animation: pulseWave 1s infinite, colorShift 4s infinite;
            }

            .mbot-fab:active img {
                transform: scale(0.95);
                transition: transform 0.1s;
            }

            /* Mode attractif (activé périodiquement) */
            .mbot-attract img {
                animation: gentleBounce 2s ease-in-out 3, occasionalRotate 0.8s ease 1.5s;
            }

            /* Notification badge */
            .mbot-notif {
                position: absolute;
                top: -5px;
                right: -5px;
                background: linear-gradient(135deg, #ef4444, #f97316);
                color: white;
                font-size: 11px;
                font-weight: bold;
                width: 22px;
                height: 22px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                z-index: 3;
                animation: notifPop 0.5s cubic-bezier(0.4, 0, 0.2, 1);
                box-shadow: 0 4px 10px rgba(239, 68, 68, 0.4);
            }

            @keyframes notifPop {
                0% { transform: scale(0); }
                70% { transform: scale(1.2); }
                100% { transform: scale(1); }
            }
        </style>

        <script>
            (function() {
                const fab = document.querySelector('.mbot-fab');
                const img = fab.querySelector('img');

                // Mode attractif toutes les 10 secondes
                setInterval(() => {
                    if (!document.hidden) {
                        fab.classList.add('mbot-attract');
                        setTimeout(() => fab.classList.remove('mbot-attract'), 1000);
                    }
                }, 10000);

                // Rotation aléatoire occasionnelle
                setInterval(() => {
                    if (!document.hidden && Math.random() > 0.7) {
                        img.style.transform = 'rotate(360deg)';
                        setTimeout(() => img.style.transform = '', 1000);
                    }
                }, 8000);

                // Ajout notification après 15s
                setTimeout(() => {
                    if (!localStorage.getItem('mbot_clicked')) {
                        const notif = document.createElement('div');
                        notif.className = 'mbot-notif';
                        // Utilisation d'une icône RemixIcon au lieu de l'emoji
                        notif.innerHTML = '<i class="ri-sparkling-2-fill" style="font-size: 12px;"></i>';
                        notif.title = 'Mbot Assistant !';
                        fab.appendChild(notif);
                        fab.addEventListener('click', () => {
                            localStorage.setItem('mbot_clicked', 'true');
                        }, { once: false });
                    }
                }, 15000);


                // Animation au survol mobile (touch)
                fab.addEventListener('touchstart', () => {
                    fab.classList.add('mbot-attract');
                }, { passive: true });

                fab.addEventListener('touchend', () => {
                    setTimeout(() => fab.classList.remove('mbot-attract'), 1000);
                }, { passive: true });
            })();
        </script>
    </div>
