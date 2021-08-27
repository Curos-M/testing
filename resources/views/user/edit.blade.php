@extends('partials.form')
<?php $none = isset($data->id) ? 'd-none' : null; ?> 
<?php $col = isset($data->id) ? 'col-md-12' : 'col-md-6'; ?> 
@section('css-table')
@endsection

@section('content-form')
<div class="container-fluid">
  <div class="card card-default color-palette-box">
    <div class="card-body">
      <div class="col-md-12">
        <form class="needs-validation" method="POST" action="{{ url('/user') }}">
        <input type="hidden" id="id" name="id" value="{{ $data->id }}" />
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
            <label for="password" class="form-label">Peran</label>
              <select name="roles[]" class="select2 form-control select2-multiple" multiple="multiple" multiple data-placeholder="Choose ...">
                @foreach($data->roles as $role)
                <?php $selected = in_array($role, $data->hasRoles) ? 'selected' : null; ?>
                  <option value="{{ $role }}" {!! $selected !!} >{{ $role }}</option>
                @endforeach
              </select>
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

@section('js-table')
@endsection