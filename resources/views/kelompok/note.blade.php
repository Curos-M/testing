@extends('partials.form')
@section('css-form')
@endsection

@section('content-form')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12 mb-3">
      <div class="card card-default color-palette-box">
        <div class="card-body">
          <form id="form" action="{{url($link.'/catatan')}}" method='POST' enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="id_kelompok" value="{{$id}}">
            <div class="form-group col-md-12">
              <label for="exampleInputEmail1">Catatan</label>
              <textarea rows="3" name="catatan" class="form-control"></textarea>
            </div>
          </form>  
          <div class="float-right">
            <a id="addNote" class="btn btn-dpd">Simpan</a>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-12">
      <div class="timeline">
      <?php $parentDate=null?>
        @foreach ($data as $d)
          @if ($d->tanggal != $parentDate)
            <div class="time-label">
              <span class="bg-dpd">{{$d->tanggal}}</span>
            </div>            
          @endif
          <?php $parentDate = $d->tanggal ?>
          <div>
            <i id="note{{$d->id}}" class="fa {{$d->photo ?'fa-image':'fa-sticky-note'}} bg-dpd"></i>
            <div class="timeline-item">
              <span class="time"><i class="fas fa-clock"></i> {{$d->jam}}</span>
              <h3 class="timeline-header"><a href="#">{{$d->full_name}}</a> Menambahkan {{$d->catatan ?'Catatan':''}} {{$d->catatan&&$d->photo ?'dan':''}} {{$d->photo ?'Gambar':''}}</h3>
              <div class="timeline-body">
                {{$d->catatan}}
              </div>
              <div class="timeline-footer">
                <a id="{{$d->id}}" class="btn btn-black deleteNote btn-sm">Hapus</a>
              </div>
            </div>
          </div>  
        @endforeach     
        <div>
          <i class="fas fa-clock bg-gray"></i>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('js-form')
<script>
  $(document).ready(function(){
    $('#addNote').on('click', function(){
      swal.fire({
        title:'Tambah Catatan',
        icon:'question',
        html:'Apakah anda ingin menambah catatan ini?',
        showCancelButton:true,
        confirmButtonText:'Tambah',
        confirmButtonColor:'#fd5000',
        cancelButtonText:'Batal'
      }).then((result) => {
        if(result.isConfirmed){
         $('#form').submit() 
        }
      })
    })
    $('.deleteNote').on('click', function(){
      swal.fire({
        title:'Hapus Catatan',
        icon:'question',
        html:'Apakah anda yakin menghapus catatan ini?',
        showCancelButton:true,
        confirmButtonText:'Hapus',
        confirmButtonColor:'#c82333',
        cancelButtonText:'Batal'
      }).then((result) => {
        if(result.isConfirmed){
          $.ajax({
            type:"DELETE",
            url:this.id,
            success: function(data){
              if(data.id){
                window.location.href = "{{$id}}#note"+data.id
                location.reload()
              }
              else{
                window.location.href = "{{$id}}#"
                location.reload()
              }
            }
          })
        }
      })
    })
  })
</script>
@endsection