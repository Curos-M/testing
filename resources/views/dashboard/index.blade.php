@extends('partials.index')

@section('css')
<link rel="stylesheet" href="{{asset('plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
@endsection

@section('content')
<div class="row">
  <div class="container-fluid">
    <div class="card card-default color-palette-box">
      <div class="card-body {{$data->desa ?'d-none':''}}">
        <div class="row">
          <div class="col-sm-4 {{$data->kota ?'d-none':''}}">
            <select class="form-control selectbs4 form-control-sm" style="width: 100%;" id="kota"></select>
          </div>
          <div class="{{$data->kota ?'col-sm-6':'col-sm-4'}}{{$data->kecamatan ?' d-none':''}}">
            <select {{$data->kota ?'':'disabled'}} class="form-control selectbs4 form-control-sm" style="width: 100%;" id="kecamatan"></select>
          </div> 
          <div class="{{$data->kota?$data->kecamatan?'col-sm-12':'col-sm-6':'col-sm-4'}}">
            <select {{$data->kecamatan ?'':'disabled'}} class="form-control selectbs4 form-control-sm" style="width: 100%;" id="desa"></select>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-5">
    <div class="small-box bg-dpd">
      <div class="inner">
        <h3 id="total"></h3>
        <p>Jumlah Anggota</p>
      </div>
      <div class="icon">
        <i class="fa fa-users"></i>
      </div>
      <a href="{{url('pencarian')}}" class="small-box-footer">
        Ke Pencarian <i class="fas fa-arrow-circle-right"></i>
      </a>
    </div>
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Sebaran Domisili</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-window-minimize"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <canvas id="domisili" style="min-height: 443px; height: 443px; max-height: 443px; max-width: 100%;"></canvas>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Usia</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-window-minimize"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <canvas id="usia" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
      </div>
    </div>
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Jenjang</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-window-minimize"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <canvas id="jenjang" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Jenis Kelamin</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-window-minimize"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <canvas id="gender" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
      </div>
    </div>
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Golongan Darah</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-window-minimize"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <canvas id="darah" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
      </div>
    </div>
  </div>
  <div class="col-md-12">
    <div class="card card-default color-palette-box">
      <div class="card-body">
        <div class="row">
          <div class="col-sm-12">
            <select class="form-control selectbs4 form-control-sm" style="width: 100%;" id="tahun">
              @foreach ($data->tahun as $tahun)
                <option value="{{ $tahun['tahun'] }}" >{{ $tahun['tahun'] }}</option>
              @endforeach
            </select>
          </div>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-header">
        <h3 id="pertumbuhanTitle" class="card-title">Pertumbuhan Anggota</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-window-minimize"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <canvas id="pertumbuhan" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
      </div>
    </div>
  </div>
</div>

@endsection

@section('js')
<script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
<script src="{{url('plugins/chart.js/Chart.min.js')}}"></script>
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
    let gender, darah, usia, jenjang, domisili
    function call()
    {
      $.ajax({
        type: 'POST',
        url: "{{url($link).'/grid'}}",
        data: {
          kota: $('#kota').val(),
          kecamatan: $('#kecamatan').val(),
          desa: $('#desa').val()
        },
        success: function(data){
          $('#total').html(data.total_kader)
          
          gender = new Chart($('#gender').get(0).getContext('2d'), {
            type: 'pie',
            data: {
              labels: [
                  'Laki Laki',
                  'Perempuan',
              ],
              datasets: [
                {
                  data: [data.kader_lk['total'], data.kader_pr['total']],
                  backgroundColor : ['#347dc1', '#cc6594'],
                }
              ]
            },
            options: {
              maintainAspectRatio : false,
              responsive : true,
              legend:{
                onClick: function(){
                },
              } 
            }
          })     
          darah = new Chart($('#darah').get(0).getContext('2d'), {
            type: 'pie',
            data: {
              labels: [
                  'A',
                  'B',
                  'AB',
                  'O'
              ],
              datasets: [
                {
                  data: [data.kader_darah['a'], data.kader_darah['b'], data.kader_darah['ab'], data.kader_darah['o']],
                  backgroundColor : ['#17a2b8', '#e83e8c', '#6f42c1', '#20c997'],
                }
              ]
            },
            options: {
              maintainAspectRatio : false,
              responsive : true,
            }
          })
          jenjang = new Chart($('#jenjang').get(0).getContext('2d'), {
            type: 'bar',
            data: {
              labels  : ['Pemula', 'Siaga', 'Muda', 'Pratama', 'Madya', 'Dewasa', 'Utama'],
              datasets: [
                {
                  backgroundColor     : '#fd5000',
                  borderColor         : 'rgba(210, 214, 222, 1)',
                  pointRadius         : false,
                  pointColor          : 'rgba(210, 214, 222, 1)',
                  pointStrokeColor    : '#c1c7d1',
                  pointHighlightFill  : '#fff',
                  pointHighlightStroke: 'rgba(220,220,220,1)',
                  data                : [data.kader_jenjang['pemula'], 
                                        data.kader_jenjang['siaga'], 
                                        data.kader_jenjang['muda'], 
                                        data.kader_jenjang['pratama'], 
                                        data.kader_jenjang['madya'], 
                                        data.kader_jenjang['dewasa'], 
                                        data.kader_jenjang['utama']]
                },
              ]
            },
            options: {
              responsive              : true,
              maintainAspectRatio     : false,
              datasetFill             : false,
              legend: {
                display: false
              },
              scales: {
                yAxes: [{
                  ticks: {
                    beginAtZero: true,
                    userCallback: function(label, index, labels) {
                      if (Math.floor(label) === label) {
                        return label;
                      }
                    },
                  }
                }]
              },
              tooltips: {
                callbacks: {
                  label: function(tooltipItem) {
                    return tooltipItem.yLabel;
                  }
                }
              }
            }
          })
          usia = new Chart($('#usia').get(0).getContext('2d'), {
            type: 'bar',
            data: {
              labels  : ['<20', '20-29', '30-39', '40-49', '50-59', '60-69', '>70'],
              datasets: [
                {
                  backgroundColor     : '#fd5000',
                  borderColor         : 'rgba(210, 214, 222, 1)',
                  pointRadius         : false,
                  pointColor          : 'rgba(210, 214, 222, 1)',
                  pointStrokeColor    : '#c1c7d1',
                  pointHighlightFill  : '#fff',
                  pointHighlightStroke: 'rgba(220,220,220,1)',
                  data                : [data.kader_usia['<20'], 
                                        data.kader_usia['20-29'], 
                                        data.kader_usia['30-39'], 
                                        data.kader_usia['40-49'], 
                                        data.kader_usia['50-59'], 
                                        data.kader_usia['60-69'], 
                                        data.kader_usia['>70']]
                },
              ]
            },
            options: {
              responsive              : true,
              maintainAspectRatio     : false,
              datasetFill             : false,
              legend: {
                display: false
              },
              scales: {
                yAxes: [{
                  ticks: {
                    beginAtZero: true,
                    userCallback: function(label, index, labels) {
                      if (Math.floor(label) === label) {
                        return label;
                      }
                    },
                  }
                }]
              },
              tooltips: {
                callbacks: {
                  label: function(tooltipItem) {
                    return tooltipItem.yLabel;
                  }
                }
              }
            }
          })
          domisili = new Chart($('#domisili').get(0).getContext('2d'), {
            type: 'bar',
            data: {
              labels  : data.namaDomisili,
              datasets: [
                {
                  backgroundColor     : '#fd5000',
                  borderColor         : 'rgba(210, 214, 222, 1)',
                  pointRadius         : false,
                  pointColor          : 'rgba(210, 214, 222, 1)',
                  pointStrokeColor    : '#c1c7d1',
                  pointHighlightFill  : '#fff',
                  pointHighlightStroke: 'rgba(220,220,220,1)',
                  data                : data.sumDomisili
                },
              ]
            },
            options: {
              responsive              : true,
              maintainAspectRatio     : false,
              datasetFill             : false,
              legend: {
                display: false
              },
              scales: {
                yAxes: [{
                  ticks: {
                    beginAtZero: true,
                    userCallback: function(label, index, labels) {
                      if (Math.floor(label) === label) {
                        return label;
                      }
                    },
                  }
                }]
              },
              tooltips: {
                callbacks: {
                  label: function(tooltipItem) {
                    return tooltipItem.yLabel;
                  }
                }
              }
            }
          })
        }
      })
    }

    function pertumbuhan(){
      $('#pertumbuhanTitle').text("Pertumbuhan Anggota "+$('#tahun').val())
      $.ajax({
        type: 'POST',
        url: "{{url($link).'/pertumbuhan'}}",
        data: {
          tahun: $('#tahun').val()
        },
        success:function(data){
          pertumbuhanChart = new Chart($('#pertumbuhan').get(0).getContext('2d'), {
            type: 'bar',
            data: {
              labels  : ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
              datasets: [
                {
                  backgroundColor     : '#fd5000',
                  borderColor         : 'rgba(210, 214, 222, 1)',
                  pointRadius         : false,
                  pointColor          : 'rgba(210, 214, 222, 1)',
                  pointStrokeColor    : '#c1c7d1',
                  pointHighlightFill  : '#fff',
                  pointHighlightStroke: 'rgba(220,220,220,1)',
                  data                : 
                                      [
                                        data['jan'], 
                                        data['feb'], 
                                        data['mar'], 
                                        data['apr'], 
                                        data['mei'], 
                                        data['jun'], 
                                        data['jul'],
                                        data['agu'],
                                        data['sep'],
                                        data['okt'],
                                        data['nov'],
                                        data['des']
                                      ]
                },
              ]
            },
            options: {
              responsive              : true,
              maintainAspectRatio     : false,
              datasetFill             : false,
              legend: {
                display: false
              },
              scales: {
                yAxes: [{
                  ticks: {
                    beginAtZero: true,
                    userCallback: function(label, index, labels) {
                      if (Math.floor(label) === label) {
                        return label;
                      }
                    },
                  }
                }]
              },
              tooltips: {
                callbacks: {
                  label: function(tooltipItem) {
                    return tooltipItem.yLabel;
                  }
                }
              }
            }
          })
        }
      })
    }
    $('#tahun').on('change', function(){
      pertumbuhan();
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
      destroyChart(gender, usia ,jenjang ,darah, domisili)
      call()
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
      destroyChart(gender, usia ,jenjang ,darah, domisili)
      call()
      desa()
    })
    $('#desa').on('change', function(){
      destroyChart(gender, usia ,jenjang ,darah, domisili)
      call()
    })
    function destroyChart(a, b, c, d, e)
    {
        a.destroy()
        b.destroy()
        c.destroy()
        d.destroy()
        e.destroy()
    }
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
    call()
    pertumbuhan()


  });
</script>
@endsection