<meta charset="utf-8" />
<title>{{ ( isset($menuTitle) ) ? $menuTitle . ' | ' : '' }} {{ config('app.name') }}</title>
<meta content="width=device-width, initial-scale=1, maximum-scale=5, shrink-to-fit=no" name="viewport">
<meta content="Apparel One Indonesia - BBI Group" name="description" />
<meta content="ICT Departement" name="author" />
<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- App favicon -->
<link rel="shortcut icon" href="{{ asset('favicon.png') }}">

<!-- Layout config Js -->
<script src="{{ asset('assets/js/layout.js') }}"></script>
<!-- Bootstrap Css -->
<link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />

<link async href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- Sweet Alert css-->
<link href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
<!-- Icons Css -->
<link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" />
<link href="{{ asset('/plugin/datepicker-1.9.0/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
<!-- App Css-->
<link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
<!-- custom Css-->
<link href="{{ asset('css/custom.css?v=' . rand(1,9)) }}" rel="stylesheet" type="text/css" />


@stack('style-default')