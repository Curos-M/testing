<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{env('APP_NAME')}} | {!! $title !!} </title>

  <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
  <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
  <link href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}" id="app-style" rel="stylesheet" type="text/css">
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
      <div class="container-fluid">
      <div class="card card-default color-palette-box">
        <div class="card-body">
          @yield('content')
        </div>
      </div>
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
