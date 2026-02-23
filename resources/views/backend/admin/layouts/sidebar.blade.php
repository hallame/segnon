		<!-- Sidebar -->
		<div class="sidebar" id="sidebar">
			<!-- Logo -->
            <div class="sidebar-logo">
                <a href="{{ route('admin.dashboard') }}" class="logo-text dark-logo1">MYLMARK</a>
                <a href="{{ route('admin.dashboard') }}" class="logo-small">
					<img src="{{ asset('assets/images/favicon.png') }}" alt="Logo">
				</a>
            </div>

			<!-- /Logo -->
			<div class="sidebar-inner slimscroll">
				<div id="sidebar-menu" class="sidebar-menu">
					<ul>
						<li class="menu-title"><span>SUPER ADMIN</span></li>
						<li>
							<ul>
								<li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
									<a href="{{ route('admin.dashboard') }}">
										<i class="ti ti-smart-home"></i><span>Tableau de bord</span>
										<span class="badge badge-danger fs-10 fw-medium text-white p-1"><i class="ti ti-shield-lock text-white"></i></span>
									</a>
								</li>

                                {{-- <li class="submenu">
									<a href="#" class="{{ request()->routeIs('admin.users.*') ? 'active subdrop' : '' }}">
										<i class="ti ti-users-group"></i><span>Utilisateurs</span>
										<span class="menu-arrow"></span>
									</a>
									<ul>
                                        <li><a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.index') ? 'active' : '' }}">Tous les utilisateurs</a></li>
                                        <li><a href="{{ route('admin.users.customers') }}" class="{{ request()->routeIs('admin.users.customers') ? 'active' : '' }}">Clients</a></li>
                                        <li><a href="{{ route('admin.users.partners') }}" class="{{ request()->routeIs('admin.users.partners') ? 'active' : '' }}">Partenaires Marchands</a></li>
                                        <li><a href="#" data-bs-toggle="modal" data-bs-target="#add_user">Ajouter un utilisateur</a></li>
                                        <li><a href="#" data-bs-toggle="modal" data-bs-target="#add_partner2">Ajouter un partenaire</a></li>
									</ul>
								</li> --}}



                                 <li class="{{ request()->routeIs('admin.categories') ? 'active' : '' }}">
                                    <a href="{{ route('admin.categories') }}">
                                        <i class="ti ti-layout-grid-add"></i><span>Catégories</span>
                                    </a>
                                </li>


                               {{-- <li class="{{ request()->routeIs('admin.submissions.*') ? 'active' : '' }}">
                                    <a href="{{ route('admin.submissions.index') }}">
                                        <i class="ti ti-inbox"></i>
                                        <span>Soumissions</span>
                                        <span class="badge badge-primary fs-10 fw-medium text-white p-1">SaaS</span>

                                    </a>
                                </li> --}}

        

                                 <li class="menu-title mt-4"><span>GESTION ECOMMERCE</span></li>
                                <li class="submenu">
                                    <a href="{{ route('admin.products.index') }}"
                                    class="{{ request()->routeIs('admin.products.*') ? 'active subdrop' : '' }}">
                                        <i class="ti ti-box"></i><span>Produits</span>
                                        <span class="badge badge-secondary fs-10 fw-medium text-white p-1">Ecommerce</span>
                                        <span class="menu-arrow"></span>
                                    </a>

                                    <ul>
                                        <li>
                                            <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.index') ? 'active' : '' }}">
                                                Tous les produits
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('admin.products.create') }}"
                                                class="{{ request()->routeIs('admin.products.create') ? 'active' : '' }}">
                                                Ajouter un produit
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="submenu">
                                    <a href="{{ route('admin.orders.index') }}"
                                    class="{{ request()->routeIs('admin.orders.*') ? 'active subdrop' : '' }}">
                                        <i class="fa fa-receipt"></i><span>Commandes</span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <ul>
                                        <li>
                                            <a href="{{ route('admin.orders.index') }}"
                                            class="{{ request()->routeIs('admin.orders.index') && request('status')===null ? 'active' : '' }}">
                                                Toutes les commandes
                                            </a>
                                        </li>

                                        <li>
                                            <a href="{{ route('admin.orders.index', ['status'=>\App\Models\Order::STATUS_PENDING]) }}"
                                            class="{{ request()->routeIs('admin.orders.index') && (string)request('status')===(string)\App\Models\Order::STATUS_PENDING ? 'active' : '' }}">
                                                En attente
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('admin.orders.index', ['status'=>\App\Models\Order::STATUS_UNDER_REVIEW]) }}"
                                            class="{{ request()->routeIs('admin.orders.index') && (string)request('status')===(string)\App\Models\Order::STATUS_UNDER_REVIEW ? 'active' : '' }}">
                                                En revue
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('admin.orders.index', ['status'=>\App\Models\Order::STATUS_PAID]) }}"
                                            class="{{ request()->routeIs('admin.orders.index') && (string)request('status')===(string)\App\Models\Order::STATUS_PAID ? 'active' : '' }}">
                                                Payées
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('admin.orders.index', ['status'=>\App\Models\Order::STATUS_CANCELLED]) }}"
                                            class="{{ request()->routeIs('admin.orders.index') && (string)request('status')===(string)\App\Models\Order::STATUS_CANCELLED ? 'active' : '' }}">
                                                Annulées
                                            </a>
                                        </li>

                                    </ul>
                                </li>


                                {{-- <li class="menu-title mt-4"><span>GESTION ÉVÉNEMENTS</span></li>
                                <li class="submenu">
                                    <a href="{{ route('admin.events.index') }}" class="{{ request()->routeIs('admin.events.*') ? 'active subdrop' : '' }}">
                                        <i class="ti ti-calendar-check"></i><span>Événements </span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <ul>
                                        <li>
                                            <a href="{{ route('admin.events.index') }}"
                                            class="{{ request()->routeIs('admin.events.index', 'admin.events.show') ? 'active' : '' }}">
                                                Tous les événements
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('admin.events.create') }}"
                                            class="{{ request()->routeIs('admin.events.create') ? 'active' : '' }}">
                                                Nouvel événement
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="submenu">
                                    <a href="{{ route('admin.tickets.index') }}"
                                    class="{{ request()->routeIs(['admin.tickets.*', 'admin.ticket_types.*', 'admin.tickets.orders.*']) ? 'active subdrop' : '' }}">
                                        <i class="fa fa-ticket"></i>
                                        <span>Billetterie</span>
                                        <span class="badge badge-danger fs-10 fw-medium text-white p-1"><i class="fa fa-receipt"></i></span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <ul>
                                        <li>
                                            <a href="{{ route('admin.ticket_types.index') }}"
                                            class="{{ request()->routeIs('admin.ticket_types.index') ? 'active' : '' }}">
                                                Types de tickets
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('admin.tickets.index') }}"
                                            class="{{ request()->routeIs('admin.tickets.index') ? 'active' : '' }}">
                                                Gestion des tickets
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('admin.tickets.orders.index') }}"
                                            class="{{ request()->routeIs('admin.tickets.orders.*') ? 'active' : '' }}">
                                                Commandes & paiements
                                            </a>
                                        </li>
                                    </ul>
                                </li> --}}


                                {{-- <li class="menu-title mt-4"><span>GESTION TOURISTIQUE</span></li>
                                <li class="submenu">
									<a href="{{ route('admin.sites') }}" class="{{ request()->routeIs(['admin.sites', 'admin.sites.show', 'admin.site.edit', 'admin.site.add.form', 'admin.sites.galleries']) ? 'active subdrop' : '' }}">
										<i class="ti ti-map-pin"></i><span>Sites Touristiques</span>
										<span class="menu-arrow"></span>
									</a>
									<ul>
                                        <li><a href="{{ route('admin.sites') }}" class="{{ request()->routeIs('admin.sites') ? 'active' : '' }}">Tous les sites</a></li>
                                        <li><a href="{{ route('admin.site.add.form') }}" class="{{ request()->routeIs('admin.site.add.form') ? 'active' : '' }}">Ajouter un site</a></li>
                                        <li><a href="{{ route('admin.sites.galleries') }}" class="{{ request()->routeIs('admin.sites.galleries') ? 'active' : '' }}" >Galeries  </a> </li>
									</ul>
								</li>
                                <li class="submenu">
									<a href="{{ route('admin.circuits') }}" class="{{ request()->routeIs(['admin.circuits', 'admin.circuit.create', 'admin.circuit.edit', 'admin.circuit.add.form']) ? 'active subdrop' : '' }}">
										<i class="ti ti-pyramid"></i><span>Circuits</span>
										<span class="menu-arrow"></span>
									</a>

									<ul>
                                        <li><a href="{{ route('admin.circuits') }}" class="{{ request()->routeIs('admin.circuits') ? 'active' : '' }}">Tous les circuits</a></li>
                                        <li><a href="{{ route('admin.circuit.add.form') }}" class="{{ request()->routeIs('admin.circuit.add.form') ? 'active' : '' }}">Ajouter un circuit</a></li>
									</ul>
								</li>



                                <li class="submenu">
                                    <a href="{{ route('admin.stories.index') }}"
                                        class="{{ request()->routeIs(['admin.stories.index', 'admin.stories.show', 'admin.stories.edit', 'admin.stories.create']) ? 'active subdrop' : '' }}">
                                        <i class="ti ti-microphone"></i> <span>Contes</span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <ul>
                                        <li>
                                        <a href="{{ route('admin.stories.index') }}"
                                            class="{{ request()->routeIs('admin.stories.index') ? 'active' : '' }}">
                                            Tous les contes
                                        </a>
                                        </li>
                                        <li>
                                        <a href="{{ route('admin.stories.create') }}"
                                            class="{{ request()->routeIs('admin.stories.create') ? 'active' : '' }}">
                                            Ajouter un conte
                                        </a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="submenu">
									<a href="{{ route('admin.objects.index') }}" class="{{ request()->routeIs(['admin.objects.index', 'admin.objects.show', 'admin.objects.edit', 'admin.objects.create']) ? 'active subdrop' : '' }}">
										<i class="ti ti-brush"></i> <span>Objets d'art</span>
										<span class="menu-arrow"></span>
									</a>
									<ul>
                                        <li><a href="{{ route('admin.objects.index') }}" class="{{ request()->routeIs('admin.objects.index') ? 'active' : '' }}">Tous les objets</a></li>
                                        <li><a href="{{ route('admin.objects.create') }}" class="{{ request()->routeIs('admin.objects.create') ? 'active' : '' }}">Ajouter un objet</a></li>
									</ul>
								</li> --}}



                                {{-- <li class="menu-title mt-4"><span>GESTION HÔTELLERIE</span></li>
                                <li class="submenu">
									<a href="{{ route('admin.hotels') }}" class="{{ request()->routeIs(['admin.hotels', 'admin.hotels.show', 'admin.hotel.edit', 'admin.hotel.add']) ? 'active subdrop' : '' }}">
                                         <i class="fa fa-hotel"></i><span>Hôtels</span>
                                        <span class="badge badge-danger fs-10 fw-medium text-white p-1">Nouveau</span>
										<span class="menu-arrow"></span>
									</a>
									<ul>
                                        <li><a href="{{ route('admin.hotels') }}" class="{{ request()->routeIs('admin.hotels') ? 'active' : '' }}">Tous les hôtels</a></li>
                                        <li><a href="{{ route('admin.hotel.add') }}" class="{{ request()->routeIs('admin.hotel.add') ? 'active' : '' }}">Ajouter un hôtel</a></li>
									</ul>
								</li>
                                <li class="submenu">
									<a href="{{ route('admin.rooms') }}" class="{{ request()->routeIs(['admin.rooms', 'admin.rooms.show', 'admin.rooms.edit', 'admin.rooms.create']) ? 'active subdrop' : '' }}">
                                         <i class="fa fa-bed"></i>
                                         <span>Chambres</span>
										<span class="menu-arrow"></span>
									</a>
									<ul>
                                        <li><a href="{{ route('admin.rooms') }}" class="{{ request()->routeIs('admin.rooms') ? 'active' : '' }}">Toutes les chambres</a></li>
                                        <li><a href="{{ route('admin.rooms.create') }}" class="{{ request()->routeIs('admin.rooms.create') ? 'active' : '' }}">Ajouter une chambre</a></li>
									</ul>
								</li> --}}





                                <li class="menu-title mt-4"><span>GESTION DE CONTENU</span></li>

                                {{-- <li class="submenu">
									<a href="{{ route('admin.home.sliders') }}" class="{{ request()->routeIs(['admin.home.sliders', 'admin.home.sections']) ? 'active subdrop' : '' }}">
                                         <i class="fa fa-home"></i><span>Page d’accueil</span>
										<span class="menu-arrow"></span>
									</a>
									<ul>
                                        <li><a href="{{ route('admin.home.sections') }}" class="{{ request()->routeIs('admin.home.sections') ? 'active' : '' }}">Gestion du contenu</a></li>
                                        <li><a href="{{ route('admin.home.sliders') }}" class="{{ request()->routeIs('admin.home.sliders') ? 'active' : '' }}">Gestions des sliders</a></li>
									</ul>
								</li>

                                <li class="submenu">
									<a href="{{ route('admin.sliders') }}" class="{{ request()->routeIs(['admin.sliders', 'admin.slider.edit']) ? 'active subdrop' : '' }}">
                                         <i class="fa fa-sliders-h"></i><span>Sliders</span>
										<span class="menu-arrow"></span>
									</a>
									<ul>
                                        <li><a href="{{ route('admin.sliders') }}" class="{{ request()->routeIs('admin.sliders') ? 'active' : '' }}">Gestion des sliders</a></li>
									</ul>
								</li> --}}


                                {{-- <li class="submenu">
									<a href="{{ route('admin.pages') }}" class="{{ request()->routeIs(['admin.pages', 'admin.page.edit', 'admin.page.create', 'admin.sections', 'admin.sliders', 'admin.section.edit','admin.slider.edit']) ? 'active subdrop' : '' }}">
                                         <i class="fa fa-book"></i><span>Gestion des Pages</span>
										<span class="menu-arrow"></span>
									</a>
									<ul>
                                        <li><a href="{{ route('admin.pages') }}" class="{{ request()->routeIs('admin.pages') ? 'active' : '' }}">Toutes les pages</a></li>
                                        <li><a href="{{ route('admin.page.create') }}" class="{{ request()->routeIs('admin.page.create') ? 'active' : '' }}">Nouvelle page</a></li>
                                        <li><a href="{{ route('admin.sections') }}" class="{{ request()->routeIs('admin.sections') ? 'active' : '' }}">Sections des pages</a></li>
                                        <li><a href="{{ route('admin.sliders') }}" class="{{ request()->routeIs('admin.sliders') ? 'active' : '' }}">Accueil: Sliders</a></li>
									</ul>
								</li> --}}

                                 {{-- <li class="submenu">
									<a href="{{ route('admin.sections') }}" class="{{ request()->routeIs(['admin.sections', 'admin.section.edit', 'admin.section.add.form']) ? 'active subdrop' : '' }}">
                                         <i class="fa fa-layer-group"></i><span>Sections</span>
										<span class="menu-arrow"></span>
									</a>
									<ul>
                                        <li><a href="{{ route('admin.sections') }}" class="{{ request()->routeIs('admin.sections') ? 'active' : '' }}">Gestion des sections</a></li>
                                        <li><a href="{{ route('admin.section.add.form') }}" class="{{ request()->routeIs('admin.section.add.form') ? 'active' : '' }}">Ajouter une section</a></li>
									</ul>
								</li> --}}


                                <li class="{{ request()->routeIs('admin.contacts') ? 'active' : '' }}">
                                    <a href="{{ route('admin.contacts') }}">
                                        <i class="ti ti-phone"></i>
                                        <span>Contacts </span>
                                    </a>
                                </li>
                                <li class="{{ request()->routeIs('admin.socials.*') ? 'active' : '' }}">
                                    <a href="{{ route('admin.socials') }}">
                                        <i class="ti ti-brand-facebook"></i><span>Réseaux Sociaux</span>
                                        <span class="badge badge-purple fs-10 fw-medium text-white p-1">Footer</span>
                                    </a>
                                </li>

                                <li class="{{ request()->routeIs('admin.faqs.*') ? 'active' : '' }}">
                                    <a href="{{ route('admin.faqs.index') }}">
                                        <i class="ti ti-help-circle"></i><span>FAQs</span>
                                    </a>
                                </li>


                                <li class="menu-title mt-4" ><span>PARAMÈTRES DU SYSTÈME</span></li>

                                 {{-- <li class="submenu">
                                    <a href="{{ route('admin.partners') }}" class="{{ request()->routeIs('admin.partners', 'admin.partners.show', 'admin.partner.add.form') ? 'active subdrop' : '' }}">
                                        <i class="ti ti-user-star"></i><span>Partenaires: L'équipe</span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <ul>
                                        <li><a href="{{ route('admin.partners') }}" class="{{ request()->routeIs('admin.partners', 'admin.partners.show') ? 'active' : '' }}">Tous les membres</a></li>
                                        <li><a href="#" class="{{ request()->routeIs('admin.partner.create') ? 'active' : '' }}" data-bs-toggle="modal" data-bs-target="#add_partner">Nouveau membre</a></li>
                                    </ul>
                                </li> --}}


                                <li class="{{ request()->routeIs('admin.countries') ? 'active' : '' }}">
                                    <a href="{{ route('admin.countries') }}">
                                        <i class="ti ti-world"></i>
                                        <span>Pays </span>
                                    </a>
                                </li>

                                <li class="{{ request()->routeIs('admin.payment_methods.index') ? 'active' : '' }}">
                                    <a href="{{ route('admin.payment_methods.index') }}">
                                        <i class="ti ti-wallet"></i><span>Moyens de paiement</span>
                                        <span class="badge badge-danger fs-10 fw-medium text-white p-1">Secure</span>

                                    </a>
                                </li>
                                <li class="{{ request()->routeIs('admin.myprofile') ? 'active' : '' }}">
                                    <a href="{{ route('admin.myprofile') }}">
                                        <i class="ti ti-circle-arrow-up"></i><span>Mon Compte</span>
                                    </a>
                                </li>

							</ul>
						</li>


					</ul>
				</div>
			</div>
		</div>
		<!-- /Sidebar -->

        <style>
            @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@700&display=swap');
            .logo-text {
                font-size: 18px;
                font-weight: 900;
                text-transform: uppercase;
                letter-spacing: 1px;
                display: block;
                font-family: "Roboto", sans-serif;
            }
            .logo-normal {
                color: #2C3E50;
            }
            .logo-small {
                font-size: 20px;
                color: #3498DB;
            }

            .dark-logo1 {
                color: white;
                padding: 5px 10px 30px 5px;
                text-shadow: 1px 1px 3px rgba(247, 74, 0, 0.9);
            }
        </style>

