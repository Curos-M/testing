@extends('partials.table')

@section('css-table')
@endsection

@section('content-table')
<div class="container-fluid">
  <div class="card card-default color-palette-box">
    <div class="card-body">
      <div class="row">
        <div class="col-12">
          <table id="grid" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
            <thead>
              <tr>
                <th>Nama Lengkap</th>
                <th>Jenjang Keanggotaan</th>
                <th>Nomor HP</th>
                @if($canEdit || $canDelete)
                <th></th>
                @endif
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('js-table')
<script>
  $(document).ready(function (){
    let grid = $('#grid').DataTable({
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
          @if($canEdit || $canDelete)
          { 
            data:null,
            width:'80px',
            className: 'text-center',
            render: function(data, type, full, meta){
              let icon = "";
                if("{{ $canEdit }}")
                icon += '<a href="{{ $link }}'+ '/edit/' + data.id +'" title="Edit" type="button" class="btn btn-success btn-sm waves-effect gridEdit"><i class="ti-marker-alt"></i> Edit</a>';
                
                if("{{ $canDelete }}")
                icon += '&nbsp;<a href="#" title="Delete" '
                  + 'delete-title="Hapus {{ $title }} ' + data.username + '" '
                  + 'delete-action="{{ $link }}'+ '/' + data.id + '" '
                  + 'delete-message="Apakah anda yakin untuk menghapus data ini?" '
                  + 'class="btn btn-danger btn-sm waves-effect gridDelete"><i class="ti-trash"></i> Hapus</a>';
              return icon;
            }
          }
          @endif
        ],
        processing: true,
        serverSide: true
      });
  });
</script>
@endsection