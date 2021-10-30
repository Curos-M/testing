@extends('partials.table')

@section('css-table')
<style>
  .table td, .table th {
    padding: .75rem;
    vertical-align: top;
    border-top: 0px solid #dee2e6;
  }
</style>
@endsection

@section('content-table')
<div class="container-fluid">
  <div class="card card-default color-palette-box">
    <div class="card-body">
      <div class="row">
        <div class="col-12">
          <table id="grid" class="table dt-responsive nowrap" style="border-collapse: collapse; border-top-width: 0px;  border-spacing: 0; width: 100%;">
            <thead>
              <tr>
                <th></th>
                <th></th>
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
    $("#grid thead").hide();
    $('#appModal').on('hide.bs.modal', function() {
      $('#appModal').find('.modal-body').html('');
    });
    let grid = $('#grid').DataTable({
      buttons: [
        { 
          text: "Tambah Baru",
          className: "{{$canAdd ? 'btn btn-dpd' : 'd-none'}}",
          action: function ( e, dt, node, config ) {
            $('#appModal').modal('show'); 
            $('.modal-dialog').addClass('modal-md')
            $('.modal-header').css("border-bottom-width", "5px")
            $('.modal-header').css("border-bottom-style", "solid")
            $('.modal-header').css("border-bottom-color", "rgb(253, 80, 0)")
            $(".modal-title").html('Tambah Kelompok')
            $(".btn-dpd").removeClass('d-none')  
            $("#dpdModal").html('Simpan')  
            let body = ""
            body += 
            "<div class='col-md-12 mt-2'"+
              "<div class='row'>"+
                "<div class='form-group col-md-12'>"+
                  "<input type='text' id='nama_kelompok' maxlength='23' placeholder='Nama Kelompok' class='form-control'>"+
                "</div>"+
              "</div>"+
            "</div>"
            $('#appModal').find('.modal-body').append(body);
          }
        }
      ],
      columns: [
        { 
          data: 'nama_kelompok',
          searchable: true,
          visible: false
        },
        {
          data: null,
          searchable: false,
          render: function (data, type, row, meta) { 
            var html =
            '<div class="card">'+
              '<div class="card-body" style="width:14rem">'+
                '<div class="card-text mb-2 text-center">'+row.nama_kelompok+'</div>';
                // if("{{ $canEdit }}")
                // html += '<a href="{{ $link }}'+ '/edit/' + data.id +'" title="Edit" type="button" class="btn btn-success btn-sm waves-effect gridEdit"><i class="ti-marker-alt"></i> Edit</a>';
                html += "<a href='#' title='Lihat' name='"+data.id+"' type='button' id ='view' class='btn btn-dpd btn-sm waves-effect'>Lihat</a>"
                if("{{ $canDelete }}")
                html += '&nbsp;<a href="#" title="Delete" '+
                  'delete-title="Hapus {{ $title }} ' + data.nama_kelompok + '" '+
                  'delete-action="{{ $link }}'+ '/' + data.id + '" '+
                  'delete-message="Apakah anda yakin untuk menghapus Kelompok ini?" '+
                  'class="btn btn-danger btn-sm waves-effect float-right gridDelete"><i class="ti-trash"></i> Hapus</a>';
                html += 
              '</div>'+
            '</div>';
            return html;
          }
        },
      ],
      pageLength: 12,
    });

    grid.on('draw', function(data){
      $('#grid tbody').addClass('row');
      $('#grid tbody tr').addClass('col-lg-3 col-md-4 col-sm-12');
    });

    $('#grid').on('click', '#view', function(){
      $.ajax({
        type  : "POST",
        url   : "{{$link}}/view/"+this.name,
        success: function(data){
          console.log(data.kader)
          $('#appModal').modal('show'); 
          $('.modal-dialog').addClass('modal-xl')
          $('.modal-header').css("border-bottom-width", "5px")
          $('.modal-header').css("border-bottom-style", "solid")
          $('.modal-header').css("border-bottom-color", "rgb(253, 80, 0)")
          $(".modal-title").html(data.nama_kelompok)
          $(".btn-dpd").removeClass('d-none')  
          $("#dpdModal").html('Simpan')  
          let body = ""
          body += 
          "<div class='col-md-12 mt-2'"+
            "<div class='row'>"+
              "<div class='col-md-3'>"+
                "<h4>Pembina Kelompok</h4>"+
                "<h5><span class='badge bg-dpd mx-1'>"+data.nama_pembina+"</span></h5>"+
                "<h4>Anggota Kelompok</h4>"+
                "<div class='row'>";
                  for(let i = 0; i<data.kader.length;i++){
                    body +=
                    "<h5><span class='badge bg-dpd mx-1'>"+data.kader[i].nama_lengkap+"</span></h5>";
                  }               
                body +=
                "</div>"+
              "</div>"+
            "</div>"+
          "</div>"
          $('#appModal').find('.modal-body').append(body);
        },
        error: function(data){
          alert('error, hubungi admin')
        }
      })
    })

    $('#dpdModal').on('click', function(){
      let nama = $('#nama_kelompok').val()
      $.ajax({
        type  : "POST",
        url   : "{{$link}}",
        data  : {nama_kelompok: nama},
        success: function(data){
          sweetAlert(
            data.status,
            data.action,
            data.messages,
          );
          $("#appModal").modal('hide');
          grid.ajax.reload()
        },
        error: function(data){
          alert('error, hubungi admin')
        }
      })
    })
  });
</script>
@endsection