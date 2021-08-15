@extends('partials.index')

@section('css')
  <link rel="stylesheet" href="{{asset('css/flatpickr.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/select2/css/select2.min.css')}}">
  <link rel="stylesheet" href="{{asset('css/file-preview.css')}}">
  <link rel="stylesheet" href="{{asset('css/yearpicker.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
  <style>
    .flatpickr {
      background-color: #ffffff !important ;
    }
    .yearpicker {
      background-color: #ffffff !important ;
    }
  </style>
  @yield('css-form')
@endsection

@section('content')
  @yield('content-form')
@endsection

@section('js')
  <script src="{{asset('js/flatpickr.js')}}"></script>
  <script src="{{asset('js/id.js')}}"></script>
  <script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
  <script src="{{asset('js/file-preview.js')}}"></script>
  <script src="{{asset('plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}"></script>
  <script src="{{asset('js/yearpicker.js')}}"></script>
  <script>
  flatpickr(".flatpickr",{"locale": "id"})
  $('.yearpicker').yearpicker();
  </script>
  @yield('js-form')
@endsection