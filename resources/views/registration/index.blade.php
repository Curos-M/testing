<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{env('APP_NAME')}} | Pendaftaran </title>

  <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
  <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
  <link rel="stylesheet" href="{{asset('css/flatpickr.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/select2/css/select2.min.css')}}">
  <link rel="stylesheet" href="{{asset('css/file-preview.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
  <style>
    .agtImg {
      max-width: 170px;
      margin: 0 auto;
      overflow: hidden;
    }
    .ktpImg {
      max-width: 400px;
      margin: 0 auto;
      overflow: hidden;
    }
    .card-outline.card-dpd {
      border-top-width: 3px;
      border-top-style: solid;
      border-top-color: #FD5000;
    }
    .custom-control-input:checked~.custom-control-label::before{
      background-color:#FD5000;
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
    .select2-container--bootstrap4 .select2-results__option--highlighted, .select2-container--bootstrap4 .select2-results__option--highlighted.select2-results__option[aria-selected="true"] {
      color: #fff;
      background-color: #FD5000;
    }   
    .select2-container--bootstrap4.select2-container--focus .select2-selection {
      border-color: #FD5000;
      border-top-color: rgb(253, 80, 0);
      border-right-color: rgb(253, 80, 0);
      border-bottom-color: rgb(253, 80, 0);
      border-left-color: rgb(253, 80, 0);
      -webkit-box-shadow: 0 0 0 0.2rem rgb(253 80 0 / 25%);
      box-shadow: 0 0 0 0.2rem rgb(253 80 0 / 25%);
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
    .flatpickr {
      background-color: #ffffff !important ;
    }
    .flatpickr-day.selected, .flatpickr-day.startRange, .flatpickr-day.endRange, .flatpickr-day.selected.inRange, .flatpickr-day.startRange.inRange, .flatpickr-day.endRange.inRange, .flatpickr-day.selected:focus, .flatpickr-day.startRange:focus, .flatpickr-day.endRange:focus, .flatpickr-day.selected:hover, .flatpickr-day.startRange:hover, .flatpickr-day.endRange:hover, .flatpickr-day.selected.prevMonthDay, .flatpickr-day.startRange.prevMonthDay, .flatpickr-day.endRange.prevMonthDay, .flatpickr-day.selected.nextMonthDay, .flatpickr-day.startRange.nextMonthDay, .flatpickr-day.endRange.nextMonthDay {
      background: #FD5000;
      background-color: rgb(253, 80, 0);
      color: #fff;
      border-color: #FD5000;
      border-top-color: rgb(253, 80, 0);
      border-right-color: rgb(253, 80, 0);
      border-bottom-color: rgb(253, 80, 0);
      border-left-color: rgb(253, 80, 0);
    }
    body{
      background-image: url('img/1606659961.png') !important;
    }
  </style>
</head>
<body class="hold-transition login-page">
  
<!-- Site wrapper -->
<div class="col-md-12">
    <section class="content my-5">
        <form class="needs-validation" enctype="multipart/form-data" method="POST" action="{{ url('/registrasi') }}">
          <div class="container-fluid col-xl-9">
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
            <div  class="card card-outline card-dpd color-palette-box">
              <div class="mx-4 mt-3">
                <div class="row">
                <img class="mx-4" src="{{url('img/PKS_logo.png')}}" width="90">
                <h2 class="mt-4">Form Pendaftaran Anggota <br> Partai Keadilan Sejahtera</h2>
                </div>
                <a href="{{ url('/') }}" type="button" class="btn btn-dpd float-right">Kembali</a>
              </div>
              <div class="mt-2"><hr style="border-top-width: 4px; border-top-color:#FD5000;"></div>
              <div class="card-body">
                <div class="col-md-12">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                  <div class="row">
                    <div class="form-group col-md-12">
                      <label for="exampleInputEmail1">NIK / No. KTP</label>
                      <input type="number" class="form-control" value="{{old('nik')}}" name="nik" placeholder="Nomor Induk Kependudukan">
                    </div>
                    <div class="form-group col-md-6">
                      <label for="exampleInputEmail1">Nama Lengkap</label>
                      <input type="text" required class="form-control" value="{{old('nama_lengkap')}}" name="nama_lengkap" id="1" placeholder="Nama Lengkap">
                    </div>
                    <div class="form-group col-md-6">
                      <label for="exampleInputPassword1">Nama Panggilan</label>
                      <input type="text" required class="form-control" value="{{old('nama_panggilan')}}" name="nama_panggilan" placeholder="Nama Panggilan">
                    </div>
                    <div class="col-md-6 form-group">
                      <div class="row">
                        <div class="col-md-12"><label for="exampleInputPassword1">Tempat dan Tanggal Lahir</label></div>
                        <div class="col-md-7">
                          <input type="text" required class="form-control" value="{{old('tempat_lahir')}}" name="tempat_lahir" placeholder="Tempat Lahir">
                        </div>
                        <div class="col-md-5">
                          <input class="form-control flatpickr flatpickr-input" required id="tanggal_lahir" value="{{old('tanggal_lahir')}}" name="tanggal_lahir" placeholder="Tanggal Lahir">
                        </div>
                      </div>
                    </div>
                    <div class="form-group col-md-6">
                      <div class="row">
                        <div class="col-12 mb-1">
                          <label for="exampleInputPassword1">Jenis Kelamin</label>
                        </div>
                        <div class="custom-control custom-radio col-4 ml-3">
                          <input class="custom-control-input custom-control-input-danger" {{old('jenis_kelamin') == '1' ?'checked': ''}} value="1" type="radio" id="Radio1" name="jenis_kelamin">
                          <label for="Radio1" class="custom-control-label">Laki-laki</label>
                        </div>
                        <div class="custom-control custom-radio col-5">
                          <input class="custom-control-input custom-control-input-danger" {{old('jenis_kelamin') == '0' ?'checked': ''}} value="0" type="radio" id="Radio2" name="jenis_kelamin">
                          <label for="Radio2" class="custom-control-label">Perempuan</label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group col-md-6">
                      <label for="exampleInputPassword1">Pendidikan Terakhir</label>
                      <select required class="form-control" name="pendidikan">
                        <option></option>
                        <option {{old('pendidikan') == 'SD' ?'selected': ''}}>SD</option>
                        <option {{old('pendidikan') == 'SLTP' ?'selected': ''}}>SLTP</option>
                        <option {{old('pendidikan') == 'SLTA' ?'selected': ''}}>SLTA</option>
                        <option {{old('pendidikan') == 'D1/D2/D3' ?'selected': ''}}>D1/D2/D3</option>
                        <option {{old('pendidikan') == 'S1' ?'selected': ''}}>S1</option>
                        <option {{old('pendidikan') == 'S2' ?'selected': ''}}>S2</option>
                        <option {{old('pendidikan') == 'S3' ?'selected': ''}}>S3</option>
                      </select>
                    </div>
                    <div class="form-group col-md-6">
                      <label for="exampleInputPassword1">Pekerjaan/Profesi</label>
                      <input required type="text" class="form-control" value="{{old('job')}}" name="job" placeholder="Pekerjaan/Profesi">
                    </div>
                    <div class="form-group col-md-6">
                      <label for="exampleInputPassword1">Nomor HP</label>
                      <input required type="number" class="form-control" value="{{old('telp')}}" name="telp" placeholder="Nomor HP">
                    </div>
                    <div class="form-group col-md-6">
                      <label for="exampleInputPassword1">Golongan Darah</label>
                      <select required class="form-control" name="darah">
                        <option>-</option>
                        <option {{old('darah') == 'A' ?'selected': ''}}>A</option>
                        <option {{old('darah') == 'B' ?'selected': ''}}>B</option>
                        <option {{old('darah') == 'AB' ?'selected': ''}}>AB</option>
                        <option {{old('darah') == 'O' ?'selected': ''}}>O</option>
                      </select>
                    </div>
                    <div class="form-group col-md-12">
                      <div class="row">
                        <div class="col-md-12"><label for="exampleInputPassword1">Alamat</label></div>   
                        <div class="col-md-4">    
                          <select required class="form-control selectbs4" style="width: 100%;" name="regencies_id" id="kota"></select>
                        </div>
                        <div class="col-md-4">    
                          <select required disabled class="form-control selectbs4" style="width: 100%;" name="districts_id"  id="kecamatan"></select>
                        </div>
                        <div class="col-md-4 mb-3">    
                          <select required disabled class="form-control selectbs4" style="width: 100%;" id="desa" name="villages_id"></select>
                        </div>
                        <div class="col-md-12">    
                          <textarea required type="text" class="form-control"name="alamat" placeholder="Alamat">{{old('alamat')}}</textarea>
                        </div>
                      </div>
                    </div>      
                    <div class="form-group col-md-12">
                      <label for="exampleInputPassword1">Direkomendasikan Oleh</label>
                      <input type="text" class="form-control" value="{{old('rekomendasi')}}" name="rekomendasi" placeholder="Direkomendasikan oleh (Opsional)">
                    </div>         
                    <div class="custom-file-container col-md-6 form-group" data-upload-id="myFirstImage1">
                      <label>Foto KTP <a href="javascript:void(0)" class="custom-file-container__image-clear" id="imgKtp" style="color: #FD5000;" title="Clear Image">&nbsp;&times;</a></label>
                      <label class="custom-file-container__custom-file mb-3 mt-1" >
                        <input type="file" name="file1" class="form-control custom-file-container__custom-file__custom-file-input" accept="image/*">
                        <span class="custom-file-container__custom-file__custom-file-control"></span>
                      </label>
                      <div class="custom-file-container__image-preview ktpImg"></div>
                    </div>
                    <div class="custom-file-container col-md-6 form-group" data-upload-id="myFirstImage">
                      <label>Foto Diri <a href="javascript:void(0)" class="custom-file-container__image-clear" id="imgAnggota" style="color: #FD5000;" title="Clear Image">&times;</a></label>
                      <label class="custom-file-container__custom-file mt-1 mb-3" >
                        <input type="file" name="file" class="form-control custom-file-container__custom-file__custom-file-input" accept="image/*">
                        <span class="custom-file-container__custom-file__custom-file-control"></span>
                      </label>
                      <div class="custom-file-container__image-preview agtImg"></div>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-dpd float-right ml-2 mt-3">Kirim Data</button>
                </div>
              </div>
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
<script src="{{asset('js/dpd.js')}}"></script>
<script src="{{asset('js/flatpickr.js')}}"></script>
<script src="{{asset('js/id.js')}}"></script>
<script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
<script src="{{asset('js/file-preview.js')}}"></script>
<script src="{{asset('plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}"></script>
<script>
flatpickr(".flatpickr",{"locale": "id"})
let camat = function(){
  var id = $('#kota').val()  
  $('#kecamatan').select2({
    theme: 'bootstrap4',
    allowClear: true,
    placeholder: 'Kecamatan',
    width: 'resolve',
    minimumResultsForSearch: Infinity,
    ajax: {
      url: "{{url('district')}}",
      dataType: 'json',
      data:{regency_id : id },
      delay: 250,
      processResults: function (data) {
        return {
          results:  $.map(data, function (item) {
            return {
              text: item.name,
              id: item.id
            }
          })
        };
      },
      cache: false,
    }
  })
}

let desa = function(){
  var id2 = $('#kecamatan').val() 
  $('#desa').select2({
    theme: 'bootstrap4',
    allowClear: true,
    placeholder: 'Desa/Kelurahan',
    width: 'resolve',
    minimumResultsForSearch: Infinity,
    ajax: {
      url: "{{url('village')}}",
      dataType: 'json',
      data:{district_id : id2},
      delay: 250,
      processResults: function (data) {
        console.log(data)
        return {
          results:  $.map(data, function (item) {
            return {
              text: item.name,
              id: item.id
            }
          })
        };
      },
      cache: false,
    }
  })
}

$(document).ready(function (){
  $('#kota').on('change', function(){
    if(this.value){
      $('#kecamatan').removeAttr('disabled')
      $('#kecamatan').val('')
      $('#desa').val('')
    }else{
      $('#kecamatan').val('')
      $('#desa').val('')
      $('#kecamatan').attr('disabled', true)
      $('#desa').attr('disabled', true)
    }
    camat()
    desa()
  })

  $('#kecamatan').on('change', function(){
    if(this.value){
      $('#desa').removeAttr('disabled')
      $('#desa').val('')
    }else{
      $('#desa').attr('disabled', true)
      $('#desa').val('')
    }
    desa()
  })

  flatpickr($('.flatpickr'), {
      altFormat: "d-m-Y",
      altInput: true,
      dateFormat: "Y-m-d",
      locale: "id"
  })
  var firstUpload = new FileUploadWithPreview('myFirstImage', {
    text: {
      chooseFile: "Cari Foto",
    }
  })
  var firstUpload1 = new FileUploadWithPreview('myFirstImage1', {
    text: {
      chooseFile: "Cari Foto",
    }
  })
  $('#kota').select2({
    theme: 'bootstrap4',
    allowClear: true,
    placeholder: 'Kota/Kabupaten',
    width: 'resolve',
    minimumResultsForSearch: Infinity,
    ajax: {
      url: "{{url('regency')}}",
      dataType: 'json',
      delay: 250,
      processResults: function (data) {
        return {
          results:  $.map(data, function (item) {
            return {
              text: item.name,
              id: item.id
            }
          })
        };
      },
      cache: false,
    }
  })
  $('#kecamatan').select2({
    theme: 'bootstrap4',
    allowClear: true,
    placeholder: 'Kecamatan',
    width: 'resolve'
  })
  $('#desa').select2({
    theme: 'bootstrap4',
    allowClear: true,
    placeholder: 'Desa/Kelurahan',
    width: 'resolve'
  })

})
</script>
</body>
</html>
