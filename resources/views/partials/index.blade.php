<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{env('APP_NAME')}} | {!! $title !!} </title>

  <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
  <link href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}" id="app-style" rel="stylesheet" type="text/css">
  <link rel="icon" type="image/png" href="{{url('img/PKS_logo_lte.png')}}">
  <style>

    .bootstrap-switch-dpd {
    background: #fd5000;
    color: #fff;
    }
    .custom-control-input:checked~.custom-control-label::before{
      background-color:#FD5000 !important;
    }
    textarea:focus,
    select:focus,
    input[type="text"]:focus,
    input[type="password"]:focus,
    input[type="datetime"]:focus,
    input[type="datetime-local"]:focus,
    input[type="date"]:focus,
    input[type="month"]:focus,
    input[type="time"]:focus,
    input[type="week"]:focus,
    input[type="number"]:focus,
    input[type="email"]:focus,
    input[type="url"]:focus,
    input[type="search"]:focus,
    input[type="tel"]:focus,
    input[type="color"]:focus,
    .uneditable-input:focus {   
      border-color: rgba(253, 80, 0, 0.8) !important;
      box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset, 0 0 8px rgba(253, 80, 0, 0.6) !important;
      outline: 0 none !important;
    }
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }

/* Firefox */
    input[type=number] {
      -moz-appearance: textfield;
    }
    .select2-container--bootstrap4 .select2-results__option--highlighted, .select2-container--bootstrap4 .select2-results__option--highlighted.select2-results__option[aria-selected="true"] {
      color: #fff;
      background-color: #FD5000 !important;
    }   
    .select2-container--bootstrap4.select2-container--focus .select2-selection {
      border-color: #FD5000 !important;
      border-top-color: rgb(253, 80, 0) !important;
      border-right-color: rgb(253, 80, 0) !important;
      border-bottom-color: rgb(253, 80, 0) !important;
      border-left-color: rgb(253, 80, 0) !important;
      -webkit-box-shadow: 0 0 0 0.2rem rgb(253 80 0 / 25%) !important;
      box-shadow: 0 0 0 0.2rem rgb(253 80 0 / 25%) !important;
    }
    .flatpickr-day.selected, .flatpickr-day.startRange, .flatpickr-day.endRange, .flatpickr-day.selected.inRange, .flatpickr-day.startRange.inRange, .flatpickr-day.endRange.inRange, .flatpickr-day.selected:focus, .flatpickr-day.startRange:focus, .flatpickr-day.endRange:focus, .flatpickr-day.selected:hover, .flatpickr-day.startRange:hover, .flatpickr-day.endRange:hover, .flatpickr-day.selected.prevMonthDay, .flatpickr-day.startRange.prevMonthDay, .flatpickr-day.endRange.prevMonthDay, .flatpickr-day.selected.nextMonthDay, .flatpickr-day.startRange.nextMonthDay, .flatpickr-day.endRange.nextMonthDay {
      background: #FD5000;
      background-color: rgb(253, 80, 0) !important;
      color: #fff;
      border-color: #FD5000 !important;
      border-top-color: rgb(253, 80, 0) !important;
      border-right-color: rgb(253, 80, 0) !important;
      border-bottom-color: rgb(253, 80, 0) !important;
      border-left-color: rgb(253, 80, 0) !important;
    }
    .sidebar-light-orange .nav-sidebar>.nav-item>.nav-link.active {
      background-color: #fd5000;
      color: #ffffff;
    }
    .sidebar-light-orange .nav-sidebar>.nav-item>.nav-link:not(.active)>.fas {
      color: #fd5000;
    }
    .orange {
      color: #fd5000;
    }
    a {
    color: #fd5000;
      text-decoration: none;
      background-color: transparent;
    }
    a:hover {
      color: #cd5000;
      text-decoration: none;
    }
    .page-item.active .page-link {
      z-index: 3;
      color: #fff;
      background-color: #fd5000;
      border-color: #fd5000;
    }
    .btn-dpd{
      background-color: #FD5000;
      color: #fff;
      border-top-color: rgb(253, 80, 0);
      border-right-color: rgb(253, 80, 0);
      border-bottom-color: rgb(253, 80, 0);
      border-left-color: rgb(253, 80, 0);
    }
    .btn-black {
      color: #fff;
      background-color: #000000;
      border-color: #000000;
      box-shadow: none;
    }
    .btn-black:hover {
      color: #fff;
      background-color: #5a6268;
      border-color: #545b62;
    }
    .btn-dpd:hover {
      color: #fff;
      background-color: #C85000;
      border-color: #C85000;
      border-top-color: rgb(200, 80, 0);
      border-right-color: rgb(200, 80, 0);
      border-bottom-color: rgb(200, 80, 0);
      border-left-color: rgb(200, 80, 0);
    }
    .yearpicker-items.selected {
      color: rgb(253, 80, 0) !important;
    }
    .yearpicker-items:hover {
      color: rgb(253, 80, 0) !important;
    }
    .table thead th {
      vertical-align: bottom;
      border-bottom: 5px solid #fd5000;
    }
    .table-bordered td, .table-bordered th {
      border: 0px solid #dee2e6;
    }
    .bg-dpd {
      background-color: #fd5000!important;
    }
    .bg-dpd, .bg-dpd>a {
      color: #fff!important;
    }
    [class*=sidebar-light] .brand-link {
      border-bottom: 3px solid #000000;
    }
    .main-header {
      border-bottom: 3px solid #fd5000;
    }
    table.dataTable.dtr-inline.collapsed>tbody>tr>td.dtr-control:before, table.dataTable.dtr-inline.collapsed>tbody>tr>th.dtr-control:before {
      background-color: #fd5000 !important;
    }
    table.dataTable.dtr-inline.collapsed>tbody>tr.parent>td.dtr-control:before, table.dataTable.dtr-inline.collapsed>tbody>tr.parent>th.dtr-control:before {
      background-color: #000000 !important;
    }
    .page-link:hover {
      color: #cd5000;
    }
    .page-link {
      color: #fd5000;
    }
    .table-striped tbody tr:nth-of-type(odd) {
      background-color: #fd500012;
    }

  </style>
  @yield('css')
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

  @include('partials.topbar')
  @include('partials.sidebar')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('partials.header')
    <section class="content">
      @if ($errors->any())
        <div class="alert alert-danger">
          <strong><i class="mdi mdi-bell-remove font-size-22 align-middle me-1"></i>  Kesalahan!</strong>
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif
      @if (Session::get('success'))
        <div class="alert alert-success alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">&times;</button>
          <strong><i class="mdi mdi-bell-check-outline font-size-22 align-middle me-1"></i></strong> {{ Session::get('success') }}
        </div>
      @endif
      @if (Session::get('warning'))
        <div class="alert alert-warning" role="alert">
          <strong><i class="mdi mdi-bell-check-outline font-size-22 align-middle me-1"></i></strong> {{ Session::get('warning') }}
        </div>
      @endif
      @if (Session::get('error'))
        <div class="alert alert-danger" role="alert">
          <strong><i class="mdi mdi-bell-check-outline font-size-22 align-middle me-1"></i></strong> {{ Session::get('error') }}
        </div>
      @endif
      @yield('content')
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  @include('partials.footer')
</div>
<div class="modal fade" id="appModal" data-bs-backdrop="static"
  data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle"></h5>
        <button type="button" class="close" data-dismiss="modal"
          aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary modal-action-close" data-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-danger d-none modal-action-delete font-bold"><i class="ti-trash"></i>Hapus</button>
        <button type="button" class="btn btn-info d-none modal-action-ok font-bold" data-dismiss="modal">Ok</button>
        <button type="button" class="btn btn-success d-none modal-action-save font-bold">Simpan</button>
        <button id="dpdModal" type="button" class="btn btn-dpd d-none font-bold">Edit</button>
        <!-- <button type="button" class="btn btn-primary">Understood</button> -->
      </div>
    </div>
  </div>
</div>
<!-- ./wrapper -->

<!-- script -->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('dist/js/adminlte.min.js')}}"></script>
<script src="{{asset('dist/js/demo.js')}}"></script>
<script src="{{asset('plugins/sweetalert2/sweetalert2.min.js')}}"></script>
<script src="{{asset('js/dpd.js')}}"></script>
@yield('js')
</body>
</html>
