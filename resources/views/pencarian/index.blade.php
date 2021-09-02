@extends('partials.table')

@section('css-table')
@endsection

@section('content-table')
<div class="container-fluid">
  <div class="card card-default color-palette-box">
    <div class="card-body">
      <div class="row">
        <div class="col-3">
          <input type="text" class="form-control">
        </div>
        <div class="col-12">
          <table id="grid" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
            <thead>
              <tr>
                <th>Nama Lengkap</th>
                <th style="width: 7%;">Nomor Anggota</th>
                <th style="width: 13%;">NIK</th>
                <th>Tempat, Tanggal Lahir</th>
                <th>Jenis Kelamin</th>
                <th>Foto</th>
                <th>Alamat</th>
                <th>Nomor HP</th>
                <th>Pekerjaan</th>
                <th>Pendidikan</th>
                <th>Golongan Darah</th>
                <th>Jenjang Keanggotaan</th>
                <th>Usia Jenjang</th>
                <th>Nama Pembina</th>
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
        dom: '<"row"' +
        '<"col-md-12"tr> <"col-md-12"<"row"<"col-md-5"i><"col-md-7"p>>> >',
        columns: [
          { 
            data: 'nama_lengkap',
          },
          { 
            data: 'nomor_urut',
          },
          { 
            data: 'nik',
            orderable: false,
          },
          { 
            data:'tempat_tanggal_lahir',
            orderable: false,
            render: function(data, type, full, meta){
              if(!meta.settings._responsive.s.current[3])
                return "<br><span>"+data+"<br>("+full.usia+")</span>";
              else
                return "<span>"+data+"<br>("+full.usia+")</span>";
            }
          },
          { 
            data:'jenis_kelamin',
            orderable: false,
          },
          { 
            data:'photo',
            orderable: false,
            render: function(data, type, full, meta){
              if(data)
                return '<img style="height:100px;" src="'+"{{url('storage/images/anggota')}}/"+data+'">';
              else
                return '<img style="height:100px;" src="'+"{{url('img/default_photo.jpg')}}"+'">';
            }
          },
          { 
            data:'alamat',
            orderable: false,
            render: function(data, type, full, meta){
              if( !meta.settings._responsive.s.current[6])
                return "<br><span>"+data+"<br>"+full.village_name+"<br>"+full.districts_name+"<br>"+full.regencies_name+"</span>";
              else
                return "<span>"+data+"<br>"+full.village_name+"<br>"+full.districts_name+"<br>"+full.regencies_name+"</span>";
            }
          },
          { 
            data: 'telp',
            orderable: false,
          },
          { 
            data:'job',
            orderable: false,
          },
          { 
            data:'pendidikan',
            orderable: false,
          },
          { 
            data:'darah',
            orderable: false,
          },
          { 
            data:'nama_jenjang',
            orderable: false,
          },
          { 
            data:'usia_jenjang',
            orderable: false,
            render: function(data, type, full, meta){
              console.log(!meta.settings._responsive.s.current[11])
              if( !meta.settings._responsive.s.current[11])
                return "<br><span>"+data+"<br>("+full.usia_jenjang_raw+")</span>";
              else
                return "<span>"+data+"<br>("+full.usia_jenjang_raw+")</span>";
            }
          },
          { 
            data:'nama_pembina',
            orderable: false,
            render: function(data, type, full, meta){
              console.log(!meta.settings._responsive.s.current[11])
              if( !meta.settings._responsive.s.current[11])
                return "<br><span>"+data+"</span>";
              else
                return "<span>"+data+"</span>";
            }
          },
        ],
      });
    $('#appModal').on('hide.bs.modal', function() {
      $('#appModal').find('.modal-body').html('');
    });

    $('#grid').on('click', '.gridVerif', function(){
      var id = $(this).attr('id')
      Swal.fire({
        icon: 'question',
        title: 'Verifikasi',
        text: "Apakah anda ingin memverifikasi anggota ini?",
        showCancelButton: true,
        confirmButtonText: `Ya`,
        cancelButtonText: `Tidak`,
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            type  : "POST",
            url   : "{{$link}}/"+id,
            success: function(data){
              swal.fire({
                icon: data.status,
                title: data.action,
                text: data.messages
              })
              grid.ajax.reload()
            }
          })
        }
      })
    })

    $('#grid').on('click', '.gridView', function(){
      var id = $(this).attr('id')
      $.ajax({
        type  : "POST",
        url   : "{{$link}}/view/"+id,
        success: function(data){
          let body = ""
          let nik = ""
          if(data.nik){
            nik += data.nik
          }else{
            nik += "NIK KOSONG <i style='color:#fd5000' class='fa fa-exclamation'></i>"
          }
          var winWidth =  $(window).width();
          if( winWidth <= 1199){
            body +=
            "<div class='col-md-12'>"+
              "<div class='row'>"+
                "<strong class='col-12'>Nomor Induk Kependudukan"+"</strong><span class='col-md-12 mb-3'> "+data.nik+"</span>"+
                "<strong class='col-12'>Nama Lengkap"+"</strong><span class='col-md-12 mb-3'> "+data.nama_lengkap+"</span>"+
                "<strong class='col-12'>Nama Panggilan"+"</strong><span class='col-md-12 mb-3'> "+data.nama_panggilan+"</span>"+
                "<strong class='col-12'>Tempat/Tanggal Lahir"+"</strong><span class='col-md-12 mb-3'> "+data.tempat_lahir+", "+data.tanggal_lahir_raw+"</span>"+
                "<strong class='col-12'>Jenis Kelamin"+"</strong><span class='col-md-12 mb-3'> "+data.jenis_kelamin_raw+"</span>"+
                "<strong class='col-12'>Nomor HP"+"</strong><span class='col-md-12 mb-3'> "+data.telp+"</span>"+
                "<strong class='col-12'>Alamat"+"</strong><span class='col-md-12 mb-3'> "+data.alamat+" "+data.villages_name+", "+data.districts_name+", "+data.regencies_name+"</span>"+
                "<strong class='col-12'>Golongan Darah"+"</strong><span class='col-md-12'> "+data.darah+"</span>"
                if(data.ktp){
                  body +=
                  '<div class="col-md-12 mt-3">'+
                    '<strong>Foto KTP</strong>'+
                    '<img class="mt-3" style="height:auto; width:300px; display: block; margin-left: auto; margin-right: auto;" src="'+"{{url('storage/images/ktp')}}/"+data.ktp+'">'+
                  '</div>'
                }
                if(data.photo){
                  body +=
                  '<div class="col-md-12 mt-3">'+
                    '<strong>Foto Diri</strong>'+
                    '<img class="mt-3" style="height:300px; width:auto; display: block; margin-left: auto; margin-right: auto;" src="'+"{{url('storage/images/anggota')}}/"+data.photo+'">'+
                  '</div>'
                }
              body +=
              "</div>"+
            "</div>";        
          }else{
            body +=
            "<div class='col-md-12'>"+
              "<div class='row'>"+
                "<span class='col-md-4 mb-3'>Nomor Induk Kependudukan"+"</span><span class='col-md-8'>: "+nik+"</span>"+
                "<span class='col-md-4 mb-3'>Nama Lengkap"+"</span><span class='col-md-8'>: "+data.nama_lengkap+"</span>"+
                "<span class='col-md-4 mb-3'>Nama Panggilan"+"</span><span class='col-md-8'>: "+data.nama_panggilan+"</span>"+
                "<span class='col-md-4 mb-3'>Tempat/Tanggal Lahir"+"</span><span class='col-md-8'>: "+data.tempat_lahir+", "+data.tanggal_lahir_raw+"</span>"+
                "<span class='col-md-4 mb-3'>Jenis Kelamin"+"</span><span class='col-md-8'>: "+data.jenis_kelamin_raw+"</span>"+
                "<span class='col-md-4 mb-3'>Nomor HP"+"</span><span class='col-md-8'>: "+data.telp+"</span>"+
                "<span class='col-md-4 mb-3'>Alamat"+"</span><span class='col-md-8'>: "+data.alamat+" "+data.villages_name+", "+data.districts_name+", "+data.regencies_name+"</span>"+
                "<span class='col-md-4'>Golongan Darah"+"</span><span class='col-md-8'>: "+data.darah+"</span>"
                if(data.ktp){
                  body +=
                  '<div class="col-md-6 mt-3">'+
                    '<p class="text-center mb-3">Foto KTP</p>'+
                    '<img style="height:auto; width:300px; display: block; margin-left: auto; margin-right: auto;" src="'+"{{url('storage/images/ktp')}}/"+data.ktp+'">'+
                  '</div>'
                }
                if(data.photo){
                  body +=
                  '<div class="col-md-6 mt-3">'+
                    '<p class="text-center mb-3">Foto Diri</p>'+
                    '<img style="height:300px; width:auto; display: block; margin-left: auto; margin-right: auto;" src="'+"{{url('storage/images/anggota')}}/"+data.photo+'">'+
                  '</div>'
                }
              body +=
              "</div>"+
            "</div>";        
          }
          $('#appModal').modal('show'); 
          $('.modal-dialog').addClass('modal-lg')
          $('.modal-header').css("border-bottom-width", "5px")
          $('.modal-header').css("border-bottom-style", "solid")
          $('.modal-header').css("border-bottom-color", "rgb(253, 80, 0)")
          $(".modal-title").html('Detail Anggota')
          $(".btn-dpd").removeClass('d-none')
          $('.btn-dpd').on('click', function(){
            location.href = "{{url('anggota/edit')}}/"+data.id;
          })
          $('#appModal').find('.modal-body').append(body);
        },
        error: function(data){
          alert(1)
        }
      })
    })
  });
</script>
@endsection