@extends('partials.index')

@section('css')
  <link rel="stylesheet" href="{{asset('plugins/daterangepicker/daterangepicker.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/select2/css/select2.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
  @yield('css-form')
@endsection

@section('content')
  @yield('content-form')
@endsection

@section('js')
  <script src="{{asset('plugins/moment/moment.min.js')}}"></script>
  <script src="{{asset('plugins/moment/locale/id.js')}}"></script>
  <script>moment.locales('id')</script>
  <script src="{{asset('plugins/daterangepicker/daterangepicker.js')}}"></script>
  <script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
  <script src="{{asset('plugins/bs-custom-file-input/bs-custom-file-input.js')}}"></script>
  @yield('js-form')
@endsection