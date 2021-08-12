@extends('partials.form')
<?php $none = isset($data->id) ? 'd-none' : null; ?> 
<?php $col = isset($data->id) ? 'col-md-12' : 'col-md-6'; ?> 
@section('css-table')
@endsection

@section('content-form')
<div class="col-md-12">
  <form class="needs-validation" method="POST" action="{{ url('/user') }}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <div class="row">
      <div class="form-group col-md-6">
        <label for="exampleInputEmail1">Username</label>
        <input type="text" class="form-control" value="{{old('username', $data->username)}}" name="username" placeholder="Username">
      </div>
      <div class="form-group col-md-6 {{$none}}">
        <label for="exampleInputPassword1">Password</label>
        <input type="password" class="form-control" name="password" placeholder="Password">
      </div>
      <div class="form-group col-md-6">
        <label for="exampleInputPassword1">Nama Lengkap</label>
        <input type="text" class="form-control" value="{{old('full_name', $data->full_name)}}" name="full_name" placeholder="Nama Lengkap">
      </div>
      <div class="form-group {{$col}}">
        <label for="exampleInputPassword1">Email</label>
        <input type="email" class="form-control" value="{{old('email', $data->email)}}" name="email" placeholder="Email">
      </div>
    </div>
    <button type="submit" class="btn btn-primary float-right">Submit</button>
  </form> 
</div>
@endsection

@section('js-table')
@endsection