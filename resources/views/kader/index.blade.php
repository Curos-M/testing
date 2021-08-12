@extends('partials.table')

@section('css-table')
@endsection

@section('content-table')
<div class="row">
  <div class="col-12">
    <table id="grid" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
      <thead>
        <tr>
          <th>Nama Lengkap</th>
          <th>Jenjang Keanggotaan</th>
          <th>Nomor HP</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
  </div>
</div>
@endsection

@section('js-table')
<script>
  $(document).ready(function (){
    let grid = $('#grid').DataTable({
        ajax: {
          url: "{{ url('kader/grid') }}",
          dataSrc: ''
        },
        columns: [
          { 
            data: 'nama_lengkap',
            searchText: true
          },
          { 
            data: 'jenjang_anggota',
            searchText: true
          },
          { 
            data: 'telp',
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
                  + 'delete-title="Hapus username ' + data.username + '" '
                  + 'delete-action="{{ $link }}'+ '/' + data.id + '" '
                  + 'delete-message="Apakah anda yakin untuk menghapus data ini?" '
                  + 'class="btn btn-danger btn-sm waves-effect gridDelete"><i class="ti-trash"></i> Hapus</a>';
              return icon;
            }
          }
        ]
      });
  });
</script>
@endsection