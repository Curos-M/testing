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
              <label for="exampleInputEmail1">Username</label>
              <input type="text" name="name" value="{{ old('name', $data->name) }}" class="form-control" id="name" {!! $read !!}>
            </div>
            <div class="form-group col-md-12 {{$none}}">
              <label for="username" class="form-label mb-0">User</label>
              <div class="col-12 mt-0">
                <div class="row">
                  @foreach($data->user as $user)
                    <h4><span class="badge bg-dpd ml-2">{{ $user->full_name }}</span></h4>
                  @endforeach
                </div>
              </div>
              <hr>
            </div>
            <div class="col-md-12 my-5">
              <legend>Hak Akses</legend>
              <div class="row row-sm mg-b-10">
                @foreach($perms as $perm)
                  <div class="col-lg-4">
                    <div class="card">
                      <div class="card-body">
                        <h4><b>{{ $perm->module}}</b></h4>
                        @foreach($perm->actions as $act)
                          <div class="d-flex justify-content-between mx-3 my-3">
                            <label>{{$act->raw}}</label>
                            <?php $checkedStr = $act->active ? 'checked="checked"' : null; ?> 
                            <div class="custom-control custom-switch">
                              <input data-bootstrap-switch name="roleperms[]" value="{{ $act->value }}" data-on-color="dpd" type="checkbox" id="{{ $act->value }}" switch="none" {!! $checkedStr !!} >
                              <label class="form-label" for="{{ $act->value }}" data-on-label="Ya"  data-off-label="X"></label>
                            </div>
                          </div>
                        @endforeach
                      </div>
                    </div>
                  </div>
                @endforeach    
              </div>
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