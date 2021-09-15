@extends('partials.table')

@section('css-table')
<link rel="stylesheet" href="{{asset('plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
@endsection

@section('content-table')
<div class="container-fluid">
  <div class="card card-default color-palette-box">
    <div class="card-body">
      <div class="col-12">
        <div class="row">
          <div class="col-sm-4">
            <select class="form-control selectbs4 form-control-sm" style="width: 100%;" name="regencies_id" id="kota"></select>
          </div>
          <div class="col-sm-4">
            <select disabled class="form-control selectbs4 form-control-sm" style="width: 100%;" name="districts_id"  id="kecamatan"></select>
          </div>
          <div class="col-sm-4">
            <select disabled class="form-control selectbs4 form-control-sm" style="width: 100%;" id="desa" name="villages_id"></select>
          </div>
        </div>
      </div>
      <div class="col-12 mt-2">
        <div class="row">
          <div class="col-sm-3">
            <input disabled id="search" type="text" class="form-control form-control-sm" placeholder="Cari">
          </div>
          <div class="col-sm-2">
            <select id="type" class="form-control form-control-sm">
              <option value="0">Pilih....</option>
              <option value="1">Nama Lengkap</option>
              <option value="2">Nomor Anggota</option>
              <option value="3">NIK</option>
            </select>
          </div>
        </div>
      </div>
      <div class="col-12 mt-2">
        <div class="row">
          <div class="col-sm-3">
            <select id="jenjang" class="form-control form-control-sm extra">
              <option value="0">Semua Jenjang</option>
              @foreach ($jenjang as $j )
                <option value="{{$j->id}}">{{$j->nama}}</option>
              @endforeach
            </select>
          </div>
          <div class="col-sm-3">
            <select id="darah" class="form-control form-control-sm ekstra">
              <option value="0">Semua Golongan Darah</option>
              <option>A</option>
              <option>B</option>
              <option>AB</option>
              <option>O</option>
            </select>
          </div>
        </div>
      </div>
      <div class="col-12 mt-2">
        <div class="row">
          <div class="col-sm-6">
            <select class="form-control selectbs4" style="width: 100%;" id="pembina"></select>
          </div>
        </div>
      </div>
      <div class="col-12 mt-2">
        <div class="row">
          <div class="col-sm-6">
            <select id="umur" class="form-control form-control-sm ekstra">
              <option value="0">Semua Usia</option>
              <option value="1">Dibawah 20</option>
              <option value="2">20-29</option>
              <option value="3">30-39</option>
              <option value="4">40-49</option>
              <option value="5">50-59</option>
              <option value="6">60-69</option>
              <option value="7">70 Keatas</option>
            </select>
          </div>
        </div>
      </div>
      <div class="col-12 mt-2">
        <div class="float-right">
          <button class="btn btn-dpd" id="button">Cari</button>
        </div>
      </div>
      <div class="col-12 mt-5">
        <table id="grid" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
          <thead>
            <tr>
              <th>Nama Lengkap</th>
              <th>Nomor Anggota</th>
              <th>NIK</th>
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
@endsection

@section('js-table')
<script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
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
    let grid = $('#grid').DataTable({
      dom: '<"row"' +
      '<"col-md-12"tr> <"col-md-12"<"row"<"col-md-5"i><"col-md-7"p>>> >',
      deferLoading: false,
      ajax: {
        url: "{{ url($link.'/grid') }}",
        dataSrc: 'data',
        data: function (d) {
          d.type = $('#type').val();
          d.search = $('#search').val();
          d.darah = $('#darah').val();
          d.jenjang = $('#jenjang').val();
          d.umur = $('#umur').val();
          d.pembina = $('#pembina').val();
          d.kota = $('#kota').val()
          d.kecamatan = $('#kecamatan').val()
          d.desa = $('#desa').val();
        }
      },
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
            if( !meta.settings._responsive.s.current[11])
              return "<br><span>"+data+"</span>";
            else
              return "<span>"+data+"</span>";
          }
        },
      ],
    });
    
    $("#button").on("click", function() {
      $('#grid').dataTable().fnDraw();
    });

    $('#type').on('change', function() {
      if(this.value == 0){
        $('#search').attr('disabled', true)
        $('#search').val('')
      }else{
        $('#search').removeAttr('disabled');
      }   
    })

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

    camat()
    desa()


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
    
  });
</script>
@endsection