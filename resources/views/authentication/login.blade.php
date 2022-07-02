<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ env('APP_NAME') }} | Login</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
  <style>
    body{
      background-image: url('img/1606659961.png') !important;
    }
    .btn-dpd{
      background-color: #FD5000;
      color: #fff;
      border-top-color: rgb(253, 80, 0);
      border-right-color: rgb(253, 80, 0);
      border-bottom-color: rgb(253, 80, 0);
      border-left-color: rgb(253, 80, 0);
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
    input[type="text"]:focus,
    input[type="password"]:focus,
    .uneditable-input:focus {   
      border-color: rgba(253, 80, 0, 0.8) !important;
      box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset, 0 0 8px rgba(253, 80, 0, 0.6) !important;
      outline: 0 none !important;
    }
    .card-outline.card-dpd {
      border-top-width: 3px;
      border-top-style: solid;
      border-top-color: #FD5000;
    }
    .icheck-primary>input:first-child:checked+input[type=hidden]+label::before, .icheck-primary>input:first-child:checked+label::before {
      background-color: #FD5000;
      border-color: #FD5000;
    }
    .icheck-primary>input:first-child:not(:checked):not(:disabled):hover+input[type=hidden]+label::before, .icheck-primary>input:first-child:not(:checked):not(:disabled):hover+label::before {
      border-color: #FD5000;
    }
  </style>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-dpd">
  @if (Session::get('errorLogin'))
            <div class="alert alert-solid alert-danger" role="alert">{{ Session::get('errorLogin') }}</div>
          @endif
          @if ($errors->any())
            <div class="alert alert-danger">
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif
    <div class="card-header text-center">
      <h1><b>{{ env('APP_NAME') }}</b></h1>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Masuk Untuk Melanjutkan</p>

      <form action="{{ url('login') }}" method="post">
        <div class="input-group mb-3">
          <input type="hidden" name="_token" value="{{ csrf_token() }}" />
          <input type="text" name="username" class="form-control" placeholder="Username">
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" placeholder="Password">
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember" name="remember">
              <label for="remember">
                Ingat Saya
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-dpd btn-block">Masuk</button>
          </div>
          @if(env('APP_OPENREG'))
            <div class="col-12 my-2">
            <a href="{{ url('/registrasi') }}" type="button" class="btn btn-dpd" style="width: 100%;" type="submit">Pendaftaran</a>
            </div>
          @endif
          <!-- /.col -->
        </div>
      </form>

    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('dist/js/adminlte.min.js')}}"></script>
</body>
</html>
