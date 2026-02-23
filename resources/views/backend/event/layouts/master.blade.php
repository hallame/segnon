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

    <title>@yield('title') | Événementiel ZALY MERVEILLE </title>
    <meta name="description" content="Découvrez Zaly Merveille, la plateforme dédiée à la valorisation du patrimoine culturel et naturel de la Guinée Forestière. Explorez des sites uniques, réservez vos visites et plongez dans l'histoire et les traditions locales.">
	<meta name="robots" content="noindex, nofollow">

    <meta property="og:image" content="{{ asset('assets/images/admin.png') }}">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">

	<!-- Apple Touch Icon -->
	<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/images/logo.jpg') }}">

	<!-- Favicon -->
	<link rel="icon" href="{{ asset('assets/images/logo.jpg') }}" type="image/x-icon">
	<link rel="shortcut icon" href="{{ asset('assets/images/logo.jpg') }}" type="image/x-icon">

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
        :root{
            --field-bg:#fff;
            --field-muted:#000c03;
            --field-border:#e5e7eb;
            --field-radius:12px;
            --ring:#579459; /* vert Zaly */
            --ring-shadow:0 0 0 3px rgba(87,148,89,.25);
        }
        @media (prefers-color-scheme: dark){
            :root{
            --field-bg:#f0e8fd;
            --field-muted:#000204;
            --field-border:rgba(174, 171, 171, 0.14);
            --ring-shadow:0 0 0 3px rgba(87,148,89,.35);
            }
        }

        label,.form-label{font-weight:600;}
        input[type="text"],input[type="email"],input[type="password"],input[type="tel"],input[type="number"],textarea,select,
        .form-control,.form-select{
            background:var(--field-bg); ;
            border:1px solid var(--field-border); border-radius:var(--field-radius);
            padding:.75rem .9rem; line-height:1.3; outline:none;
            transition:border-color .15s, box-shadow .15s, background-color .2s;
        }
        input::placeholder,textarea::placeholder{color:var(--field-muted)}
        input:focus,textarea:focus,select:focus,
        .form-control:focus,.form-select:focus{
            border-color:var(--ring); box-shadow:var(--ring-shadow);
        }
        .help,.form-text{color:var(--field-muted);font-size:.85rem}
        .error,.invalid-feedback{color:#ef4444;font-weight:500;font-size:.875rem;margin-top:.35rem}
        .is-invalid,.form-control.is-invalid{border-color:#ef4444;box-shadow:0 0 0 3px rgba(239,68,68,.15)}
        .is-valid,.form-control.is-valid{border-color:#10b981;box-shadow:0 0 0 3px rgba(16,185,129,.15)}

        /* Checkbox / radio */
        .form-check-input{
            width:1.05rem;height:1.05rem;border-radius:.35rem;
            border:1px solid var(--field-border); background:var(--field-bg);
        }
        .form-check-input:checked{background-color:var(--ring);border-color:var(--ring)}
        .form-check-input:focus{box-shadow:var(--ring-shadow)}

        /* Disabled & autofill */
        :disabled,.form-control:disabled,.form-select:disabled{background:rgba(148,163,184,.08);color:#94a3b8;cursor:not-allowed}
        input:-webkit-autofill{ transition: background-color 9999s ease-in-out 0s; }
    </style>

</head>
<body>
    <div id="global-loader" style="display: none;">
		<div class="page-loader"></div>
	</div>

	<!-- Main Wrapper -->
	<div class="main-wrapper">
        @include('backend.layouts.header')
        @include('backend.event.layouts.sidebar')
		<!-- Page Wrapper -->
		<div class="page-wrapper">
			<div class="content">
                @yield('content')
            </div>
            @include('backend.layouts.footer')
        </div>
        <!-- /Page Wrapper -->
        @include('backend.layouts.addons')
    </div>
	<!-- /Main Wrapper -->
    @include('backend.layouts.scripts')
</body>
</html>

