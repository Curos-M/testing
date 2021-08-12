@extends('partials.form')
<?php $read = isset($data->id) ? 'readonly' : null; ?> 
@section('css-form')
@endsection

@section('content-form')
<div class="col-md-12">
  <form class="needs-validation" method="POST" action="{{ url('/kader') }}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <input type="hidden" id="id" name="id" value="{{ old('id', $data->id) }}" />
    <div class="row">
      <div class="form-group col-md-6">
        <label for="exampleInputEmail1">Nama Lengkap</label>
        <input type="text" required class="form-control" value="{{old('nama_lengkap', $data->nama_lengkap)}}" name="nama_lengkap" id="1" placeholder="Nama Lengkap">
      </div>
      <div class="form-group col-md-6">
        <label for="exampleInputPassword1">Nama Panggilan</label>
        <input type="text" required class="form-control" value="{{old('nama_panggilan', $data->nama_panggilan)}}" name="nama_panggilan" placeholder="Nama Panggilan">
      </div>
      <div class="col-md-6 form-group">
        <div class="row">
          <div class="col-md-12"><label for="exampleInputPassword1">Tempat dan Tanggal Lahir</label></div>
          <div class="col-md-4">
            <input type="text" required class="form-control" value="{{old('tempat_lahir', $data->tempat_lahir)}}" name="tempat_lahir" placeholder="Tempat Lahir">
          </div>
          <div class="col-md-8">
            <input type="text" class="form-control date" value="{{old('tanggal_lahir', $data->tanggal_lahir)}}" readonly name="tanggal_lahir" placeholder="Tanggal Lahir">
          </div>
        </div>
      </div>
      <div class="form-group col-md-6 row">
        <div class="col-12">
          <label for="exampleInputPassword1">Jenis Kelamin</label>
        </div>
        <div class="custom-control custom-radio col-4 ml-3">
          <input class="custom-control-input" {{old('jenis_kelamin', $data->jenis_kelamin) == '1' ?'checked': ''}} value="1" type="radio" id="Radio1" name="jenis_kelamin">
          <label for="Radio1" class="custom-control-label">Laki-laki</label>
        </div>
        <div class="custom-control custom-radio col-5">
          <input class="custom-control-input" {{old('jenis_kelamin', $data->jenis_kelamin) == '0' ?'checked': ''}} value="0" type="radio" id="Radio2" name="jenis_kelamin">
          <label for="Radio2" class="custom-control-label">Perempuan</label>
        </div>
      </div>
      <div class="form-group col-md-6">
        <label for="exampleInputPassword1">Pendidikan Terakhir</label>
        <select required class="form-control" name="pendidikan">
          <option></option>
          <option {{old('pendidikan', $data->pendidikan) == 'SD' ?'selected': ''}}>SD</option>
          <option {{old('pendidikan', $data->pendidikan) == 'SLTP' ?'selected': ''}}>SLTP</option>
          <option {{old('pendidikan', $data->pendidikan) == 'SLTA' ?'selected': ''}}>SLTA</option>
          <option {{old('pendidikan', $data->pendidikan) == 'D1/D2/D3' ?'selected': ''}}>D1/D2/D3</option>
          <option {{old('pendidikan', $data->pendidikan) == 'S1' ?'selected': ''}}>S1</option>
        </select>
      </div>
      <div class="form-group col-md-6">
        <label for="exampleInputPassword1">Pekerjaan/Profesi</label>
        <input required type="text" class="form-control" value="{{old('job', $data->job)}}" name="job" placeholder="Pekerjaan/Profesi">
      </div>
      <div class="form-group col-md-12">
        <div class="row">
          <div class="col-md-12"><label for="exampleInputPassword1">Alamat</label></div>   
          <div class="col-md-3">    
            <select required class="form-control selectbs4" name="regencies_id" id="kota"></select>
          </div>
          <div class="col-md-3">    
            <select required class="form-control selectbs4" {{isset($data->districts_id) ? '':'disabled'}} name="districts_id"  id="kecamatan"></select>
          </div>
          <div class="col-md-3">    
            <select required class="form-control selectbs4" {{isset($data->villages_id) ? '':'disabled'}} id="desa" name="villages_id"></select>
          </div>
          <div class="col-md-3">    
            <input required type="text" class="form-control" value="{{old('alamat', $data->alamat)}}" name="alamat" placeholder="Alamat">
          </div>
        </div>
      </div>
      <div class="form-group col-md-6">
        <label for="exampleInputPassword1">Nomor HP</label>
        <input required type="text" class="form-control" value="{{old('telp', $data->telp)}}" name="telp" placeholder="Nomor HP">
      </div>
      <div class="form-group col-md-6">
        <label for="exampleInputPassword1">Awal Keanggotaan</label>
        <input type="text" id="awal_anggota" readonly class="form-control date" value="{{old('awal_anggota', $data->awal_anggota)}}" name="awal_anggota">
      </div>
      <div class="form-group col-md-6">
        <label for="exampleInputPassword1">Jenjang Keanggotaan</label>
        <input required type="text" class="form-control" value="{{old('jenjang_anggota', $data->jenjang_anggota)}}" name="jenjang_anggota" placeholder="Jenjang Keanggotaan">
      </div>
      <div class="col-md-6">
        <div class="row">
          <div class="col-md-12"><label for="exampleInputPassword1">Usia Jenjang Keanggotaan</label></div>     
          <div class="form-group col-md-12">
            <input required type="text" class="form-control" value="{{old('usia_jenjang', $data->usia_jenjang)}}" name="usia_jenjang" placeholder="Usia Jenjang Keanggotaan">
          </div>
        </div>
      </div>
      <div class="form-group col-md-6">
        <label for="exampleInputPassword1">Jumlah Binaan</label>
        <input type="number" class="form-control" value="{{old('binaan', $data->binaan)}}" name="binaan" placeholder="Jumlah Binaan">
      </div>
      <div class="form-group col-md-6">
        <label for="exampleInputPassword1">Golongan Darah</label>
        <select class="form-control" name="darah">
          <option>-</option>
          <option {{old('darah', $data->darah) == 'A' ?'selected': ''}}>A</option>
          <option {{old('darah', $data->darah) == 'B' ?'selected': ''}}>B</option>
          <option {{old('darah', $data->darah) == 'AB' ?'selected': ''}}>AB</option>
          <option {{old('darah', $data->darah) == 'O' ?'selected': ''}}>O</option>
        </select>
      </div>
      <div class="form-group col-md-6">
        <label for="exampleInputPassword1">Status Pernikahan</label>
        <select class="form-control" id="status" name="status_pernikahan">
          <option>Belum Kawin</option>
          <option {{old('status_pernikahan', $data->status_pernikahan) == 'Kawin' ?'selected': ''}}>Kawin</option>
          <option {{old('status_pernikahan', $data->status_pernikahan) == 'Cerai Hidup' ?'selected': ''}}>Cerai Hidup</option>
          <option {{old('status_pernikahan', $data->status_pernikahan) == 'Cerai Mati' ?'selected': ''}}>Cerai Mati</option>
        </select>
      </div>
      <div class="form-group col-md-6">
        <label for="exampleInputPassword1">Nama Pasangan</label>
        <input type="text" id="pasangan" {{$data->status_pernikahan != 'Kawin' ? "disabled" : " "}} class="form-control" value="{{old('nama_pasangan', $data->nama_pasangan)}}" name="nama_pasangan" placeholder="Nama Pasangan">
      </div>
      <div class="form-group col-md-12">
        <label for="exampleInputPassword1">Amanah/Kontribusi Anggota</label>
        <textarea class="form-control" name="amanah" placeholder="Amanah/Kontribusi Anggota">{{old('amanah', $data->amanah)}}</textarea>
      </div>
      <div class="form-group col-md-12">
        <label for="exampleInputPassword1">Foto</label>
        <input type="file" class="custom-file-input" id="customFile">
        <label class="custom-file-label" for="customFile">Choose file</label>
      </div>
    </div>
    <button type="submit" class="btn btn-primary float-right">Submit</button>
  </form> 
</div>
@endsection

@section('js-form')
<script>

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
  $('[data-disable-touch-keyboard]').attr('readonly', 'readonly');
  bsCustomFileInput.init()
  $('.date').daterangepicker({
    singleDatePicker: true,
    showDropdowns: true,
    minYear: 1901,
  });
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

  $('#kota').append("<option value={{$data->regencies_id}}>{{$data->kota}}</option>");
  $('#kecamatan').append('<option value={{$data->districts_id}}>{{$data->camat}}</option>');
  $('#desa').append('<option value={{$data->villages_id}}>{{$data->desa}}</option>');

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

  $('#status').on('change', function(){
    
    if(this.value == "Kawin"){
      $('#pasangan').removeAttr('disabled')
      $('#pasangan').val('')
    }else{
      $('#pasangan').attr('disabled', true)
      $('#pasangan').val('')
    }
  })

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
  
});
</script>
@endsection