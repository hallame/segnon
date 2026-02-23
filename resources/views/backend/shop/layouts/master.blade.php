<!DOCTYPE html>
<html lang="fr">
<head>
	<!-- Meta Tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        use App\Support\CurrentAccount;
        $u = auth()->user();
        $account = app(CurrentAccount::class)->account;
    @endphp

    <title>@yield('title') | {{ $account ? $account->name : 'MYLMARK' }}</title>

    {{-- SEO --}}
    <meta name="description" content="Espace Partenaires MYLMARK : gérez vos produits, commandes et paiements, suivez vos ventes et développez votre activité sur la marketplace africaine.">
	<meta name="robots" content="noindex, nofollow">

    {{-- Open Graph --}}
    <meta property="og:title" content="@yield('og_title', ($account ? $account->name.' • Espace partenaires' : 'Espace partenaires • MYLMARK'))">
    <meta property="og:description" content="@yield('og_desc', 'Interface de gestion pour les vendeurs MYLMARK : catalogue, commandes, paiements et statistiques.')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="@yield('og_image', asset('assets/images/2m.png'))">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="@yield('og_image_width', '1200')">
    <meta property="og:image:height" content="@yield('og_image_height', '630')">
    <meta property="og:image:alt" content="@yield('og_image_alt', 'MYLMARK – Espace partenaires')">
    <meta property="og:locale" content="fr_FR">

	<!-- Apple Touch Icon -->
	<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/images/favicon.png') }}">

	<!-- Favicon -->
	<link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/png">
	<link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/png">

	<!-- Theme Script js -->
	<script src="{{ asset('assets/back/js/theme-script.js') }}"></script>

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="{{ asset('assets/back/css/bootstrap.min.css') }}">

	<!-- Feather CSS -->
	<link rel="stylesheet" href="{{ asset('assets/back/plugins/icons/feather/feather.css') }}">

	<!-- Tabler Icon CSS -->
	<link rel="stylesheet" href="{{ asset('assets/back/plugins/tabler-icons/tabler-icons.css') }}">

	<!-- Select2 CSS -->
	<link rel="stylesheet" href="{{ asset('assets/back/plugins/select2/css/select2.min.css') }}">

    <!-- Datatable CSS -->
	<link rel="stylesheet" href="{{ asset('assets/back/css/dataTables.bootstrap5.min.css') }}">

	<!-- Fontawesome CSS -->
	<link rel="stylesheet" href="{{ asset('assets/back/plugins/fontawesome/css/fontawesome.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/back/plugins/fontawesome/css/all.min.css') }}">

	<!-- Datetimepicker CSS -->
	<link rel="stylesheet" href="{{ asset('assets/back/css/bootstrap-datetimepicker.min.css') }}">

	<!-- Bootstrap Tagsinput CSS -->
	<link rel="stylesheet" href="{{ asset('assets/back/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}">

	<!-- Summernote CSS -->
	<link rel="stylesheet" href="{{ asset('assets/back/plugins/summernote/summernote-lite.min.css') }}">

	<!-- Daterangepikcer CSS -->
	<link rel="stylesheet" href="{{ asset('assets/back/plugins/daterangepicker/daterangepicker.css') }}">

	<!-- Color Picker Css -->
	<link rel="stylesheet" href="{{ asset('assets/back/plugins/flatpickr/flatpickr.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/back/plugins/@simonwep/pickr/themes/nano.min.css') }}">

	<!-- Main CSS -->
	<link rel="stylesheet" href="{{ asset('assets/back/css/style.css') }}">

    <!-- animation CSS -->
	<link rel="stylesheet" href="{{ asset('assets/back/css/animate.css') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <!-- CSS de Tagify -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css">
</head>
<body>

    <div id="global-loader" style="display: none;">
		<div class="page-loader"></div>
	</div>

	<!-- Main Wrapper -->
	<div class="main-wrapper">
        @include('components.backend.partners.header')
        @include('backend.shop.layouts.sidebar')
		<!-- Page Wrapper -->
		<div class="page-wrapper">
            {{-- @include('components.alert') --}}
			<div class="content">
                @yield('content')
            </div>
            @include('components.backend.footer')
        </div>
        <!-- /Page Wrapper -->
        @include('components.backend.partners.addons')
    </div>
	<!-- /Main Wrapper -->
    @include('components.backend.scripts')
</body>
</html>
