@extends('partials.index')

@section('css')
@endsection

@section('content')
<div class="row">
  <div class="col-xl-5">
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
        <h3 class="card-title">Jenjang Keanggotaan</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-window-minimize"></i>
          </button>
        </div>
      </div>
        <div class="card-body">
          <canvas id="jenjang" style="min-height: 443px; height: 443px; max-height: 443px; max-width: 100%;"></canvas>
        </div>
    </div>
  </div>
  <div class="col-xl-4">
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
          <canvas id="usia" style="min-height: 250px; height: 400px; max-height: 500px; max-width: 100%;"></canvas>
        </div>
    </div>
  </div>
  <div class="col-xl-3">
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
</div>

@endsection

@section('js')
<script src="{{url('plugins/chart.js/Chart.min.js')}}"></script>
<script>
  $(document).ready(function (){
    $.ajax({
      type: 'POST',
      url: "{{url($link).'/grid'}}",
      success: function(data){
        $('#total').html(data.total_kader)
        new Chart($('#gender').get(0).getContext('2d'), {
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
        new Chart($('#darah').get(0).getContext('2d'), {
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
        new Chart($('#jenjang').get(0).getContext('2d'), {
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
            tooltips: {
              callbacks: {
                label: function(tooltipItem) {
                  return tooltipItem.yLabel;
                }
              }
            }
          }
        })
        new Chart($('#usia').get(0).getContext('2d'), {
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
  });
</script>
@endsection