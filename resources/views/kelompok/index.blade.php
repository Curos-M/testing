@extends('partials.table')

@section('css-table')
<style>
  .table td, .table th {
    padding: .75rem;
    vertical-align: top;
    border-top: 0px solid #dee2e6;
  }
</style>
<link rel="stylesheet" href="{{asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/select2/css/select2.min.css')}}">
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
<script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
<script>
  $(document).ready(function (){
    $("#grid thead").hide();
    $('#appModal').on('hide.bs.modal', function() {
      $('#appModal').find('.modal-body').html('');
      $('#dpdModal').unbind()
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
                  @if ($all)
                    "<select class='form-control selectbs4' style='width: 100%;' id='pembina'></select>"+
                  @else
                    "<input type='hidden' id='pembina' value='{{$user->anggota_id}}'>"+
                  @endif
                  "<input type='text' id='nama_kelompok' maxlength='23' placeholder='Nama Kelompok' class='form-control mt-2'>"+
                "</div>"+
              "</div>"+
            "</div>"
            $('#appModal').find('.modal-body').append(body);
            $('#dpdModal').on('click', function(){
              let nama = $('#nama_kelompok').val()
              let id = $('#pembina').val()
              $.ajax({
                type  : "POST",
                url   : "{{$link}}",
                data  : {nama_kelompok: nama, id_pembina:id},
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
            if("{{$all}}"){
              $('#pembina').select2({
                theme: 'bootstrap4',
                allowClear: true,
                placeholder: 'Nama Pembina',
                width: 'resolve',
                ajax: {
                  url: "{{url('pembina')}}",
                  dataType: 'json',
                  delay: 500,
                  data: function (params) {
                  var query = {
                    search: params.term,
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
            }
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
                  'class="btn btn-black btn-sm waves-effect float-right gridDelete"><i class="ti-trash"></i> Hapus</a>';
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
      var id = this.name
      $.ajax({
        type  : "POST",
        url   : "{{$link}}/view/"+id,
        success: function(data){
          var winWidth =  $(window).width();
          $('#appModal').modal('show'); 
          $('.modal-dialog').addClass('modal-lg')
          $('.modal-header').css("border-bottom-width", "5px")
          $('.modal-header').css("border-bottom-style", "solid")
          $('.modal-header').css("border-bottom-color", "rgb(253, 80, 0)")
          $(".modal-title").html(data.nama_kelompok)
          $(".btn-dpd").removeClass('d-none')  
          $(".modal-action-save").removeClass('d-none')
          $(".modal-action-save").html('Edit')
          $("#dpdModal").html('Catatan')
          $('.modal-action-close').html('Tutup') 
          $('.modal-action-close').addClass('mr-auto') 
          let body = ""
          if(data.note){
            var tanggal = "Tanggal Dibuat : "+data.note.tanggal
            var catatan = data.note.catatan
            var photo = data.note.photo
          }else{
            var tanggal = ""
            var catatan = "Tidak Ada Catatan"
            var photo = ""
          }
          body += 
          "<div class='col-lg-12 mt-2'>"+
            "<div class='row'>"+
              "<div class='col-lg-4'>"+
                "<h4>Pembina Kelompok</h4>"+
                "<h5><span class='badge bg-dpd mx-1'>"+data.nama_pembina+"</span></h5>"+
                "<h4>Anggota Kelompok</h4>"+
                "<div class='row col-md-12'>";
                  for(let i = 0; i<data.kader.length;i++){
                    body +=
                    "<h5><span class='badge bg-dpd mx-1'>"+data.kader[i].nama_lengkap+"</span></h5>";
                  }               
                body +=
                "</div>"+
              "</div>"+
              "<div class='col-lg-8'>"+
                "<div class='row'>"+
                  "<h4 class='col-lg-7'>Catatan Terakhir</h3>"+
                  "<p class='col-lg-5 text-right'>"+tanggal+"</p>"+
                "</div>"+
                "<p>"+catatan+"</p>"+
                "<img src=''>"+
              "</div>"+
            "</div>"+
          "</div>"
          $('#appModal').find('.modal-body').append(body);
          $(".modal-action-save").on('click', function(){
            window.location.href = "{{url('kelompok/edit')}}/"+id
          })
        },
        error: function(data){
          alert('error, hubungi admin')
        }
      })
    })

    
  });
</script>
@endsection