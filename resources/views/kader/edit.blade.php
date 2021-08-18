@extends('partials.form')
<?php $read = isset($data->id) ? 'readonly' : null; ?> 
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
    <div class="container-fluid col-xl-3">
      <div class="card card-default color-pallete-box">
        <div class="card-body">
  <form class="needs-validation" enctype="multipart/form-data" method="POST" action="{{ url('/anggota') }}">
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
          <?php $checkedStr = $data->pembina ? 'checked="checked"' : null; ?> 
          <div class="form-group">
            <label for="exampleInputPassword1">Punya Binaan</label>
            <div class="ml-2">
              <input data-on-text="Ya" data-off-text="Tidak" data-bootstrap-switch id="pembina" type="checkbox" name="pembina" switch="none" {!! $checkedStr !!} >
            </div>
          </div>
          @if($data->pembina)
            <div class="form-group">
              <label for="exampleInputPassword1">Anggota Binaan</label>
              <table id="binaan" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <thead>
                  <tr>
                    <th style="width:10%">No</th>
                    <th>Nama</th>
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
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <input type="hidden" id="id" name="id" value="{{ old('id', $data->id) }}" />
            <div class="row">
              <div class="form-group col-md-6">
                <label for="exampleInputEmail1">Nomor Urut Anggota</label>
                <input type="text" disabled class="form-control" value="{{$data->nomor_urut}}" placeholder="Nomor Induk Kependudukan">
              </div>
              <div class="form-group col-md-{{$data->id ? '6' : '12'}}">
                <label for="exampleInputEmail1">NIK / No. KTP</label>
                <input type="number" required class="form-control" value="{{old('nik', $data->nik)}}" name="nik" placeholder="Nomor Induk Kependudukan">
              </div>
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
                    <input class="form-control flatpickr flatpickr-input" id="tanggal_lahir" value="{{old('tanggal_lahir', $data->tanggal_lahir)}}" name="tanggal_lahir" placeholder="Tanggal Lahir">
                  </div>
                </div>
              </div>
              <div class="form-group col-md-6">
                <div class="row">
                  <div class="col-12 mb-1">
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
                    <select required class="form-control selectbs4" style="width: 100%;" name="regencies_id" id="kota"></select>
                  </div>
                  <div class="col-md-4">    
                    <select required class="form-control selectbs4" style="width: 100%;" {{isset($data->districts_id) ? '':'disabled'}} name="districts_id"  id="kecamatan"></select>
                  </div>
                  <div class="col-md-4 mb-3">    
                    <select required class="form-control selectbs4" style="width: 100%;" {{isset($data->villages_id) ? '':'disabled'}} id="desa" name="villages_id"></select>
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
                    <select required class="form-control selectbs4" disabled style="width: 100%;" id="id_pembina" name="id_pembina"></select>
                  </div>
                  <!-- <div class="col-md-2">
                    <a href="{{ url('/'.$link.'/edit/'.$data->id_pembina) }}" style="width: 100%;" type="button" class="btn btn-warning"><i class="fa fa-address-card"></i></a>
                  </div> -->
                </div>
                @else
                  <label for="exampleInputPassword1">Nama Pembina/Pembimbing</label>
                  <select class="form-control selectbs4" style="width: 100%;" id="id_pembina" name="id_pembina"></select>
                @endif
              </div>
              <div class="form-group col-md-6">
                <label for="exampleInputPassword1">Awal Keanggotaan</label>
                <input type="text" id="awal_anggota" class="form-control flatpickr flatpickr-input" value="{{old('awal_anggota', $data->awal_anggota)}}" name="awal_anggota" placeholder="Awal Keanggotaan">
              </div>
              <div class="form-group col-md-6">
                <label for="exampleInputPassword1">Jenjang Keanggotaan</label>
                <select class="form-control" name="jenjang_anggota">
                  <option></option>
                  <option {{old('jenjang_anggota', $data->jenjang_anggota) == 'Pemula' ?'selected': ''}}>Pemula</option>
                  <option {{old('jenjang_anggota', $data->jenjang_anggota) == 'Siaga' ?'selected': ''}}>Siaga</option>
                  <option {{old('jenjang_anggota', $data->jenjang_anggota) == 'Muda' ?'selected': ''}}>Muda</option>
                  <option {{old('jenjang_anggota', $data->jenjang_anggota) == 'Pratama' ?'selected': ''}}>Pratama</option>
                  <option {{old('jenjang_anggota', $data->jenjang_anggota) == 'Madya' ?'selected': ''}}>Madya</option>
                  <option {{old('jenjang_anggota', $data->jenjang_anggota) == 'Dewasa' ?'selected': ''}}>Dewasa</option>
                  <option {{old('jenjang_anggota', $data->jenjang_anggota) == 'Utama' ?'selected': ''}}>Utama</option>
                </select>
              </div>
              <div class="col-md-6">
                <div class="row">
                  <div class="col-md-12"><label for="exampleInputPassword1">Usia Jenjang Keanggotaan</label></div>     
                  <div class="form-group col-md-12">
                    <input required type="text" class="form-control flatpickr flatpickr-input" value="{{old('usia_jenjang', $data->usia_jenjang)}}" name="usia_jenjang" placeholder="Usia Jenjang Keanggotaan">
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
                    <select id="pasangan" style="width: 100%;" class="form-control selectbs4" name="pasangan" placeholder="Nama Pasangan" {{$data->status_pernikahan != 'Kawin' ? "disabled" : " "}}></select>
                  </div>
                  <div class="col-md-2">
                    <a href="{{ url('/'.$link.'/edit/'.$data->pasangan_id) }}" style="width: 100%;" type="button" class="btn btn-success"><i class="fa fa-address-card"></i></a>
                  </div>
                </div>
              @else
                <label for="exampleInputPassword1">Nama Pasangan</label>
                <select id="pasangan" style="width: 100%;" class="form-control selectbs4" name="pasangan" placeholder="Nama Pasangan" {{$data->status_pernikahan != 'Kawin' ? "disabled" : " "}}></select>
              @endif
              </div>
              <div class="form-group col-md-12">
                <label for="exampleInputPassword1">Amanah/Kontribusi Anggota</label>
                <input type="text" class="form-control" name="amanah" value="{{old('amanah', $data->amanah)}}" placeholder="Amanah/Kontribusi Anggota">
              </div>
              <div class="custom-file-container col-md-6 form-group" data-upload-id="myFirstImage1">
                <label>Foto KTP <a href="javascript:void(0)" class="custom-file-container__image-clear" id="imgKtp" title="Clear Image">&nbsp;&times;</a></label>
                <label class="custom-file-container__custom-file mb-3 mt-1" >
                  <input type="file" name="file1" class="form-control custom-file-container__custom-file__custom-file-input" accept="image/*">
                  <span class="custom-file-container__custom-file__custom-file-control"></span>
                </label>
                <div class="custom-file-container__image-preview ktpImg"></div>
                <input type="hidden" id="ktp" name="ktp" value="{{$data->ktp}}">
              </div>
            </div>
            <button type="submit" class="btn btn-primary float-right ml-2 mt-3">Simpan</button>
            <a href="{{ url('/'.$link) }}" type="button" class="btn btn-danger float-right mt-3" type="submit">{{ isset($data->id) ? 'Kembali' : 'Batal' }}</a>
          </div>
</form>
        </div>
      </div>
    </div>
    @if($data->id && $data->status_pernikahan != "Belum Kawin")
    <div class="col-xl-3">
    </div>
    <div class="container-fluid col-xl-9">
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
    </div>
    @endif
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
          <input type="text" required class="form-control fModal" value="" id="aNama" placeholder="Nama Lengkap">
        </div>
        <div class="form-group col-md-12">
          <label for="exampleInputPassword1">Pendidikan Terakhir</label>
          <select required class="form-control fModal" id="aPendidikan">
            <option></option>
            <option>SD</option>
            <option>SLTP</option>
            <option>SLTA</option>
            <option>D1/D2/D3</option>
            <option>S1</option>
          </select>
        </div>
        <div class="form-group col-md-12">
          <label for="exampleInputPassword1">Tahun Lahir</label>
          <input type="text" id="aTahun" readonly class="form-control yearpicker fModal" value="">
        </div>
        <div class="form-group col-md-12 row">
          <div class="col-12">
            <label for="exampleInputPassword1">Tarbiyah</label>
          </div>
          <div class="custom-control custom-radio col-4 ml-3">
            <input class="custom-control-input rModal" name="aTarbiyah" value="1" type="radio" id="Radio3">
            <label for="Radio3" class="custom-control-label">Ya</label>
          </div>
          <div class="custom-control custom-radio col-5">
            <input class="custom-control-input rModal" name="aTarbiyah" value="0" type="radio" id="Radio4">
            <label for="Radio4" class="custom-control-label">Tidak</label>
          </div>
        </div>
        <div class="form-group col-md-12">
          <label for="exampleInputPassword1">Nama Pembina/Pembimbing</label>
          <select required class="sModal form-control selectbs4" disabled id="pembimbing_id" name="pembimbing_id"></select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary modal-action-close" data-dismiss="modal">Batal</button>
        <a type="button" id="addRow" class="btn btn-primary font-bold">Simpan</a>
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
            icon += '<a href="{{ $link }}'+ '/edit/' + data.id +'" title="Edit" type="button" class="btn btn-success btn-sm waves-effect gridEdit"><i class="ti-marker-alt"></i> Edit</a>';
            icon += '&nbsp;<a href="#" title="Delete" '
              + 'delete-title="Hapus {{ $title }} ' + data.nama + '" '
              + 'delete-action="{{ url('/anak') }}'+ '/' + data.id + '" '
              + 'delete-message="Apakah anda yakin untuk menghapus data ini?" '
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
    pageLength: 5,
  });

  $('#addRow').on( 'click', function () {
    $.ajax({
      type: "POST",
      url: "{{url('anak')}}",
      data: {kader_id:'{{$data->id}}', 
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
<?php 
$foto = $data->photo ? url('storage/images/anggota/thumbnail').'/'.$data->photo : ''; 
$ktp = $data->ktp ? url('storage/images/ktp/thumbnail').'/'.$data->ktp : ''; 
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
        ortu: '1'
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
  
  $('#kota').append("<option value={{$data->regencies_id}}>{{$data->kota}}</option>");
  $('#kecamatan').append('<option value={{$data->districts_id}}>{{$data->camat}}</option>');
  $('#desa').append('<option value={{$data->villages_id}}>{{$data->desa}}</option>');
  $('#pasangan').append('<option value={{$data->pasangan_id??$data->pasangan}}>{{$data->nama_pasangan??$data->pasangan}}</option>');
  $('#id_pembina').append('<option value={{$data->id_pembina??$data->nama_pembinaStr}}>{{$data->nama_pembina??$data->nama_pembinaStr}}</option>');

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