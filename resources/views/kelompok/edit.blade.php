@extends('partials.form')
<?php $none = empty($data->id) ? 'd-none' : null; ?> 
<?php $read = isset($data->id) ? 'readonly' : null; ?> 
@section('css-table')
@endsection

@section('content-form')
<div class="container-fluid">
  <div class="card card-default color-palette-box">
    <div class="card-body">
      <div class="col-md-12">
        <form class="needs-validation" method="POST" action="{{ url('/role') }}">
        <input type="hidden" id="id" name="id" value="{{ $data->id }}" />
          <input type="hidden" name="_token" value="{{ csrf_token() }}" />
          <div class="row">
            <div class="form-group col-md-12">
              <label for="exampleInputEmail1">Nama Kelompok</label>
              <input type="text" name="nama_kelompok" value="{{ old('nama_kelompok', $data->nama_kelompok) }}" class="form-control" id="name" {!! $read !!}>
            </div>
            <div class="form-group col-md-12">
              <label for="exampleInputEmail1">Nama Kelompok</label>
              <input type="text" name="name" value="{{ old('nama_kelompok', $data->nama_kelompok) }}" class="form-control" id="name" {!! $read !!}>
            </div>
            <div class="form-group col-md-12">
              <label for="exampleInputEmail1">Nama Kelompok</label>
              <input type="text" name="name" value="{{ old('nama_kelompok', $data->nama_kelompok) }}" class="form-control" id="name" {!! $read !!}>
            </div>
          </div>
          <button type="submit" class="btn btn-dpd float-right ml-2 mt-3">Simpan</button>
          <a href="{{ url('/'.$link) }}" type="button" class="btn btn-black float-right mt-3" type="submit">{{ isset($data->id) ? 'Kembali' : 'Batal' }}</a>
        </form> 
      </div>
    </div>
  </div>
</div>
@endsection

@section('js-form')
<script>
  $(document).ready(function (){
    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    })
  });
</script>
@endsection