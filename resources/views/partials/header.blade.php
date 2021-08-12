<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1> {{$header}} {!! $title !!}</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          @foreach($breadcrumb as $name => $link)
            <li class="breadcrumb-item active"><a href="{{ url($link) }}">{{ $name }}</a></li>
          @endforeach
        </ol>
      </div>
    </div>
  </div>
</section>