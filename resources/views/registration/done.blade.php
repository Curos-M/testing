<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{env('APP_NAME')}} | Pendaftaran </title>

  <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
  <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
  <style>
    .card-outline.card-dpd {
      border-top-width: 3px;
      border-top-style: solid;
      border-top-color: #FD5000;
    }
    body{
      background-image: url('img/1606659961.png') !important;
    }
    .btn-primary{
      background-color: #FD5000;
      border-top-color: rgb(253, 80, 0);
      border-right-color: rgb(253, 80, 0);
      border-bottom-color: rgb(253, 80, 0);
      border-left-color: rgb(253, 80, 0);
    }
    .btn-primary:hover {
      color: #fff;
      background-color: #C85000;
      border-color: #C85000;
      border-top-color: rgb(200, 80, 0);
      border-right-color: rgb(200, 80, 0);
      border-bottom-color: rgb(200, 80, 0);
      border-left-color: rgb(200, 80, 0);
    }
  </style>
</head>
<body class="hold-transition login-page">
<div class="col-md-12">
    <section class="content my-5">
        <form class="needs-validation" enctype="multipart/form-data" method="POST" action="{{ url('/registrasi') }}">
          <div class="container-fluid col-xl-9">
            <div  class="card card-outline card-dpd color-palette-box">
              <div class="mx-4 mt-3">
                <div class="row">
                <img class="mx-4" src="{{url('img/PKS_logo.png')}}" width="90">
                <h2 class="mt-4">Form Pendaftaran Anggota <br> Partai Keadilan Sejahtera</h2>
                </div>
              </div>
              <div class="mt-2"><hr style="border-top-width: 4px; border-top-color:#FD5000;"></div>
              <h2 class="mx-5 my-5 text-center">Pendaftaran Berhasil <br> Data anda sudah tersimpan</h2>
              <h4 class="text-center"></h4>
              <a href="{{ url('/') }}" type="button" class="btn btn-primary py-3 mt-3" type="submit">Kembali Ke Halaman Login</a>
            </div>
          </div>
        </form>
    </section>
    <!-- /.content -->

  <!-- /.content-wrapper -->

</div>
<!-- ./wrapper -->

<!-- script -->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('dist/js/adminlte.min.js')}}"></script>
<script src="{{asset('dist/js/demo.js')}}"></script>
<script>
</script>
</body>
</html>
