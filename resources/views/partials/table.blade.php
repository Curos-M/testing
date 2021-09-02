@extends('partials.index')

@section('css')
  <link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
  @yield('css-table')
@endsection

@section('content')
  @yield('content-table')
@endsection

@section('js')
  <script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
  <script src="{{asset('plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
  <script src="{{asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
  <script src="{{asset('plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
  <script src="{{asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
  <script src="{{asset('plugins/jszip/jszip.min.js')}}"></script>
  <script src="{{asset('plugins/pdfmake/pdfmake.min.js')}}"></script>
  <script src="{{asset('plugins/pdfmake/vfs_fonts.js')}}"></script>
  <script src="{{asset('plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
  <script src="{{asset('plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
  <script src="{{asset('plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
  <script>
    $.extend( true, $.fn.dataTable.defaults, {
      ajax: {
          url: "{{ url($link.'/grid') }}",
          dataSrc: 'data'
      },
      dom: '<"row"' +
        '<"col-md-12"<"row"<"col-md-6"B><"col-md-6"f> > >' +
        '<"col-md-12"tr> <"col-md-12"<"row"<"col-md-5"i><"col-md-7"p>>> >',
      buttons: [
        { 
          text: "Tambah Baru",
          className: "{{$canAdd ? 'btn btn-dpd' : 'd-none'}}",
          action: function ( e, dt, node, config ) {
              window.location = "{{ url($link.'/edit') }}";   
          }
        }
      ],
      processing: true,
      serverSide: true,
      oLanguage: {
        oPaginate: { "sPrevious": '<', "sNext": '>' },
        sInfo: "Menampilkan _START_ - _END_ data (dari _MAX_)",
        sLengthMenu: "Hasil :  _MENU_",
        sEmptyTable: "Data Tidak Ditemukan",
        sInfoEmpty: "",
        sZeroRecords: "Tidak ada data yang bisa ditampilkan",
        sProcessing: "<i class='fa fa-spinner fa-spin'></i>",
        sSearch: 'Cari',
        sInfoFiltered: "- Total Pencarian _TOTAL_"
      },
      stripeClasses: [],
      lengthMenu: [10, 20, 50],
      pageLength: 10,
    });
  </script>
  @yield('js-table')
@endsection