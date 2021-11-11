@extends('partials.table')
<?php $none = empty($data->id) ? 'd-none' : null; ?> 
<?php $read = isset($data->id) ? 'readonly' : null; ?> 
@section('css-table')
<link rel="stylesheet" href="{{asset('plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
@endsection

@section('content-table')
<div class="container-fluid">
  <div class="card card-default color-palette-box">
    <div class="card-body">
      <div class="col-md-12">
        <form class="needs-validation" method="POST" action="{{ url('/kelompok') }}">
          <input type="hidden" id="id" name="id" value="{{ $data->id }}">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" name="noJson" value="1">
          <input type="hidden" name="id_pembina" value="{{$data->id_pembina}}">
          <div class="row">
            <div class="form-group col-md-12">
              <label for="exampleInputEmail1">Nama Kelompok</label>
              <input type="text" name="nama_kelompok" value="{{ old('nama_kelompok', $data->nama_kelompok) }}" class="form-control" id="name">
            </div>
            <div class="col-md-12">
              <table id="grid" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Lengkap</th>
                    <th>Nomor HP</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
          </div>
          <button type="submit" class="btn btn-dpd float-right ml-2 mt-3">Simpan</button>
          <a href="{{ url('/'.$link) }}" type="button" class="btn btn-black float-right mt-3" type="submit">{{ isset($data->id) ? 'Kembali' : 'Batal' }}</a>
        </form> 
      </div>
    </div>
  </div>
</div>
@endsection

@section('js-table')
<script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
<script>
  $(document).ready(function (){
    $('#appModal').on('hide.bs.modal', function() {
      $('#appModal').find('.modal-body').html('');
      $('#dpdModal').unbind()
      $('#dpdModal').addClass('d-none')
    });
    let grid = $('#grid').DataTable({
        ajax: {
            url: "{{ url($link.'/view/'.$data->id) }}",
            type: "POST",
            dataSrc: "kader"
        },
        buttons: [
          { 
            text: "Tambah",
            className: "btn btn-dpd",
            action: function ( e, dt, node, config ) {
              $('#appModal').modal('show'); 
              $('.modal-dialog').addClass('modal-md')
              $(".modal-title").html('Tambah Anggota')
              $(".btn-dpd").removeClass('d-none')  
              $("#dpdModal").html('Tambah')  
              let body = ""
              body += 
              "<div class='col-md-12 mt-2'"+
                "<div class='row'>"+
                  "<div class='form-group col-md-12'>"+
                    "<select required class='form-control selectbs4' style='width: 100%;' id='id_kader' name='id_kader'></select>"+                  
                  "</div>"+
                "</div>"+
              "</div>"
              $('#appModal').find('.modal-body').append(body);
              $('#id_kader').select2({
                theme: 'bootstrap4',
                dropdownParent: $('#appModal'),
                allowClear: true,
                placeholder: 'Tambah Binaan',
                width: 'resolve',
                ajax: {
                  url: "{{url('binaan')}}",
                  type: 'POST',
                  dataType: 'json',
                  delay: 500,
                  data: function (params) {
                  var query = {
                    search: params.term,
                    id: "{{$data->id_pembina}}",
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
              })
              $('#dpdModal').on('click', function(){
                $.ajax({
                  url:"anggota/" + $('#id_kader').val(),
                  data:{id_kelompok:"{{$data->id}}"},
                  type:"POST",
                  success: function(data){
                    $("#appModal").modal('hide');
                    swal.fire({
                      icon: data.status,
                      title: data.action,
                      text: data.messages
                    })
                    grid.ajax.reload()
                  },
                  error: function(data){
                    $("#appModal").modal('hide');
                    swal.fire({
                      icon: data.status,
                      title: data.action,
                      text: data.messages
                    })
                  }
                })
              })
            }
          }
        ],
        dom: '<"row"' +
        '<"col-md-12"<"row"<"col-md-6"B><"col-md-6"> > >' +
        '<"col-md-12"tr> <"col-md-12"<"row"<"col-md-5"i><"col-md-7"p>>> >',
        serverSide: false,
        columns: [
          {
            data:"nomor_urut",
            searchable: true
          },
          { 
            data: 'nama_lengkap',
            searchable: true,
          },
          { 
            data: 'telp',
            orderable: false,
            searchable: false
          },
          { 
            data:null,
            searchable: false,
            orderable: false,
            width:'80px',
            className: 'text-center',
            render: function(data, type, full, meta){
              let icon = "";
                if("{{ $canEdit }}")
                icon += '<a href="{{url("anggota/edit")}}/'+ data.id +'" title="Edit" type="button" class="btn btn-success btn-sm waves-effect gridEdit"><i class="ti-marker-alt"></i> Edit</a>';
                
                if("{{ $canDelete }}")
                icon += '&nbsp;<a href="#" title="Delete" '
                  + 'delete-title="Hapus ' + data.nama_lengkap + '" '
                  + 'delete-action="anggota/'+ data.id+'"'
                  + 'delete-message="Apakah anda yakin untuk menghapus anggota ini?" '
                  + 'class="btn btn-danger btn-sm waves-effect gridDelete"><i class="ti-trash"></i> Hapus</a>';
              return icon;
            }
          }
        ],
      });
  });
</script>
@endsection