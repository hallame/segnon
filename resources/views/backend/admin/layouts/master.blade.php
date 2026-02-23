<!DOCTYPE html>
<html lang="fr">
<head>
	<!-- Meta Tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | MYLMARK</title>
    <meta name="description" content="MYLMARK, la plateforme dédiée à la valorisation du patrimoine culturel et naturel.">
	<meta name="robots" content="noindex, nofollow">


    <meta property="og:image" content="{{ asset('assets/images/admin.png') }}">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">

	<!-- Apple Touch Icon -->
	<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/images/favicon.png') }}">

	<!-- Favicon -->
	<link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
	<link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">

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



	<style>
		/* Force tous les inputs en blanc avec bordure visible */
		input, select, textarea, .select2-selection {
			border: 1px solid #ced4da !important;
			color: #212529 !important;
		}
		
		/* Labels visibles */
		label {
			color: #212529 !important;
			font-weight: 500 !important;
		}
		
		/* Cards avec fond blanc */
		.card, .modal-content {
			background-color: #ffffff !important;
			border: 1px solid #e9ecef !important;
		}
		
		/* Placeholders visibles */
		::placeholder {
			color: #6c757d !important;
			opacity: 1 !important;
		}
	</style>

</head>
<body>

    <div id="global-loader" style="display: none;">
		<div class="page-loader"></div>
	</div>

	<!-- Main Wrapper -->
	<div class="main-wrapper">
        @include('backend.admin.layouts.header')
        @include('backend.admin.layouts.sidebar')
		<!-- Page Wrapper -->
		<div class="page-wrapper">
            {{-- @include('components.alert') --}}
			<div class="content">
                @yield('content')
            </div>
            @include('components.backend.footer')
        </div>
        <!-- /Page Wrapper -->
        @include('backend.admin.layouts.addons')
    </div>
	<!-- /Main Wrapper -->
    @include('backend.admin.layouts.scripts')
</body>
</html>

