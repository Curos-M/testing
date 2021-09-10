@extends('partials.form')
<?php 
$read = isset($data->id) ? 'readonly' : null;
$disabled = isset($data->id) ? 'disabled' : null;
$notDisabled = !isset($data->id) ? 'disabled' : null;
$verifRead = $data->verif ? 'readonly' : null;
$verifDisabled = $data->verif ? 'disabled' : null;
 ?>  
@section('css-form')
<link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
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
</style>
@endsection

@section('content-form')
<div class="row">
  @if ($data->verif_user)
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Riwayat</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" aria-controls="riwayat" data-toggle="collapse" aria-expanded="false" data-target="#riwayat" title="Collapse">
              <i class="fas fa-window-minimize"></i>
            </button>
          </div>
        </div>
        <div class="collapse" id="riwayat">
          <div class="card-body">
            <div class="row">
              <div class="col-6">
                <span class="text-muted">Diverifikasi Oleh :</span>
                <br>
                <span class="font-weight-normal">&nbsp;{{$data->verif_user}} - {{$data->verif_date}}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  @endif
    <div class="container-fluid col-xl-3">
      <div class="card card-default color-pallete-box">
        <div class="card-body">
  <form class="needs-validation" id="formAnggota" enctype="multipart/form-data" method="POST" action="{{ url('/anggota') }}">
          <div class="custom-file-container form-group" data-upload-id="myFirstImage">
            <label>Foto Anggota <a href="javascript:void(0)" class="custom-file-container__image-clear" id="imgAnggota" title="Clear Image">&times;</a></label>
            <label class="custom-file-container__custom-file mt-2 mb-3" >
              <input type="file" name="file" class="form-control custom-file-container__custom-file__custom-file-input" accept="image/*">
              <span class="custom-file-container__custom-file__custom-file-control"></span>
            </label>
            <div class="custom-file-container__image-preview agtImg"></div>
            <hr>
            <input type="hidden" id="photo" name="photo" value="{{$data->photo}}">
          </div>
          <div class="custom-file-container form-group" data-upload-id="myFirstImage1">
            <label>Foto KTP <a href="javascript:void(0)" class="custom-file-container__image-clear" id="imgKtp" title="Clear Image">&nbsp;&times;</a></label>
            <label class="custom-file-container__custom-file mb-3 mt-1" >
              <input type="file" name="file1" class="form-control custom-file-container__custom-file__custom-file-input" accept="image/*">
              <span class="custom-file-container__custom-file__custom-file-control"></span>
            </label>
            <div class="custom-file-container__image-preview ktpImg"></div>
            <input type="hidden" id="ktp" name="ktp" value="{{$data->ktp}}">
          </div>
          <?php $checkedStr = $data->pembina ? 'checked="checked"' : null; ?> 
          <div class="form-group">
            <label for="exampleInputPassword1">Punya Binaan</label>
            <div class="ml-2">
              <input data-on-text="Ya" data-off-text="Tidak" data-bootstrap-switch id="pembina" type="checkbox" name="pembina" data-on-color="dpd" switch="none" {!! $checkedStr !!} >
            </div>
          </div>
          @if($data->pembina)
            <div class="form-group">
            <select class="form-control selectbs4" style="width: 100%;" id="add_binaan"></select>
              <label for="exampleInputPassword1">Anggota Binaan</label>
              <table id="binaan" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <thead>
                  <tr>
                    <th style="width:10%">No</th>
                    <th>Nama</th>
                    <th style="width:10%"></th>
                  </tr>
                </thead>
              </table>
            </div>
          @endif
        </div>
      </div>
    </div>
    <div class="container-fluid col-xl-9">
      <div class="card card-default color-palette-box">
        <div class="card-body">
          <div class="col-md-12">
            @if ($verifDisabled)
              <input type='hidden' name='jenis_kelamin' value='{{$data->jenis_kelamin ? $data->jenis_kelamin : 0}}'>
              <input type='hidden' name='tanggal_lahir' value='{{$data->tanggal_lahir}}'>
              <input type='hidden' name='awal_anggota' value='{{$data->awal_anggota}}'>
              <input type='hidden' name='regencies_id' value='{{$data->regencies_id}}'>
            @endif
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <input type="hidden" id="id" name="id" value="{{ old('id', $data->id) }}" />
            <div class="row">
              <div class="form-group col-md-6 {{$data->verif ? '' : 'd-none'}}">
                <label for="exampleInputEmail1">Nomor Urut Anggota</label>
                <input type="text" disabled class="form-control" value="{{$data->nomor_urut}}" placeholder="Nomor Induk Kependudukan">
              </div>
              <div class="form-group col-md-{{$data->verif ? '6' : '12'}}">
                <label for="exampleInputEmail1">NIK / No. KTP</label>
                <input type="number" {{$verifRead}} class="form-control" value="{{old('nik', $data->nik)}}" name="nik" placeholder="Nomor Induk Kependudukan">
              </div>
              <div class="form-group col-md-6">
                <label for="exampleInputEmail1">Nama Lengkap</label>
                <input type="text" {{$verifRead}} required class="form-control" value="{{old('nama_lengkap', $data->nama_lengkap)}}" name="nama_lengkap" id="1" placeholder="Nama Lengkap">
              </div>
              <div class="form-group col-md-6">
                <label for="exampleInputPassword1">Nama Panggilan</label>
                <input type="text" {{$verifRead}} required class="form-control" value="{{old('nama_panggilan', $data->nama_panggilan)}}" name="nama_panggilan" placeholder="Nama Panggilan">
              </div>
              <div class="col-md-6 form-group">
                <div class="row">
                  <div class="col-md-12"><label for="exampleInputPassword1">Tempat dan Tanggal Lahir</label></div>
                  <div class="col-md-7">
                    <input type="text" {{$verifRead}} required class="form-control" value="{{old('tempat_lahir', $data->tempat_lahir)}}" name="tempat_lahir" placeholder="Tempat Lahir">
                  </div>
                  <div class="col-md-5">
                    <input {{$verifDisabled}} class="form-control flatpickr flatpickr-input {{!$data->verif ? 'flatpickrcolor' : ''}}" id="tanggal_lahir" value="{{old('tanggal_lahir', $data->tanggal_lahir)}}" name="tanggal_lahir" placeholder="Tanggal Lahir">
                  </div>
                </div>
              </div>
              <div class="form-group col-md-6">
                <div class="row">
                  <div class="col-12 mb-1">
                    <label for="exampleInputPassword1">Jenis Kelamin</label>
                  </div>
                  <div class="custom-control custom-radio col-4 ml-3">
                    <input {{$verifDisabled}} class="custom-control-input custom-control-input-danger" {{old('jenis_kelamin', $data->jenis_kelamin) == '1' ?'checked': ''}} value="1" type="radio" id="Radio1" name="jenis_kelamin">
                    <label for="Radio1" class="custom-control-label">Laki-laki</label>
                  </div>
                  <div class="custom-control custom-radio col-5">
                    <input {{$verifDisabled}} class="custom-control-input custom-control-input-danger" {{old('jenis_kelamin', $data->jenis_kelamin) == '0' ?'checked': ''}} value="0" type="radio" id="Radio2" name="jenis_kelamin">
                    <label for="Radio2" class="custom-control-label">Perempuan</label>
                  </div>
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
              <div class="form-group col-md-6">
                <label for="exampleInputPassword1">Nomor HP</label>
                <input required type="number" class="form-control" value="{{old('telp', $data->telp)}}" name="telp" placeholder="Nomor HP">
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
              <div class="form-group col-md-12">
                <div class="row">
                  <div class="col-md-12"><label for="exampleInputPassword1">Alamat</label></div>   
                  <div class="col-md-4">    
                    <select {{$verifDisabled}} required class="form-control selectbs4" style="width: 100%;" name="regencies_id" id="kota"></select>
                  </div>
                  <div class="col-md-4">    
                    <select required {{$notDisabled}} class="form-control selectbs4" style="width: 100%;" name="districts_id"  id="kecamatan"></select>
                  </div>
                  <div class="col-md-4 mb-3">    
                    <select required {{$notDisabled}} class="form-control selectbs4" style="width: 100%;" id="desa" name="villages_id"></select>
                  </div>
                  <div class="col-md-12">    
                    <textarea required type="text" class="form-control"name="alamat" placeholder="Alamat">{{old('alamat', $data->alamat)}}</textarea>
                  </div>
                </div>
              </div>
              <div class="form-group col-md-6">  
                @if($data->id_pembina)
                <div class="row">
                  <div class="col-md-12">
                    <label for="exampleInputPassword1">Nama Pembina/Pembimbing</label>
                  </div>
                  <div class="col-md-12">
                    <input type="hidden" name="hidden_pembina" id="hidden_pembina">
                    <select required class="form-control selectbs4" disabled style="width: 100%;" id="id_pembina" name="id_pembina"></select>
                  </div>
                  <input type="hidden" name='id_pembina' value="{{$data->id_pembina}}">
                  <!-- <div class="col-md-2">
                    <a href="{{ url('/'.$link.'/edit/'.$data->id_pembina) }}" style="width: 100%;" type="button" class="btn btn-warning"><i class="fa fa-address-card"></i></a>
                  </div> -->
                </div>
                @else
                  <label for="exampleInputPassword1">Nama Pembina/Pembimbing</label>
                  <input type="hidden" name="hidden_pembina" id="hidden_pembina">
                  <select class="form-control selectbs4" style="width: 100%;" id="id_pembina" name="id_pembina"></select>
                @endif
              </div>
              <div class="form-group col-md-6">
                <label for="exampleInputPassword1">Awal Keanggotaan</label>
                <input {{$verifDisabled}} type="text" id="awal_anggota" class="form-control flatpickr {{!$data->verif ? 'flatpickrcolor' : ''}} flatpickr-input" value="{{old('awal_anggota', $data->awal_anggota)}}" name="awal_anggota" placeholder="Awal Keanggotaan">
              </div>
              <div class="form-group col-md-6">
                <label for="exampleInputPassword1">Jenjang Keanggotaan</label>
                <select class="form-control" id="jenjang_anggota" name="jenjang_anggota">
                  @foreach ($jenjang as $j )
                    <option value="{{$j->id}}" {{old('jenjang_anggota', $data->jenjang_anggota) == $j->id ?'selected': ''}}>{{$j->nama}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-6">
                <div class="row">
                  <div class="col-md-12"><label for="exampleInputPassword1">Usia Jenjang Keanggotaan</label></div>     
                  <div class="form-group col-md-12">
                    <input required type="text" class="form-control flatpickr flatpickrcolor flatpickr-input" value="{{old('usia_jenjang', $data->usia_jenjang)}}" name="usia_jenjang" placeholder="Usia Jenjang Keanggotaan">
                  </div>
                </div>
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
              @if($data->pasangan_id)
                <div class="row">
                  <div class="col-md-12">
                    <label for="exampleInputPassword1">Nama Pasangan</label>
                  </div>
                  <div class="col-md-10">
                    <input type="hidden" name="hidden_pasangan" id="hidden_pasangan">
                    <select id="pasangan" style="width: 100%;" class="form-control selectbs4" name="pasangan" placeholder="Nama Pasangan" {{$data->status_pernikahan != 'Kawin' ? "disabled" : " "}}></select>
                  </div>
                  <div class="col-md-2">
                    <a href="{{ url('/'.$link.'/edit/'.$data->pasangan_id) }}" style="width: 100%;" type="button" class="btn btn-success"><i class="fa fa-address-card"></i></a>
                  </div>
                </div>
              @else
                <label for="exampleInputPassword1">Nama Pasangan</label>
                <input type="hidden" name="hidden_pasangan" id="hidden_pasangan">
                <select id="pasangan" style="width: 100%;" class="form-control selectbs4" name="pasangan" placeholder="Nama Pasangan" {{$data->status_pernikahan != 'Kawin' ? "disabled" : " "}}></select>
              @endif
              </div>
              <div class="form-group col-md-12">
                <label for="exampleInputPassword1">Amanah/Kontribusi Anggota</label>
                <input type="text" class="form-control" name="amanah" value="{{old('amanah', $data->amanah)}}" placeholder="Amanah/Kontribusi Anggota">
              </div>
            </div>
            <button type="submit" id="subForm" class="btn btn-dpd float-right ml-2 mt-3">Simpan</button>
            <a href="{{ url('/'.$link) }}" type="button" class="btn btn-black float-right mt-3">{{ isset($data->id) ? 'Kembali' : 'Batal' }}</a>
  </form>
            @if (!$data->verif && $data->id)
              <form method="POST" action="{{ url('/anggota/verif').'/'.$data->id }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <input type="hidden" id="id" name="id" value="{{ old('id', $data->id) }}" />
                <button type="submit" class="btn btn-warning ml-2 mt-3">Verifikasi</button>
              </form>
            @endif
          </div>
        </div>
      </div>
      @if($data->id && $data->status_pernikahan != "Belum Kawin")
        <div class="card card-default color-pallete-box">
          <div class="card-body">
            <div class="form-group col-md-12">
              <label class="mb-3" for="exampleInputPassword1">Anak</label>
              <br>
              <a type="button" id="add" class="btn btn-info mb-3">Tambah</a>
              <table id="anak" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <thead>
                  <tr>
                    <th>Nama</th>
                    <th>Tahun Lahir</th>
                    <th>Pendidikan</th>
                    <th>Tarbiyah</th>
                    <th></th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
      @endif
    </div>

</div>

<div class="modal fade" id="anakModal" data-bs-backdrop="static"
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
        <div class="form-group col-md-12">
          <label for="exampleInputEmail1">Nama</label>
          <select class="form-control selectbs4 sModal" style="width: 100%;" id="aNama"></select>
        </div>
        <div class="form-group col-md-12 d-none divMod">
          <label for="exampleInputPassword1">Pendidikan Terakhir</label>
          <input type="hidden" id="aId" class="fModal">
          <select required class="form-control fModal" id="aPendidikan">
            <option></option>
            <option>SD</option>
            <option>SLTP</option>
            <option>SLTA</option>
            <option>D1/D2/D3</option>
            <option>S1</option>
          </select>
        </div>
        <div class="form-group col-md-12 d-none divMod">
          <label for="exampleInputPassword1">Tahun Lahir</label>
          <input type="text" id="aTahun" readonly class="form-control yearpicker fModal">
        </div>
        <div class="form-group col-md-12 row d-none divMod">
          <div class="col-12">
            <label for="exampleInputPassword1">Tarbiyah</label>
          </div>
          <div class="custom-control custom-radio col-4 ml-3">
            <input class="custom-control-input rModal custom-control-input-danger" name="aTarbiyah" value="1" type="radio" id="Radio3">
            <label for="Radio3" class="custom-control-label">Ya</label>
          </div>
          <div class="custom-control custom-radio col-5">
            <input class="custom-control-input rModal custom-control-input-danger" name="aTarbiyah" value="0" type="radio" id="Radio4">
            <label for="Radio4" class="custom-control-label">Tidak</label>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-black modal-action-close" data-dismiss="modal">Batal</button>
        <a type="button" id="addRow" class="btn btn-dpd font-bold d-none divMod">Simpan</a>
        <!-- <button type="button" class="btn btn-primary">Understood</button> -->
      </div>
    </div>
  </div>
</div>
@endsection

@section('js-form')
<script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
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

  $('#add').on('click', function(){
    $('#anakModal').modal('show'); 
    $(".modal-title").html('Tambah Anak')
  })
    
  $(".modal").on("hidden.bs.modal", function(){
    $(".fModal").val("");
    $('.sModal').val(null).trigger('change')
    $(".rModal").prop("checked", false);
  });

  var t = $('#anak').DataTable({
    ajax: {
      url: "{{ url('anak/grid') }}/{{$data->id}}",
      dataSrc: ''
    },
    columns: [
      { 
        data: 'nama',
        searchText: true
      },
      { 
        data: 'tahun_lahir',
        searchText: true
      },
      { 
        data: 'pendidikan',
        searchText: true
      },
      { 
        data: 'tarbiyah',
        searchText: true
      },
      { 
        data:null,
        width:'80px',
        className: 'text-center',
        render: function(data, type, full, meta){
          let icon = "";
            if(!data.anggota){
              icon += '<a title="Edit" type="button" class="btn btn-success btn-sm waves-effect gridEdit modalEdit" id="'+data.id+'"><i class="ti-marker-alt"></i> Edit</a>';
            }else{
              icon += '<a href="{{url("/anggota/edit")}}/' + data.id +'" title="Edit" type="button" class="btn btn-success btn-sm waves-effect gridEdit"><i class="ti-marker-alt"></i> Edit</a>';
            }
            icon += '&nbsp;<a href="#" title="Delete" '
              + 'delete-title="Hapus {{ $title }} ' + data.nama + '" ';
              if(!data.anggota){
                icon += "delete-action='{{ url('/anak') }}"+ '/' + data.id + "'";
              }else{
                icon += "delete-action='{{ url('/anggota/anak') }}"+ '/' + data.id + "'";
              }
              icon += 'delete-message="Apakah anda yakin untuk menghapus data ini?" '
              + 'class="btn btn-danger btn-sm waves-effect gridDelete"><i class="ti-trash"></i> Hapus</a>';
          return icon;
        }
      }
    ],
    dom: '<"row"' +
        '<"col-md-12"<"row"<"col-md-6"B> > >' +
        '<"col-md-12"rt> <"col-md-12"<"row"<"col-md-5"i><"col-md-7"p>>> >',
    oLanguage: {
      oPaginate: { "sPrevious": '<', "sNext": '>' },
      sInfo: "Halaman _PAGE_ dari _PAGES_",
      sLengthMenu: "Hasil :  _MENU_",
    },
    pageLength: 3,
    ordering: false
  });

  $('#anak').on( 'click', '.modalEdit', function () {
    var id = $(this).attr('id')
    $.ajax({
      type:'POST',
      url:"{{url('anak')}}/"+id,
      success: function(data){
        var $option = $("<option selected data-select2-tag='true'></option>").val(data.nama).text(data.nama);
        $('#aNama').append($option).trigger('change');
        $('#aPendidikan').val(data.pendidikan)
        $('#aTahun').val(data.tahun_lahir)
        $('#aId').val(data.id)
        if(data.tarbiyah == 'Ya'){
          $('#Radio3').prop('checked', true);
        }else{
          $('#Radio4').prop('checked', true);
        }
        $(".modal-title").html('Edit Anak')
        $('#anakModal').modal('show'); 
      }
    })
  });

  var bina = $('#binaan').DataTable({
    ajax: {
      url: "{{ url('pembina/grid') }}/{{$data->id}}",
      dataSrc: ''
    },
    columns: [
      { 
        data:null,
          render: function(data, type, full, meta){
            return meta.row + 1
          }
      },
      { 
        data:null,
          render: function(data, type, full, meta){
            if(data.anak){
              return "<a>"+data.nama+" </a>(<a href={{url('anggota/edit')}}/"+data.id+">"+data.nama_ortu+"</a>)"
            }else{
              return "<a href={{url('anggota/edit')}}/"+data.id+">"+data.nama+"</a>"
            }
        }
      },
      { 
        data:null,
          render: function(data, type, full, meta){
            if(data.anak){
              return "<a>"+data.nama+" </a>(<a href={{url('anggota/edit')}}/"+data.id+">"+data.nama_ortu+"</a>)"
            }else{
              return '<a href="#" title="Delete" '
              + 'delete-title="Hapus {{ $title }} ' + data.nama + '" '
              + 'delete-action="{{ url('/binaan') }}'+ '/' + data.id + '" '
              + 'delete-message="Apakah anda yakin untuk menghapus binaan ini?" '
              + 'class="btn btn-danger btn-sm waves-effect gridDelete"><i class="fa fa-minus"></i></a>';
            }
        }
      }
    ],
    dom: '<"row"' +
        '<"col-md-12"<"row"<"col-md-6"B> > >' +
        '<"col-md-12"rt> <"col-md-12"<"row"<"col-md-5"i><"col-md-7"p>>> >',
    oLanguage: {
      oPaginate: { "sPrevious": '<', "sNext": '>' },
      sInfo: "Halaman _PAGE_ dari _PAGES_",
      sLengthMenu: "Hasil :  _MENU_",
      sEmptyTable: "Tidak ada binaan",
      sInfoEmpty: ""
    },
    pageLength: 5,
    ordering: false
  });

  $('#addRow').on( 'click', function () {
    $.ajax({
      type: "POST",
      url: "{{url('anak')}}",
      data: {id: $('#aId').val(),
            kader_id:'{{$data->id}}', 
            nama:$('#aNama').val(), 
            tahun_lahir:$('#aTahun').val(), 
            pendidikan:$('#aPendidikan').val(), 
            tarbiyah:$('input[name=aTarbiyah]:checked').val(),
            pembimbing_id:$("#pembimbing_id option:selected").val()
          },
      success: function(data){
        swal.fire({
          toast: true,
          icon: data.status,
          title: data.messages,
          padding: '2em',
          showConfirmButton: false,
          timer: 3000,
        });
        t.ajax.reload()
        $('#anakModal').modal('hide');
      },
      error: function(data){
        swal.fire({
          toast: true,
          icon: data.status,
          title: "Isi semua kolom",
          padding: '2em',
        });
      }
    });
  });

  $('#formAnggota').submit(function(){
    $('#subForm').attr('disabled', true)
  })

  <?php 
    $foto = $data->photo ? url('storage/images/anggota').'/'.$data->photo : ''; 
    $ktp = $data->ktp ? url('storage/images/ktp').'/'.$data->ktp : ''; 
  ?>
  var firstUpload = new FileUploadWithPreview('myFirstImage', {
    text: {
      chooseFile: "Cari Foto",
    }
  })
  if("{{$data->photo}}"){
    firstUpload.addImagesFromPath(['{{$foto}}'])
  }
  $('#imgAnggota').on('click', function(){
    $('#photo').val("")
  })

  var firstUpload1 = new FileUploadWithPreview('myFirstImage1', {
    text: {
      chooseFile: "Cari Foto",
    }
  })
  if("{{$data->ktp}}"){
    firstUpload1.addImagesFromPath(['{{$ktp}}'])
  }
  $('#imgKtp').on('click', function(){
    $('#ktp').val("")
  })

  flatpickr($('.flatpickr'), {
      altFormat: "d-m-Y",
      altInput: true,
      dateFormat: "Y-m-d",
      locale: "id"
  })

  $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
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

  $('#aNama').select2({
    theme: 'bootstrap4',
    allowClear: true,
    placeholder: 'Nama Anak',
    width: 'resolve',
    dropdownParent: $('#anakModal'),
    tags: true,
    ajax: {
      url: "{{url('search/anak')}}",
      dataType: 'json',
      delay: 250,
      data: function (params) {
        var query = {
          search: params.term,
          tanggal_lahir: "{{$data->tanggal_lahir}}"
        }
        return query;
      },
      processResults: function (data) {
        return {
          results:  $.map(data, function (item) {
            return {
              text: item.nama_lengkap+'-'+item.nomor_urut,
              id: item.id
            }
          })
        };
      },
      cache: false,
    }
  }).on('select2:open', () => {
    document.querySelector('.select2-search__field').focus();
  }).on('change', function(){
    let opt = this.options.selectedIndex
    if(!$(this.options[opt]).attr('data-select2-tag') && this.options[opt].value){
      $('.divMod').addClass('d-none')
      $.ajax({
        type: "POST",
        url: "{{url('anak')}}",
        data: {ortu_id:'{{$data->id}}', 
              id:this.value, 
              anggota:1
            },
        success: function(data){
          swal.fire({
            toast: true,
            icon: data.status,
            title: data.messages,
            padding: '2em',
            showConfirmButton: false,
            timer: 3000,
          });
          t.ajax.reload()
          $('#anakModal').modal('hide');
        },
        error: function(data){
          console.log(data)
          swal.fire({
            toast: true,
            icon: data.status,
            title: "Isi semua kolom",
            padding: '2em',
          });
        }
      });
      t.ajax.reload()
      $('#anakModal').modal('hide');
    }else if(this.value){
      $('.divMod').removeClass('d-none')
    }else{
      $('.divMod').addClass('d-none')
    }
  })

  $('#pasangan').select2({
    theme: 'bootstrap4',
    allowClear: true,
    placeholder: 'Nama Pasangan',
    width: 'resolve',
    tags: true,
    ajax: {
      url: "{{url('pasangan')}}",
      dataType: 'json',
      delay: 500,
      data: function (params) {
        let gender = $('input[name=jenis_kelamin]:checked').val()
        var query = {
          search: params.term,
          jenis_kelamin: gender,
          id: $('#id').val()
        }
        return query;
      },
      processResults: function (data) {
        return {
          results:  $.map(data, function (item) {
            return {
              text: item.nama_lengkap+' - '+item.nomor_urut,
              id: item.id
            }
          })
        };
      },
      cache: false,
    }
  }).on('select2:open', () => {
    document.querySelector('.select2-search__field').focus();
  }).on('change', function(){
    let opt = this.options.selectedIndex
    if(!$(this.options[opt]).attr('data-select2-tag') && this.options[opt].value){
      $('#hidden_pasangan').val('true')
    }else{
      $('#hidden_pasangan').val('false')
    }
  });

  $('#id_pembina').select2({
    theme: 'bootstrap4',
    allowClear: true,
    placeholder: 'Nama Pembina',
    width: 'resolve',
    tags: true,
    ajax: {
      url: "{{url('pembina')}}",
      dataType: 'json',
      delay: 500,
      data: function (params) {
      var query = {
        search: params.term,
        id: $('#id').val(),
        ortu: '1',
        jenjang: "{{$data->jenjang_anggota}}"
      }
      return query;
    },
      processResults: function (data) {
        return {
          results:  $.map(data, function (item) {
            return {
              text: item.nama_lengkap+' - '+item.nomor_urut,
              id: item.id
            }
          })
        };
      },
      cache: false,
    }
  }).on('select2:open', () => {
    document.querySelector('.select2-search__field').focus();
  }).on('change', function(){
    let opt = this.options.selectedIndex
    if(!$(this.options[opt]).attr('data-select2-tag') && this.options[opt].value){
      $('#hidden_pembina').val('true')
    }else{
      $('#hidden_pembina').val('false')
    }
  });;

  $('#add_binaan').select2({
    theme: 'bootstrap4',
    allowClear: true,
    placeholder: 'Tambah Binaan',
    width: 'resolve',
    ajax: {
      url: "{{url('binaan')}}",
      dataType: 'json',
      delay: 500,
      data: function (params) {
      var query = {
        search: params.term,
        id: $('#id').val(),
        jenjang: "{{$data->jenjang_anggota}}"
      }
      return query;
    },
      processResults: function (data) {
        return {
          results:  $.map(data, function (item) {
            return {
              text: item.nama_lengkap+' - '+item.nomor_urut,
              id: item.id
            }
          })
        };
      },
      cache: false,
    }
  }).on('select2:open', () => {
    document.querySelector('.select2-search__field').focus();
  }).on('change', function(){
    if(this.value){
      $.ajax({
        type: "POST",
        url: "{{url('binaan')}}",
        data: {id:"{{$data->id}}",id_binaan: this.value},
        success: function(data){
          swal.fire({
            toast: true,
            icon: data.status,
            title: data.messages,
            padding: '2em',
            showConfirmButton: false,
            timer: 2000,
          });
          bina.ajax.reload()
          setTimeout(() =>{
            $('#add_binaan').val(null).trigger('change');
          },500)
        },
        error: function(data){
          swal.fire({
            toast: true,
            icon: data.status,
            title: "Hubungi Admin",
            padding: '2em',
          });
        }
      });
    }
  });

  $('#pembimbing_id').select2({
    theme: 'bootstrap4',
    allowClear: true,
    dropdownParent: $('#anakModal'),
    placeholder: 'Nama Pembina',
    width: 'resolve',
    ajax: {
      url: "{{url('pembina')}}",
      dataType: 'json',
      delay: 500,
      data: function (params) {
      var query = {
        search: params.term,
        id: $('#id').val(),
        ortu: '0'
      }
      return query;
    },
      processResults: function (data) {
        return {
          results:  $.map(data, function (item) {
            return {
              text: item.nama_lengkap+' - '+item.id,
              id: item.id
            }
          })
        };
      },
      cache: false,
    }
  }).on('select2:open', () => {
    document.querySelector('.select2-search__field').focus();
  });
  <?php 
    $pas = $data->pasangan ? 'data-select2-tag=true' : '';
    $pem = $data->nama_pembinaStr ? 'data-select2-tag=true' : '';
  ?>
  $('#kota').append("<option value={{$data->regencies_id}}>{{$data->kota}}</option>");
  $('#kecamatan').append('<option value={{$data->districts_id}}>{{$data->camat}}</option>');
  $('#desa').append('<option value={{$data->villages_id}}>{{$data->desa}}</option>');
  $('#pasangan').append("<option {{$pas}} value={{$data->pasangan_id??$data->pasangan}}>{{$data->nama_pasangan??$data->pasangan}}</option>").trigger('change');
  $('#aNama').append('<option value=></option>');
  $('#id_pembina').append("<option {{$pem}} value={{$data->id_pembina??$data->nama_pembinaStr}}>{{$data->nama_pembina??$data->nama_pembinaStr}}</option>").trigger('change');

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
    }else{
      $('#pasangan').val(null).trigger('change')
      $('#pasangan').attr('disabled', true)
    }
  })

  $('input[name=aTarbiyah]').on('change', function(){
    if(this.value == "1"){
      $('#pembimbing_id').removeAttr('disabled')
    }else{
      $('#pembimbing_id').val(null).trigger('change')
      $('#pembimbing_id').attr('disabled', true)
    }
  })

  camat()
  desa()
});

window.addEventListener("fileUploadWithPreview:imagesAdded", function (e) { 
  if (e.detail.uploadId === "myFirstImage") {
    $('#photo').val(e.detail.files[0].name)
  }
  
  if (e.detail.uploadId === "myFirstImage1") {
    $('#ktp').val(e.detail.files[0].name)
  }
});

</script>
@endsection